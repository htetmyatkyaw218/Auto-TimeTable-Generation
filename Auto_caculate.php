<?php include('conn.php');
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Allow regeneration using session data when no POST payload is present
$acdyear = $_POST['acdyear'] ?? ($_SESSION['acdyear'] ?? null);
$semester = $_POST['semester'] ?? ($_SESSION['semester'] ?? null);
$year_name = $_POST['year_name'] ?? ($_SESSION['year_name'] ?? null);
$section_name = $_POST['section_name'] ?? ($_SESSION['section_name'] ?? null);

// Decode POSTed lists when available; otherwise fall back to stored session copies
$TeacherList = isset($_POST['TeacherList']) ? json_decode($_POST['TeacherList'], true) : ($_SESSION['TeacherList'] ?? null);
$SubjectList = isset($_POST['SubjectList']) ? json_decode($_POST['SubjectList'], true) : ($_SESSION['SubjectList'] ?? null);
$Subject_count = isset($_POST['Subject_count']) ? (int)$_POST['Subject_count'] : ($_SESSION['Subject_count'] ?? null);
$PeriodPerDay = isset($_POST['PeriodPerDay']) ? (int)$_POST['PeriodPerDay'] : ($_SESSION['PeriodPerDay'] ?? null);

// If we still don't have the basics, send user back to start
if (!$acdyear || !$semester || !$year_name || !$section_name || $Subject_count === null || $PeriodPerDay === null || $SubjectList === null || $TeacherList === null) {
    header('Location: auto.php?status=error');
    exit;
}

// Refresh session with the current values for reuse (including regenerate flow)
$_SESSION['acdyear'] = $acdyear;
$_SESSION['semester'] = $semester;
$_SESSION['year_name'] = $year_name;
$_SESSION['section_name'] = $section_name;
$_SESSION['Subject_count'] = $Subject_count;
$_SESSION['PeriodPerDay'] = $PeriodPerDay;
$_SESSION['TeacherList'] = $TeacherList;
$_SESSION['SubjectList'] = $SubjectList;

// reset previously generated slots so a new run doesn't append old results
$_SESSION['dt1'] = array();
$_SESSION['dt2'] = array();
$_SESSION['scode1'] = array();
$_SESSION['sname1'] = array();

class FirstTimetableObj
{
    public $day;
    public $time;

    public function __construct($d, $t)
    {
        $this->day = $d;
        $this->time = $t;
    }
}
class SecondTimetableObj
{
    public $scode;
    public $sname;
    public $day1;
    public $time1;
    public $day2;
    public $time2;

    public function __construct($a1, $a2, $a3, $a4, $a5, $a6)
    {
        $this->scode = $a1;
        $this->sname = $a2;
        $this->day1 = $a3;
        $this->time1 = $a4;
        $this->day2 = $a5;
        $this->time2 = $a6;
    }
}
class ThirdTimetableObj
{
    public $scode1;
    public $sname1;
    public $dt1;
    public $dt2;

    public function __construct($a1, $a2, $a3, $a4)
    {
        $this->scode1 = $a1;
        $this->sname1 = $a2;
        $this->dt1 = $a3;
        $this->dt2 = $a4;
    }
}

// ==================== TEACHER CONFLICT AVOIDANCE SYSTEM ====================
class TeacherAssignment
{
    public $teacher;
    public $assignedSlots;

    public function __construct($teacher)
    {
        $this->teacher = $teacher;
        $this->assignedSlots = array();
    }

    public function hasConflict($day, $time)
    {
        $slot = $day . "_" . $time;
        return in_array($slot, $this->assignedSlots);
    }

    public function assignSlot($day, $time)
    {
        $slot = $day . "_" . $time;
        $this->assignedSlots[] = $slot;
    }
}

// Get all teacher assignments from database to avoid conflicts
function getExistingTeacherAssignments($db)
{
    // Bail out safely if no connection (prevents "call on null" fatals)
    if (!($db instanceof mysqli)) {
        return array();
    }

    // If the timetable_assignments table is missing, skip lookups gracefully
    $tableExists = false;
    if ($result = $db->query("SHOW TABLES LIKE 'timetable_assignments'")) {
        $tableExists = $result->num_rows > 0;
        $result->free();
    }
    if (!$tableExists) {
        return array();
    }

    $teacherAssignments = array();

    // Get existing timetable assignments for all teachers
    $sql = "SELECT DISTINCT teacher_name, day_of_week, period_time 
            FROM timetable_assignments 
            WHERE academic_year = ? AND semester = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ss", $_SESSION['acdyear'], $_SESSION['semester']);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $teacher = $row['teacher_name'];
        if (!isset($teacherAssignments[$teacher])) {
            $teacherAssignments[$teacher] = new TeacherAssignment($teacher);
        }
        $teacherAssignments[$teacher]->assignSlot($row['day_of_week'], $row['period_time']);
    }

    return $teacherAssignments;
}

// Normalize teacher strings (can be comma-separated) into a clean array of names
function normalizeTeachers($raw)
{
    if (is_array($raw)) {
        $parts = $raw;
    } else {
        $parts = explode(',', (string) $raw);
    }
    $parts = array_map('trim', $parts);
    return array_values(array_filter($parts, function ($v) {
        return $v !== '';
    }));
}

// Helper: check if any teacher already has slot
function teachersHaveConflict($teachers, $day, $time, $existingAssignments, $newAssignments)
{
    foreach ($teachers as $teacher) {
        if (isset($existingAssignments[$teacher]) && $existingAssignments[$teacher]->hasConflict($day, $time)) {
            return true;
        }
        if (isset($newAssignments[$teacher]) && $newAssignments[$teacher]->hasConflict($day, $time)) {
            return true;
        }
    }
    return false;
}

// Assign a slot to all provided teachers
function assignSlotToTeachers($teachers, $day, $time, &$newAssignments)
{
    foreach ($teachers as $teacher) {
        if (!isset($newAssignments[$teacher])) {
            $newAssignments[$teacher] = new TeacherAssignment($teacher);
        }
        $newAssignments[$teacher]->assignSlot($day, $time);
    }
}

// Initialize teacher assignments
$existingTeacherAssignments = getExistingTeacherAssignments($con);
$newTeacherAssignments = array();
$conflictSlots = array(); // track slots where a conflict was unavoidable

// Normalize teacher list per subject for multi-teacher handling
$normalizedTeacherList = array();
if (is_array($TeacherList)) {
    foreach ($TeacherList as $idx => $rawTeacher) {
        $normalizedTeacherList[$idx] = normalizeTeachers($rawTeacher);
    }
}

function parseSlotString($slotStr)
{
    if (preg_match('/^([^(]+)\((\d+)\)$/', $slotStr, $m)) {
        return array($m[1], (int)$m[2]);
    }
    return array(null, null);
}

// ==================== TIMETABLE GENERATION ====================
for ($a = 1; $a <= $PeriodPerDay; $a++) {
    $monday[$a] = new FirstTimetableObj("Monday", $a);
    $tuesday[$a] = new FirstTimetableObj("Tuesday", $a);
    $wednesday[$a] = new FirstTimetableObj("Wednesday", $a);
    $thursday[$a] = new FirstTimetableObj("Thursday", $a);
    $friday[$a] = new FirstTimetableObj("Friday", $a);
}

function shuffle_recursive(&$arr)
{
    shuffle($arr);
    foreach ($arr as &$v) {
        if (gettype($v) == "array") {
            shuffle($v);
        }
    }
}

$timetable = array();
array_push($timetable, $monday);
array_push($timetable, $tuesday);
array_push($timetable, $wednesday);
array_push($timetable, $thursday);
array_push($timetable, $friday);

// Initialize arrays
$firstDay = array();
$firstTime = array();
$secondDay = array();
$secondTime = array();
$subT = array();
$secondSubT = array();

for ($b = 0; $b < $Subject_count; $b++) {
    $subT[$b] = new FirstTimetableObj("selfstudy", 4);
    $secondSubT[$b] = new FirstTimetableObj("selfstudy", 5);
}

for ($i = 0; $i < count($subT); $i++) {
    $currentTeachers = isset($normalizedTeacherList[$i]) ? $normalizedTeacherList[$i] : array();

    // Initialize new assignment for this teacher if not exists
    foreach ($currentTeachers as $teacherName) {
        if (!isset($newTeacherAssignments[$teacherName])) {
            $newTeacherAssignments[$teacherName] = new TeacherAssignment($teacherName);
        }
    }

    // First slot assignment with teacher conflict check
    $aa = true;
    $attemptCount1 = 0;
    while ($aa && $attemptCount1 < 200) {
        $attemptCount1++;
        shuffle_recursive($timetable);
        $bb = $timetable[0][0]->day;
        $num = $timetable[0][0]->time;

        if ($bb !== "NoData") {
            // Check teacher conflict in existing assignments AND new assignments
            $hasConflict = teachersHaveConflict($currentTeachers, $bb, $num, $existingTeacherAssignments, $newTeacherAssignments);

            if (!$hasConflict) {
                $subT[$i] = $timetable[0][0];
                unset($timetable[0][0]);
                $timetable[0][0] = new FirstTimetableObj("NoData", 7);

                // Assign slot to teacher in new assignments
                assignSlotToTeachers($currentTeachers, $bb, $num, $newTeacherAssignments);

                $firstDay[$i] = $subT[$i]->day;
                $firstTime[$i] = $subT[$i]->time;
                $aa = false;
            }
        }
    }
    // Fallback: if we couldn't find a conflict-free slot, pick the first available even if conflicting
    if ($aa) {
        for ($k = 0; $k < count($timetable) && $aa; $k++) {
            foreach ($timetable[$k] as $idx => $slot) {
                if ($slot->day !== "NoData") {
                    $bb = $slot->day;
                    $num = $slot->time;
                    $subT[$i] = $slot;
                    $timetable[$k][$idx] = new FirstTimetableObj("NoData", 7);
                    assignSlotToTeachers($currentTeachers, $bb, $num, $newTeacherAssignments);
                    $firstDay[$i] = $bb;
                    $firstTime[$i] = $num;
                    if (teachersHaveConflict($currentTeachers, $bb, $num, $existingTeacherAssignments, $newTeacherAssignments)) {
                        $conflictSlots[] = $bb . "(" . $num . ")";
                    }
                    $aa = false;
                    break;
                }
            }
        }
    }

    // Second slot assignment with teacher conflict check
    $ff = true;
    $attemptCount2 = 0;
    while ($ff && $attemptCount2 < 200) {
        $attemptCount2++;
        shuffle_recursive($timetable);
        $cc = $timetable[0][0]->day;
        $x = $timetable[0][0]->time;

        if ($cc != "NoData" && $x != 7) {
            // Check teacher conflict and same subject constraints
            $sameDayTime = ($firstDay[$i] == $cc && $firstTime[$i] == $x);

            $hasConflict = $sameDayTime ? true : teachersHaveConflict($currentTeachers, $cc, $x, $existingTeacherAssignments, $newTeacherAssignments);

            if (!$hasConflict && !$sameDayTime) {
                $secondSubT[$i] = $timetable[0][0];
                $s1 = $secondSubT[$i]->day;
                $t1 = $secondSubT[$i]->time;

                // Assign slot to teacher
                assignSlotToTeachers($currentTeachers, $s1, $t1, $newTeacherAssignments);
                $ff = false;
            }
        }
    }
    // Fallback for second slot: if still not placed, assign first available (avoiding identical slot if possible)
    if ($ff) {
        for ($k = 0; $k < count($timetable) && $ff; $k++) {
            foreach ($timetable[$k] as $idx => $slot) {
                if ($slot->day !== "NoData") {
                    if ($slot->day == $firstDay[$i] && $slot->time == $firstTime[$i]) {
                        continue;
                    }
                    $s1 = $slot->day;
                    $t1 = $slot->time;
                    $secondSubT[$i] = $slot;
                    $timetable[$k][$idx] = new FirstTimetableObj("NoData", 7);
                    assignSlotToTeachers($currentTeachers, $s1, $t1, $newTeacherAssignments);
                    if (teachersHaveConflict($currentTeachers, $s1, $t1, $existingTeacherAssignments, $newTeacherAssignments)) {
                        $conflictSlots[] = $s1 . "(" . $t1 . ")";
                    }
                    $ff = false;
                    break;
                }
            }
        }
    }

    $s1 = $secondSubT[$i]->day;
    $t1 = $secondSubT[$i]->time;

    $flag = true;
    while ($flag) {
        if ($firstDay[$i] == $s1 || $firstTime[$i] == $t1) {
            //check one subject on same day or same time
            $jj = true;
            while ($jj) {
                shuffle_recursive($timetable);
                $dd = $timetable[0][0]->day;
                $y = $timetable[0][0]->time;
                if ($dd != "NoData" && $y != 7) {
                    // Check teacher conflict for new slot
                    $hasConflict = teachersHaveConflict($currentTeachers, $dd, $y, $existingTeacherAssignments, $newTeacherAssignments);

                    if (!$hasConflict) {
                        $secondSubT[$i] = $timetable[0][0];
                        $s1 = $secondSubT[$i]->day;
                        $t1 = $secondSubT[$i]->time;

                        // Assign new slot to teacher
                        assignSlotToTeachers($currentTeachers, $s1, $t1, $newTeacherAssignments);
                        $jj = false;
                    }
                }
            }
        }

        if (($firstDay[$i] != $s1) && ($firstTime[$i] != $t1)) {
            $secondSubT[$i]->day = $s1;
            $secondSubT[$i]->time = $t1;
            $flag = false;
        }
    }

    $secondDay[$i] = $secondSubT[$i]->day;
    $secondTime[$i] = $secondSubT[$i]->time;

    for ($k = 0; $k < count($timetable); $k++) {
        for ($n = 0; $n < count($timetable[$k]); $n++) {
            if ($secondDay[$i] == $timetable[$k][$n]->day && $secondTime[$i] == $timetable[$k][$n]->time) {
                unset($timetable[$k][$n]);
                $timetable[$k][$n] = new FirstTimetableObj("NoData", 7);
            }
        }
    }
}

//combine day and time 
for ($i = 0; $i < $Subject_count; $i++) {
    $timeone[$i] = $firstDay[$i] . "(" . $firstTime[$i] . ")";
    $timetwo[$i] = $secondDay[$i] . "(" . $secondTime[$i] . ")";
}

// Post-process: flag conflicts across all teachers/slots and against existing assignments
$finalConflictSlots = $conflictSlots;
$teacherSlotCounts = array();

for ($i = 0; $i < $Subject_count; $i++) {
    $teachers = isset($normalizedTeacherList[$i]) ? $normalizedTeacherList[$i] : array();
    $slots = array($timeone[$i], $timetwo[$i]);
    foreach ($teachers as $teacher) {
        foreach ($slots as $slotStr) {
            list($d, $t) = parseSlotString($slotStr);
            if ($d === null) {
                continue;
            }
            if (!isset($teacherSlotCounts[$teacher])) {
                $teacherSlotCounts[$teacher] = array();
            }
            if (!isset($teacherSlotCounts[$teacher][$slotStr])) {
                $teacherSlotCounts[$teacher][$slotStr] = 0;
            }
            $teacherSlotCounts[$teacher][$slotStr] += 1;
            if ($teacherSlotCounts[$teacher][$slotStr] > 1) {
                $finalConflictSlots[] = $slotStr;
            }
            // Check against existing assignments from other classes (defensive guard)
            if (isset($existingTeacherAssignments[$teacher]) && $existingTeacherAssignments[$teacher] instanceof TeacherAssignment && $existingTeacherAssignments[$teacher]->hasConflict($d, $t)) {
                $finalConflictSlots[] = $slotStr;
            }
        }
    }
}

$conflictSlots = array_values(array_unique($finalConflictSlots));

// Save teacher assignments for conflict checking in future
$_SESSION['teacher_assignments'] = $newTeacherAssignments;
$_SESSION['conflict_slots'] = $conflictSlots;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>University Timetable Management System</title>
    <meta
        content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
        name="viewport" />
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/Timetable/icon.png">
    <!-- Fonts and icons -->
    <script src="assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["assets/css/fonts.min.css"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/plugins.min.css" />
    <link rel="stylesheet" href="assets/css/kaiadmin.min.css" />

</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="dark">
            <div class="sidebar-logo">
                <!-- Logo Header -->
                <div class="logo-header" data-background-color="dark">
                    <a href="index.php" class="logo">
                        <img
                            src="assets/img/Timetable/logo.png"
                            alt="navbar brand"
                            class="navbar-brand"
                            height="70"
                            width="150" />
                    </a>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar">
                            <i class="gg-menu-right"></i>
                        </button>
                        <button class="btn btn-toggle sidenav-toggler">
                            <i class="gg-menu-left"></i>
                        </button>
                    </div>
                    <button class="topbar-toggler more">
                        <i class="gg-more-vertical-alt"></i>
                    </button>
                </div>
                <!-- End Logo Header -->
            </div>
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <ul class="nav nav-secondary">
                        <li class="nav-item active">
                            <a href="index.php">
                                <i class="fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                            <h4 class="text-section">Components</h4>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="collapse" href="#base">
                                <i class="icon-settings"></i>
                                <p>Setting</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="base">
                                <ul class="nav nav-collapse">
                                    <li><a href="department.php"><span class="sub-item">Department</span></a></li>
                                    <li><a href="rank.php"><span class="sub-item">Rank</span></a></li>
                                    <li><a href="section.php"><span class="sub-item">Section</span></a></li>
                                    <li><a href="year.php"><span class="sub-item">Year</span></a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarLayouts">
                                <i class="icon-plus"></i>
                                <p>Add Data</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="sidebarLayouts">
                                <ul class="nav nav-collapse">
                                    <li><a href="teacher.php"><span class="sub-item">Teacher</span></a></li>
                                    <li><a href="workload.php"><span class="sub-item">Teacher Workload</span></a></li>
                                    <li><a href="subject.php"><span class="sub-item">Subject</span></a></li>
                                    <li><a href="period.php"><span class="sub-item">Period</span></a></li>
                                    <li><a href="Assign_Teacher.php"><span class="sub-item">Assign Teacher</span></a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="collapse" href="#forms">
                                <i class="fas fa-calculator"></i>
                                <p>Calculate Timetable</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="forms">
                                <ul class="nav nav-collapse">
                                    <li><a href="TimeTable.php"><span class="sub-item">TimeTable</span></a></li>
                                    <li><a href="auto.php"><span class="sub-item">Auto Generating</span></a></li>
                                    <li><a href="manual.php"><span class="sub-item">Manual</span></a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo">
                    <!-- Logo Header -->
                    <div class="logo-header" data-background-color="dark">
                        <a href="index.php" class="logo">
                            <img
                                src="assets/img/Timetable/logo.jpg"
                                alt="navbar brand"
                                class="navbar-brand"
                                height="20" />
                        </a>
                        <div class="nav-toggle">
                            <button class="btn btn-toggle toggle-sidebar">
                                <i class="gg-menu-right"></i>
                            </button>
                            <button class="btn btn-toggle sidenav-toggler">
                                <i class="gg-menu-left"></i>
                            </button>
                        </div>
                        <button class="topbar-toggler more">
                            <i class="gg-more-vertical-alt"></i>
                        </button>
                    </div>
                    <!-- End Logo Header -->
                </div>
                <!-- Navbar Header -->
                <nav
                    class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                    <div class="container-fluid">
                        <nav
                            class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="submit" class="btn btn-search pe-1">
                                        <i class="fa fa-search search-icon"></i>
                                    </button>
                                </div>
                                <input
                                    type="text"
                                    placeholder="Search ..."
                                    class="form-control" />
                            </div>
                        </nav>

                        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                            <li
                                class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
                                <a
                                    class="nav-link dropdown-toggle"
                                    data-bs-toggle="dropdown"
                                    href="#"
                                    role="button"
                                    aria-expanded="false"
                                    aria-haspopup="true">
                                    <i class="fa fa-search"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-search animated fadeIn">
                                    <form class="navbar-left navbar-form nav-search">
                                        <div class="input-group">
                                            <input
                                                type="text"
                                                placeholder="Search ..."
                                                class="form-control" />
                                        </div>
                                    </form>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
                <!-- End Navbar -->
            </div>

            <div class="container">
                <div class="page-inner">
                    <div class="page-header">
                        <h4 class="page-title">Dashboard</h4>
                        <ul class="breadcrumbs">
                            <li class="nav-home"><a href="index.php"><i class="icon-home"></i></a></li>
                            <li class="separator"><i class="icon-arrow-right"></i></li>
                            <li class="nav-item"><a href="auto.php">Calculate Timetable</a></li>
                            <li class="separator"><i class="icon-arrow-right"></i></li>
                            <li class="nav-item"><a href="auto.php">Auto Generating</a></li>
                        </ul>
                    </div>

                    <div class="page-category">
                        <div class="col-md-12">
                            <div class="card">
                                <form action="Auto_generate.php" method="post">
                                    <div class="card-header">
                                        <div class="d-flex align-items-center">
                                            <h4 class="card-title">University Timetable Schedule</h4>
                                        </div>
                                        <p class="text-muted mb-0">Teacher conflict checking is applied automatically.</p>
                                    </div>
                                    <div class="card-body">
                                        <div class="card mb-4 border">
                                            <div class="card-header pb-2">
                                                <h5 class="mb-0">Teacher Assignment Summary</h5>
                                                <small class="text-muted">Review generated slots for each subject and teacher.</small>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <?php
                                                    $i = 0;
                                                    foreach ($SubjectList as $data) {
                                                        $scode[$i] = $data["scode"];
                                                        $sname[$i] = $data["sname"];
                                                        $i++;
                                                    }
                                                    for ($i = 0; $i < $Subject_count; $i++) {
                                                        $finalTimetable[$i] = new SecondTimetableObj(
                                                            $scode[$i],
                                                            $sname[$i],
                                                            $firstDay[$i],
                                                            $firstTime[$i],
                                                            $secondDay[$i],
                                                            $secondTime[$i]
                                                        );
                                                    }

                                                    for ($i = 0; $i < $Subject_count; $i++) {
                                                        $finalTimetableNew[$i] = new ThirdTimetableObj(
                                                            $scode[$i],
                                                            $sname[$i],
                                                            $timeone[$i],
                                                            $timetwo[$i]
                                                        );
                                                    }
                                                    ?>
                                                    <table
                                                        id="add-row"
                                                        class="display table table-hover table-bordered mb-0">
                                                        <thead class="table-info">
                                                            <tr>
                                                                <th style="width:20%;">Subject Code</th>
                                                                <th>Subject Name</th>
                                                                <th>Teacher</th>
                                                                <th>First Day And Time</th>
                                                                <th>Second Day And Time</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            foreach ($finalTimetableNew as $key => $value) {
                                                                $teacherName = isset($TeacherList[$key]) ? $TeacherList[$key] : "Not Assigned";
                                                                $firstHasConflict = in_array($value->dt1, $conflictSlots, true);
                                                                $secondHasConflict = in_array($value->dt2, $conflictSlots, true);
                                                            ?>
                                                                <tr>
                                                                    <td class='fw-bold'><?php echo $value->scode1; ?></td>
                                                                    <td><?php echo $value->sname1; ?></td>
                                                                    <td><?php echo $teacherName; ?></td>
                                                                    <td class="<?php echo $firstHasConflict ? 'text-danger fw-semibold' : ''; ?>"><?php echo $value->dt1; ?></td>
                                                                    <td class="<?php echo $secondHasConflict ? 'text-danger fw-semibold' : ''; ?>"><?php echo $value->dt2; ?></td>
                                                                </tr>
                                                            <?php
                                                                $_SESSION['scode1'][] = $value->scode1;
                                                                $_SESSION['sname1'][] = $value->sname1;
                                                                $_SESSION['dt1'][] = $value->dt1;
                                                                $_SESSION['dt2'][] = $value->dt2;
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-header">
                                            <div style="padding-left: 2%;">
                                                <?php
                                                for ($k = 0; $k < count($timetable); $k++) {
                                                    for ($n = 0; $n < count($timetable[$k]); $n++) {
                                                        if ($timetable[$k][$n]->day !== "NoData") {
                                                ?>
                                                            <p>Self Study : <?php echo $timetable[$k][$n]->day . ', ' . $timetable[$k][$n]->time; ?> </p>
                                                <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="card-action d-flex gap-2 flex-wrap">
                                            <button class="btn btn-outline-success btn-round" name="caculate"><i class="fa fa-calculator me-1"></i>Generate Timetable</button>
                                            <button type="button" class="btn btn-outline-danger btn-round" onclick="window.location.href='auto.php'"><i class="fa fa-times me-1"></i>Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="footer">
                <div class="container-fluid d-flex justify-content-between">
                    <nav class="pull-left">
                        <ul class="nav">
                            <li class="nav-item">
                                <a class="nav-link" href="#"> Help </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"> Licenses </a>
                            </li>
                        </ul>
                    </nav>
                    <div class="copyright">
                        Developed by Faculty Of Computer Science
                        <a href="http://www.ucspathein.edu.mm">UCS(Pathein)</a>
                    </div>
                    <div>
                        Design by
                        <a target="_blank" href="http://www.themekita.com">ThemeKita</a>.
                    </div>
                </div>
            </footer>
        </div>

    </div>
    <!--   Core JS Files   -->
    <script src="assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Datatables -->
    <script src="assets/js/plugin/datatables/datatables.min.js"></script>

    <!-- Bootstrap Notify -->
    <script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

    <!-- Sweet Alert -->
    <script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>

    <!-- Kaiadmin JS -->
    <script src="assets/js/kaiadmin.min.js"></script>

    <!-- sweetalert -->
</body>

</html>

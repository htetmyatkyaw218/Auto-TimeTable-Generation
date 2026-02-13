<?php
include('conn.php');

// Get teacher details
$filterTeacherId = isset($_GET['teacher_id']) ? (int) $_GET['teacher_id'] : 0;
$filterTeacher = isset($_GET['teacher']) ? trim($_GET['teacher']) : '';

if (!$filterTeacherId && $filterTeacher) {
    // Get teacher ID from name
    $stmtName = $con->prepare("SELECT teacher_id FROM teacher WHERE tname = ?");
    $stmtName->bind_param('s', $filterTeacher);
    $stmtName->execute();
    $result = $stmtName->get_result();
    if ($row = $result->fetch_assoc()) {
        $filterTeacherId = $row['teacher_id'];
        $filterTeacher = $row['tname']; // Use exact name from database
    }
    $stmtName->close();
}

if (!$filterTeacherId) {
    die("Teacher not found");
}

// Get teacher details with exact name
$teacherQuery = $con->prepare("
    SELECT t.*, d.dept_name 
    FROM teacher t 
    LEFT JOIN department d ON t.dept_code = d.dept_code 
    WHERE t.teacher_id = ?
");
$teacherQuery->bind_param('i', $filterTeacherId);
$teacherQuery->execute();
$teacher = $teacherQuery->get_result()->fetch_assoc();

if (!$teacher) {
    die("Teacher not found");
}

// Function to check if a teacher name appears in a comma-separated list
function isTeacherInList($teacherName, $teacherList)
{
    if (empty($teacherList)) return false;

    // Split by comma and trim each name
    $names = array_map('trim', explode(',', $teacherList));

    // Check for exact match or partial match (if teacher name contains part of it)
    foreach ($names as $name) {
        // Trim any extra spaces and compare
        if (trim($name) === trim($teacherName)) {
            return true;
        }
        // Also check if the teacher name is contained within a longer name
        if (strpos(trim($name), trim($teacherName)) !== false) {
            return true;
        }
    }

    return false;
}

// Get all subjects assigned to this teacher
// Modified to handle comma-separated teacher names properly
$subjectsQuery = $con->prepare("
    SELECT 
        ts.teacher_name as assigned_teachers,
        s.scode,
        s.sname,
        s.credit_unit,
        sec.section_name,
        sec.section_id,
        y.year_id,
        y.year_name,
        y.acdyear,
        y.semester,
        d.dept_name as subject_dept
    FROM teaches ts
    JOIN subject s ON ts.sub_id = s.sub_id
    JOIN section sec ON ts.section_id = sec.section_id
    JOIN year y ON ts.year_id = y.year_id
    JOIN department d ON s.dept_code = d.dept_code
    ORDER BY y.year_id, sec.section_id, s.scode
");
$subjectsQuery->execute();
$subjectsResult = $subjectsQuery->get_result();

// Store all subjects for this teacher
$allSubjects = [];
$subjectByCode = [];
$teacherName = trim($teacher['tname']);

while ($row = $subjectsResult->fetch_assoc()) {
    // Check if this teacher is in the assigned teachers list
    if (isTeacherInList($teacherName, $row['assigned_teachers'])) {
        $allSubjects[] = $row;
        // Keep one entry per subject code for distinct counting
        if (!isset($subjectByCode[$row['scode']])) {
            $subjectByCode[$row['scode']] = $row;
        }
    }
}

// Get timetable periods from period table
$periodTimes = [];
$periodQuery = mysqli_query($con, "SELECT * FROM period ORDER BY pid");
if ($periodQuery && mysqli_num_rows($periodQuery) > 0) {
    while ($periodRow = mysqli_fetch_assoc($periodQuery)) {
        for ($i = 1; $i <= $periodRow['periodperday']; $i++) {
            // Try to get time from period_time if available
            if (isset($periodRow['period_time'])) {
                $periodTimes[$i] = $periodRow['period_time'];
            } else {
                // Default times
                $defaultTimes = [1 => '9:00-11:00', 2 => '12:00-2:00', 3 => '2:00-4:00'];
                $periodTimes[$i] = $defaultTimes[$i] ?? "Period $i";
            }
        }
    }
}

// Default periods if none found
if (empty($periodTimes)) {
    $periodTimes = [1 => '9:00-11:00', 2 => '12:00-2:00', 3 => '2:00-4:00'];
}

// Days for timetable
$days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

// Initialize timetable grid
$timetableGrid = [];
foreach ($days as $day) {
    foreach ($periodTimes as $period => $label) {
        $timetableGrid[$day][$period] = [];
    }
}

// Build timetable schedule for each subject
foreach ($allSubjects as $subject) {
    $yearId = $subject['year_id'];
    $sectionId = $subject['section_id'];
    $subjectCode = $subject['scode'];

    // Get timetable for this year and section
    $timetableQuery = $con->prepare("
        SELECT day, period1, period2, period3 
        FROM timetable 
        WHERE year_id = ? AND section_id = ?
    ");
    $timetableQuery->bind_param("ii", $yearId, $sectionId);
    $timetableQuery->execute();
    $timetableResult = $timetableQuery->get_result();

    while ($timetableRow = $timetableResult->fetch_assoc()) {
        $day = ucfirst(strtolower(trim($timetableRow['day'])));

        // Handle different day spellings in database
        $dayMap = [
            'Monday' => 'Monday',
            'Tueday' => 'Tuesday', // Fix common typo
            'Tuesday' => 'Tuesday',
            'Wedday' => 'Wednesday', // Fix common typo
            'Wednesday' => 'Wednesday',
            'Thuday' => 'Thursday', // Fix common typo
            'Thursday' => 'Thursday',
            'Friday' => 'Friday'
        ];

        $day = $dayMap[$day] ?? $day;

        // Check each period for this subject
        for ($period = 1; $period <= 3; $period++) {
            if (isset($timetableRow["period$period"])) {
                $periodContent = trim($timetableRow["period$period"]);

                // If period is empty, skip
                if (empty($periodContent)) {
                    continue;
                }

                // Simple check: if period content contains subject code
                if (strpos($periodContent, $subjectCode) !== false) {
                    // Format: "First year, Section A, E1111"
                    $displayText = $subject['year_name'] . ', Section ' . $subject['section_name'] . ', ' . $subjectCode;

                    // Add to timetable grid
                    if (isset($timetableGrid[$day][$period])) {
                        $timetableGrid[$day][$period][] = $displayText;
                    }
                }
            }
        }
    }
    $timetableQuery->close();
}

// Prepare list of scheduled subjects for the table
$scheduledSubjects = [];
foreach ($days as $day) {
    foreach ($periodTimes as $period => $label) {
        if (!empty($timetableGrid[$day][$period])) {
            foreach ($timetableGrid[$day][$period] as $displayText) {
                // Parse display text back to components
                $parts = explode(', ', $displayText);
                if (count($parts) >= 3) {
                    $yearName = $parts[0];
                    $section = str_replace('Section ', '', $parts[1]);
                    $scode = $parts[2];

                    // Find the subject details
                    $subjectDetails = null;
                    foreach ($allSubjects as $subj) {
                        if (
                            $subj['scode'] === $scode &&
                            $subj['year_name'] === $yearName &&
                            $subj['section_name'] === $section
                        ) {
                            $subjectDetails = $subj;
                            break;
                        }
                    }

                    if ($subjectDetails) {
                        $scheduledSubjects[] = [
                            'day' => $day,
                            'period' => $period,
                            'time' => $label,
                            'year' => $yearName,
                            'section' => $section,
                            'scode' => $scode,
                            'sname' => $subjectDetails['sname'],
                            'credit' => $subjectDetails['credit_unit']
                        ];
                    }
                }
            }
        }
    }
}

// Add unscheduled subjects
$scheduledKeys = [];
foreach ($scheduledSubjects as $entry) {
    $key = $entry['year'] . '|' . $entry['section'] . '|' . $entry['scode'];
    $scheduledKeys[$key] = true;
}

foreach ($allSubjects as $subject) {
    $key = $subject['year_name'] . '|' . $subject['section_name'] . '|' . $subject['scode'];
    if (!isset($scheduledKeys[$key])) {
        $scheduledSubjects[] = [
            'day' => '-',
            'period' => '-',
            'time' => '-',
            'year' => $subject['year_name'],
            'section' => $subject['section_name'],
            'scode' => $subject['scode'],
            'sname' => $subject['sname'],
            'credit' => $subject['credit_unit']
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>University Timetable Management System</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
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
    <style>
        .timetable-cell {
            min-height: 80px;
            vertical-align: top;
            padding: 8px;
        }

        .subject-entry {
            background: #e3f2fd;
            border-radius: 4px;
            padding: 4px 6px;
            margin: 2px 0;
            font-size: 0.85em;
            border-left: 3px solid #2196f3;
        }

        .subject-entry.co-teacher {
            background: #fff3e0;
            border-left-color: #ff9800;
        }

        .empty-cell {
            background: #f5f5f5;
            color: #999;
            font-style: italic;
        }

        .workload-summary {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .co-teacher-badge {
            font-size: 0.7em;
            background: #ff9800;
            color: white;
            padding: 1px 4px;
            border-radius: 3px;
            margin-left: 4px;
        }
    </style>
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
                                <!-- <i class="fas fa-cog"></i> -->
                                <i class="icon-settings"></i>
                                <p>Setting</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="base">
                                <ul class="nav nav-collapse">
                                    <li>
                                        <a href="department.php">
                                            <span class="sub-item">Department</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="rank.php">
                                            <span class="sub-item">Rank</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="section.php">
                                            <span class="sub-item">Section</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="year.php">
                                            <span class="sub-item">Year</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarLayouts">
                                <!-- <i class="fas fa-th-list"></i> -->
                                <i class="icon-plus"></i>
                                <p>Add Data</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="sidebarLayouts">
                                <ul class="nav nav-collapse">
                                    <li>
                                        <a href="teacher.php">
                                            <span class="sub-item">Teacher</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="workload.php">
                                            <span class="sub-item">Teacher Workload</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="subject.php">
                                            <span class="sub-item">Subject</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="period.php">
                                            <span class="sub-item">Period</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="Assign_Teacher.php">
                                            <span class="sub-item">Assign Teacher</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="collapse" href="#forms">
                                <!-- <i class="fas fa-pen-square"></i> -->
                                <i class="fas fa-calculator"></i>
                                <p>Calculate Timetable</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="forms">
                                <ul class="nav nav-collapse">
                                    <li><a href="TimeTable.php"><span class="sub-item">TimeTable</span></a></li>
                                    <li><a href="auto.php"><span class="sub-item">Auto Generating</span></a></li>
                                    <li>
                                        <a href="manual.php">
                                            <span class="sub-item">Manual</span>
                                        </a>
                                    </li>
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
                <!-- ... your existing header code ... -->
            </div>

            <div class="container">
                <div class="page-inner">
                    <div class="page-header">
                        <h4 class="page-title">Dashboard</h4>
                        <ul class="breadcrumbs">
                            <li class="nav-home">
                                <a href="index.php">
                                    <i class="icon-home"></i>
                                </a>
                            </li>
                            <li class="separator">
                                <i class="icon-arrow-right"></i>
                            </li>
                            <li class="nav-item">
                                <a href="workload.php">Setting</a>
                            </li>
                            <li class="separator">
                                <i class="icon-arrow-right"></i>
                            </li>
                            <li class="nav-item">
                                <a href="workload.php">Workload</a>
                            </li>
                            <li class="separator">
                                <i class="icon-arrow-right"></i>
                            </li>
                            <li class="nav-item">
                                <a href="#">Workload Details</a>
                            </li>
                        </ul>
                    </div>

                    <div class="page-category">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex align-items-center">
                                            <h4 class="card-title mb-0">Workload Details for <?= htmlspecialchars($teacher['tname']) ?></h4>
                                            <a href="workload.php" class="btn btn-outline-secondary btn-round ms-auto">
                                                <i class="fas fa-arrow-left me-1"></i> Back to Workload
                                            </a>
                                        </div>
                                        <?php if (!empty($allSubjects)): ?>
                                            <?php
                                            // Check if this teacher co-teaches any subjects
                                            $coTeachingSubjects = [];
                                            foreach ($allSubjects as $subject) {
                                                $teachers = array_map('trim', explode(',', $subject['assigned_teachers']));
                                                if (count($teachers) > 1) {
                                                    $coTeachingSubjects[] = $subject['scode'];
                                                }
                                            }
                                            ?>

                                        <?php endif; ?>
                                    </div>

                                    <div class="card-body">
                                        <!-- Teacher Summary -->
                                        <div class="workload-summary mb-4">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <h5><?= htmlspecialchars($teacher['tname']) ?></h5>
                                                    <p class="mb-1">
                                                        <strong>Rank:</strong> <?= htmlspecialchars($teacher['rank']) ?><br>
                                                        <strong>Department:</strong> <?= htmlspecialchars($teacher['dept_name']) ?><br>

                                                    </p>
                                                </div>
                                                <div class="col-md-4">
                                                    <h5>Workload Summary</h5>
                                                    <p class="mb-1">
                                                        <strong>Total Subjects:</strong> <?= count($subjectByCode) ?><br>
                                                        <strong>Scheduled Peroids:</strong> <?= count(array_filter($scheduledSubjects, function ($item) {
                                                                                                return $item['day'] !== '-';
                                                                                            })) ?>
                                                    </p>
                                                </div>
                                                <div class="col-md-4">
                                                    <h5>Academic Info</h5>
                                                    <p class="mb-0">
                                                        <?php if (!empty($allSubjects)): ?>
                                                            <?php
                                                            $academicYears = array_unique(array_column($allSubjects, 'acdyear'));
                                                            $semesters = array_unique(array_column($allSubjects, 'semester'));
                                                            ?>
                                                            <strong>Academic Year(s):</strong> <?= implode(', ', $academicYears) ?><br>
                                                            <strong>Semester(s):</strong> <?= implode(', ', $semesters) ?>
                                                        <?php else: ?>
                                                            <em>No academic info available</em>
                                                        <?php endif; ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- All Assigned Subjects Table -->
                                        <div class="table-responsive mb-4">
                                            <h5 class="mb-3">
                                                All Assigned Subjects
                                                <span class="badge bg-primary ms-2"><?= count($subjectByCode) ?></span>
                                            </h5>
                                            <table class="table table-bordered table-striped align-middle">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Subject Code</th>
                                                        <th>Subject Name</th>
                                                        <th>Year</th>
                                                        <th>Section</th>
                                                        <th>Credits</th>
                                                        <th>Assigned Teachers</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($allSubjects)): ?>
                                                        <?php foreach ($allSubjects as $subject): ?>
                                                            <?php
                                                            $teachers = array_map('trim', explode(',', $subject['assigned_teachers']));
                                                            $isCoTeaching = count($teachers) > 1;
                                                            ?>
                                                            <tr>
                                                                <td>
                                                                    <?= htmlspecialchars($subject['scode']) ?>
                                                                </td>
                                                                <td><?= htmlspecialchars($subject['sname']) ?></td>
                                                                <td><?= htmlspecialchars($subject['year_name']) ?></td>
                                                                <td><?= htmlspecialchars($subject['section_name']) ?></td>
                                                                <td><?= htmlspecialchars($subject['credit_unit']) ?></td>
                                                                <td>
                                                                    <?php
                                                                    foreach ($teachers as $index => $t) {
                                                                        if (trim($t) === $teacherName) {
                                                                            echo '<strong>' . htmlspecialchars($t) . '</strong>';
                                                                        } else {
                                                                            echo htmlspecialchars($t);
                                                                        }
                                                                        if ($index < count($teachers) - 1) {
                                                                            echo ', ';
                                                                        }
                                                                    }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <tr>
                                                            <td colspan="6" class="text-center">No subjects assigned to this teacher.</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Timetable Grid -->
                                        <div class="table-responsive mb-4">
                                            <h5 class="mb-3">Weekly Timetable Schedule</h5>
                                            <table class="table table-bordered align-middle">
                                                <thead class="table-primary text-center">
                                                    <tr>
                                                        <th>Day</th>
                                                        <?php foreach ($periodTimes as $period => $label): ?>
                                                            <th>Period <?= $period ?><br><?= htmlspecialchars($label) ?></th>
                                                        <?php endforeach; ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($days as $day): ?>
                                                        <tr>
                                                            <td class="fw-bold bg-light"><?= $day ?></td>
                                                            <?php foreach ($periodTimes as $period => $label): ?>
                                                                <td class="timetable-cell">
                                                                    <?php if (!empty($timetableGrid[$day][$period])): ?>
                                                                        <?php foreach ($timetableGrid[$day][$period] as $displayText): ?>
                                                                            <div class="subject-entry">
                                                                                <?= htmlspecialchars($displayText) ?>
                                                                            </div>
                                                                        <?php endforeach; ?>
                                                                    <?php else: ?>
                                                                        <div class="empty-cell text-center">-</div>
                                                                    <?php endif; ?>
                                                                </td>
                                                            <?php endforeach; ?>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Detailed Schedule List -->
                                        <div class="table-responsive">
                                            <h5 class="mb-3">Detailed Class Schedule</h5>
                                            <table class="table table-bordered align-middle">
                                                <thead class="table-light text-center">
                                                    <tr>
                                                        <th>Day</th>
                                                        <!-- <th>Period</th> -->
                                                        <th>Time</th>
                                                        <th>Year</th>
                                                        <th>Section</th>
                                                        <th>Subject Code</th>
                                                        <th>Subject Name</th>
                                                        <th>Credits</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($scheduledSubjects)): ?>
                                                        <?php
                                                        // Sort scheduled subjects by day and period
                                                        usort($scheduledSubjects, function ($a, $b) use ($days) {
                                                            $dayOrder = array_flip($days);
                                                            $aDayOrder = $dayOrder[$a['day']] ?? 999;
                                                            $bDayOrder = $dayOrder[$b['day']] ?? 999;

                                                            if ($aDayOrder === $bDayOrder) {
                                                                return $a['period'] <=> $b['period'];
                                                            }
                                                            return $aDayOrder <=> $bDayOrder;
                                                        });
                                                        ?>
                                                        <?php foreach ($scheduledSubjects as $entry): ?>
                                                            <tr>
                                                                <td><?= htmlspecialchars($entry['day']) ?></td>
                                                                <!-- <td><?= htmlspecialchars($entry['period']) ?></td> -->
                                                                <td><?= htmlspecialchars($entry['time']) ?></td>
                                                                <td><?= htmlspecialchars($entry['year']) ?></td>
                                                                <td><?= htmlspecialchars($entry['section']) ?></td>
                                                                <td><?= htmlspecialchars($entry['scode']) ?></td>
                                                                <td><?= htmlspecialchars($entry['sname']) ?></td>
                                                                <td><?= htmlspecialchars($entry['credit']) ?></td>
                                                                <td>
                                                                    <?php if ($entry['day'] === '-'): ?>
                                                                        <span class="badge bg-warning">Not Scheduled</span>
                                                                    <?php else: ?>
                                                                        <span class="badge bg-success">Scheduled</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <tr>
                                                            <td colspan="9" class="text-center">No timetable data available.</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
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

    <!-- Core JS Files -->
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
    <script src="assets/js/plugin/custom.js"></script>

</body>

</html>
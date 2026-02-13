<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
  header('Location: login.php');
  exit;
}

include('conn.php');

// Filters coming from query string
$filterAcdyear = isset($_GET['acdyear']) ? trim($_GET['acdyear']) : '';
$filterSemester = isset($_GET['semester']) ? trim($_GET['semester']) : '';

// Build dropdown data
$yearOptions = mysqli_query($con, "SELECT DISTINCT acdyear FROM year ORDER BY acdyear DESC");
$semesterOptions = mysqli_query($con, "SELECT DISTINCT semester FROM year ORDER BY semester ASC");

// Build filter condition used inside aggregations so teachers without matches still appear
$filterClauses = [];
$params = [];
$types = '';

if ($filterAcdyear !== '') {
    $filterClauses[] = 'y.acdyear = ?';
    $params[] = $filterAcdyear;
    $types .= 's';
}

if ($filterSemester !== '') {
    $filterClauses[] = 'y.semester = ?';
    $params[] = $filterSemester;
    $types .= 's';
}

$filterCondition = !empty($filterClauses) ? implode(' AND ', $filterClauses) : '1=1';

// Prepare workload query with proper grouping
$sql = "
    SELECT 
        t.tname as teacher_name,
        t.teacher_id,
        t.rank,
        d.dept_name,
        d.dept_code,
        GROUP_CONCAT(
            DISTINCT CASE WHEN {$filterCondition} THEN CONCAT(y.acdyear, ' (', y.semester, ')') END
            ORDER BY y.acdyear, y.semester SEPARATOR ', '
        ) as academic_periods,
        GROUP_CONCAT(
            DISTINCT CASE WHEN {$filterCondition} THEN CONCAT(s.scode, ' - ', s.sname) END
            ORDER BY s.scode SEPARATOR '<br>'
        ) as subject_list,
        COUNT(DISTINCT CASE WHEN {$filterCondition} THEN s.scode END) as total_subjects,
        COUNT(DISTINCT CASE WHEN {$filterCondition} THEN CONCAT(ts.year_id, '-', ts.section_id) END) as total_assignments
    FROM teacher t
    LEFT JOIN department d ON t.dept_code = d.dept_code
    LEFT JOIN teaches ts ON (
        ts.teacher_name LIKE CONCAT('%', t.tname, '%') 
        OR ts.teacher_name = t.tname
        OR FIND_IN_SET(t.tname, REPLACE(ts.teacher_name, ' and ', ','))
    )
    LEFT JOIN subject s ON ts.sub_id = s.sub_id
    LEFT JOIN year y ON ts.year_id = y.year_id
    LEFT JOIN section sec ON ts.section_id = sec.section_id
    GROUP BY t.teacher_id, t.tname, t.rank, d.dept_code, d.dept_name
    ORDER BY t.tname ASC
";

// Execute query
if (!empty($params)) {
    $stmt = $con->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = mysqli_query($con, $sql);
}

// Store results
$workloads = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $workloads[] = $row;
    }
}

// Count only teachers that have at least one subject/assignment
$workloadTeachers = array_filter($workloads, function ($row) {
    return (($row['total_subjects'] ?? 0) > 0) || (($row['total_assignments'] ?? 0) > 0);
});
$totalTeachers = count($workloadTeachers);
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
    <style>
        .workload-table td {
            vertical-align: top;
        }

        .subject-list {
            font-size: 0.85em;
            max-height: 200px;
            overflow-y: auto;
            padding: 5px;
            background: #f8f9fa;
            border-radius: 5px;
        }

        .badge-count {
            font-size: 0.9em;
        }
    </style>
</head>

<body>
    <!-- ... keep existing body structure until the table ... -->
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
                                    id="customSearchInput"
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
                        </ul>
                    </div>

                    <div class="page-category">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex align-items-center">
                                            <h4 class="card-title mb-0">Teacher Workload</h4>
                                            <!-- <a href="Assign_Teacher.php" class="btn btn-outline-primary btn-round ms-auto">
                                                <i class="fa fa-link me-1"></i>
                                                View Assignments
                                            </a> -->
                                        </div>
                                        <p class="text-muted small mb-0 text-primary">Teachers with Workload : <?= $totalTeachers ?></p>
                                    </div>
                                    <div class="card-body">
                                        <?php if ($filterAcdyear || $filterSemester): ?>
                                            <div class="row mb-4">
                                                <div class="col-12">
                                                    <div class="alert alert-info">
                                                        <i class="fas fa-filter me-2"></i>
                                                        Showing results for:
                                                        <strong><?= $filterAcdyear ? "Academic Year: $filterAcdyear" : '' ?></strong>
                                                        <?= ($filterAcdyear && $filterSemester) ? ', ' : '' ?>
                                                        <strong><?= $filterSemester ? "Semester: $filterSemester" : '' ?></strong>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Workload Table -->
                                        <div class="table-responsive">
                                            <table id="add-row" class="display table table-striped table-hover workload-table table-bordered">
                                                <thead class="table-primary">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Teacher Details</th>
                                                        <th>Department</th>
                                                        <th>Academic Period</th>
                                                        <th>Workload Summary</th>
                                                        <th>Subjects</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($workloads)) : ?>
                                                        <?php $i = 1; ?>
                                                        <?php foreach ($workloads as $load) : ?>
                                                            <tr>
                                                                <td><?= $i++; ?></td>
                                                                <td>
                                                                    <div class="fw-bold"><?= htmlspecialchars($load['teacher_name']); ?></div>
                                                                    <div class="text-muted small"><?= htmlspecialchars($load['rank']); ?></div>
                                                                </td>
                                                                <td>
                                                                    <span class="fw-bold"><?= htmlspecialchars($load['dept_code']); ?></span>
                                                                </td>
                                                                <td>
                                                                    <?php if (!empty($load['academic_periods'])): ?>
                                                                        <?php
                                                                        $periodParts = array_filter(array_map('trim', explode(',', $load['academic_periods'])));
                                                                        $grouped = [];
                                                                        foreach ($periodParts as $part) {
                                                                            if (preg_match('/^(.*?)\\s*\\((.*?)\\)$/', $part, $matches)) {
                                                                                $yearLabel = trim($matches[1]);
                                                                                $semLabel = trim($matches[2]);
                                                                            } else {
                                                                                $yearLabel = '';
                                                                                $semLabel = trim($part);
                                                                            }
                                                                            if (!isset($grouped[$yearLabel])) {
                                                                                $grouped[$yearLabel] = [];
                                                                            }
                                                                            if ($semLabel !== '') {
                                                                                $grouped[$yearLabel][] = $semLabel;
                                                                            }
                                                                        }
                                                                        $formattedChunks = [];
                                                                        foreach ($grouped as $yearLabel => $sems) {
                                                                            $chunk = htmlspecialchars($yearLabel);
                                                                            if (!empty($sems)) {
                                                                                $chunk .= '<br>' . implode('<br>', array_map('htmlspecialchars', $sems));
                                                                            }
                                                                            $formattedChunks[] = $chunk;
                                                                        }
                                                                        ?>
                                                                        <span><?= implode('<br><br>', $formattedChunks); ?></span>
                                                                    <?php else: ?>
                                                                        <span class="badge bg-warning">Not Assigned</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex flex-column gap-2">
                                                                        <span class="badge bg-primary badge-count">
                                                                            <i class="fas fa-book me-1"></i>
                                                                            Subjects: <?= $load['total_subjects']; ?>
                                                                        </span>
                                                                        <span class="badge bg-success badge-count">
                                                                            <i class="fas fa-tasks me-1"></i>
                                                                            Assignments: <?= $load['total_assignments']; ?>
                                                                        </span>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <?php if (!empty($load['subject_list'])): ?>
                                                                        <div class="subject-list">
                                                                            <?= $load['subject_list']; ?>
                                                                        </div>
                                                                    <?php else: ?>
                                                                        <span class="text-muted">No subjects assigned</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <?php if (($load['total_subjects'] ?? 0) > 0 || ($load['total_assignments'] ?? 0) > 0): ?>
                                                                        <div class="btn-group">
                                                                            <a href="show_workload.php?teacher_id=<?= $load['teacher_id']; ?>"
                                                                                class="btn btn-sm btn-primary"
                                                                                title="View Details">
                                                                                Show Details
                                                                            </a>
                                                                        </div>
                                                                    <?php else: ?>
                                                                        <span class="badge bg-warning">No Workload</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php else : ?>
                                                        <tr>
                                                            <td colspan="7" class="text-center py-4">
                                                                <div class="text-muted">
                                                                    <i class="fas fa-inbox fa-2x mb-3"></i>
                                                                    <h5>No workload data found</h5>
                                                                    <p>Try adjusting your filters or assign teachers to subjects.</p>
                                                                    <a href="Assign_Teacher.php" class="btn btn-primary mt-2">
                                                                        <i class="fas fa-plus me-1"></i> Assign Teachers
                                                                    </a>
                                                                </div>
                                                            </td>
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
    <script src="assets/js/plugin/custom.js"></script>

</body>

</html>

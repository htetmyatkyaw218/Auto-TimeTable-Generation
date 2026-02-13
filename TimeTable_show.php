<?php include('conn.php');
session_start();
$year_id = isset($_GET['year_id']) ? $_GET['year_id'] : null;

if ($year_id) {
    $stmt = $con->prepare("SELECT acdyear, year_name, semester FROM year WHERE year_id = ?");
    $stmt->bind_param("i", $year_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $acdyear =$row['acdyear'];
        $_SESSION['acdyear'] = $acdyear;
        $year_name= $row['year_name'];
        $_SESSION['year_name'] = $year_name;
        $semester= $row['semester'];
        $_SESSION['semester'] = $semester;
    }
    $stmt->close();
}

$section_id = isset($_GET['section_id']) ? $_GET['section_id'] : null;

    $stmt = $con->prepare("SELECT section_name FROM section WHERE section_id = ?");
    $stmt->bind_param("s", $section_id);
    $stmt->execute();
    $section_name = $stmt->get_result()->fetch_assoc()['section_name'];
    $_SESSION['section_name'] = $section_name;

// Teacher Name
$stmt = $con->prepare("SELECT teacher_name FROM teaches WHERE year_id = ? AND section_id = ?");
$stmt->bind_param("ii", $year_id, $section_id);
$stmt->execute();
$result = $stmt->get_result();

$teacher_names = [];
while ($row = $result->fetch_assoc()) {
    $teacher_names[] = $row['teacher_name'];
}
$_SESSION['TeacherList'] = $teacher_names;
$stmt->close();

// Subject List
$stmt = $con->prepare("SELECT sname, scode FROM subject WHERE year_id = ?");
$stmt->bind_param("i", $year_id);
$stmt->execute();
$result = $stmt->get_result();

$subjects = [];
while ($row = $result->fetch_assoc()) {
    $subjects[] = $row;
}
$_SESSION['SubjectList'] = $subjects;
$stmt->close();


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Universiity Timetable Management System</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/Timetable/icon.png">
    <!-- Fonts and icons -->
    <script src="assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["assets/css/fonts.min.css"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/plugins.min.css" />
    <link rel="stylesheet" href="assets/css/kaiadmin.min.css" />

    <style> 
  #add-row th, 
  #add-row td {
    border: 2px solid black;
    border-collapse: collapse;
    text-align: center;
    vertical-align: middle;
    font-weight: bold; 
  }

#add-row input[type="text"] {
  border: none;
  outline: none;
  background: transparent;
  text-align: center;  /* centers the value */
  width: 100%;
  font-weight: bold;
}
#add-row th {
  background-color: #f5f5f5; /* very light gray */
  color: black;
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
          <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">
              <a href="index.php" class="logo">
                <img
                  src="assets/img/Timetable/logo.jpg"
                  alt="navbar brand"
                  class="navbar-brand"
                  height="20"
                />
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
            class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
          >
            <div class="container-fluid">
              <nav
                class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex"
              >
                <div class="input-group">
                  <div class="input-group-prepend">
                    <button type="submit" class="btn btn-search pe-1">
                      <i class="fa fa-search search-icon"></i>
                    </button>
                  </div>
                  <input
                    type="text"
                    placeholder="Search ..."
                    class="form-control"
                  />
                </div>
              </nav>

              <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li
                  class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none"
                >
                  <a
                    class="nav-link dropdown-toggle"
                    data-bs-toggle="dropdown"
                    href="#"
                    role="button"
                    aria-expanded="false"
                    aria-haspopup="true"
                  >
                    <i class="fa fa-search"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-search animated fadeIn">
                    <form class="navbar-left navbar-form nav-search">
                      <div class="input-group">
                        <input
                          type="text"
                          placeholder="Search ..."
                          class="form-control"
                        />
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
                  <a href="TimeTable.php">Calculate Timetable</a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="TimeTable.php">TimeTable</a>
                </li>
                 <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="TimeTable_show.php">Show TimeTable</a>
                </li>
               
              </ul>
            </div>

            <!--Start Inner page content goes here -->

            <div class="page-category">

              <div class="col-md-12">
                <div class="card">
                  <form action="Auto_process.php" method="post">
                  <div class="card-header">
                    <div class="d-flex align-items-center">
                      <h4 class="card-title">Show TimeTable Information</h4>
                    </div>
                  </div>
                    <div class="card-header  text-center">
                    <div class="align-items-center ">
                      <h4>University of Computer Studies (Pathein)</h4>
                      <h4><?php echo $acdyear; ?> Academic Year</h4>
                      <h4><?php echo $year_name; ?></h4>
                      <h4><?php echo $semester; ?></h4>
                      <h4>Section - <?php echo $section_name; ?></h4>
                    </div>       
                  </div> 
                  <div class="card-body">

                    <div class="table-responsive">
                      <table id="add-row" class="table text-center">
                        <thead class="table-info">
                          <tr>
                            <th>Period</th>
                            <th>I</th>
                            <th>Break</th>
                            <th>II</th>
                            <th>III</th>
                          </tr>
                          <tr>
                            <th>Day/Time</th>
                            <th>9:00-11:00</th>
                            <th>11:00-12:00</th>
                            <th>12:00-2:00</th>
                            <th>2:00-4:00</th>
                          </tr>
                        </thead>


                        <tbody> 
                        <?php 
                          $stmt = $con->prepare("SELECT day, period1, period2, period3 FROM timetable WHERE section_id = ? AND year_id = ?");
                          $stmt->bind_param("ii", $section_id, $year_id);
                          $stmt->execute();
                          $result = $stmt->get_result();
                          $row_count = 0;

                          while ($row = $result->fetch_assoc()) {
                          // Get a short lowercase day name for ids/names (e.g. Monday -> mon)
                          $dayShort = strtolower(substr($row['day'], 0, 3));

                          echo '<tr>';
                          echo '<td><b>' . htmlspecialchars($row['day']) . '</b></td>';

                           // Period 1 input
                          echo '<td><input type="text" id="' . $dayShort . '1" name="' . $dayShort . '1" value="' . htmlspecialchars($row['period1']) . '" readonly></td>';

                          // Lunch cell only on first row with rowspan 6
                          if ($row_count == 0) {
                          echo '<td rowspan="6">L<br>U<br>N<br>C<br>H</td>';
                          }

                          // Period 2 input
                          echo '<td><input type="text" id="' . $dayShort . '2" name="' . $dayShort . '2" value="' . htmlspecialchars($row['period2']) . '" readonly></td>';

                          // Period 3 input
                          echo '<td><input type="text" id="' . $dayShort . '3" name="' . $dayShort . '3" value="' . htmlspecialchars($row['period3']) . '" readonly></td>';

                          echo '</tr>';
                            $row_count++;
                          }
                          $stmt->close();
                          ?>
                        </tbody>
                      </table>
                      <table class="display table table-hover" style="margin-top: 40px;">
                        <thead>
                          <tr style="border: none;">
                            <th style="border: none;">Subject Code</th>
                            <th style="border: none;">Subject Name</th>
                            <th style="border: none;">Teacher Name</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                  $i = 0;
                  foreach ($subjects as $data) {
                  echo "<tr style='border: none;'>";
                  echo "<td style='border: none;'>" . htmlspecialchars($data["scode"]) . "</td>";
                  echo "<td style='border: none;'>" . htmlspecialchars($data["sname"]) . "</td>";

                  if (isset($teacher_names[$i])) {
                    echo "<td style='border: none;'>" . htmlspecialchars($teacher_names[$i]) . "</td>";
                  } else {
                    echo "<td style='border: none;'>****</td>";
                    }
                    echo "</tr>";
                  $i++;
                  }

                  ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                    <div class="card-action d-flex gap-2 flex-wrap">
                      <button type="submit" class="btn btn-outline-success btn-round" name="print">
                        <i class="fa fa-file-pdf me-1"></i>
                        Print PDF File
                      </button>

                      <button type="button" class="btn btn-outline-danger btn-round"  onclick="window.location.href='TimeTable.php'"><i class="fa fa-times me-1"></i>Cancel</button>
                    </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- End body -->
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

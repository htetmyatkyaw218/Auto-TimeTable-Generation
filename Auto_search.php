<?php include('conn.php');
if (isset($_GET['year_id'], $_GET['acdyear'], $_GET['year_name'], $_GET['semester'], $_GET['section_name'])) {
  $year_id = $_GET['year_id'];
  $acdyear = $_GET['acdyear'];
  $year_name = $_GET['year_name'];
  $semester = $_GET['semester'];
  $section_name = $_GET['section_name'];
  $sql2 = "SELECT subperweek, periodperday FROM period WHERE acdyear = '$acdyear' AND semester = '$semester'";
  $result2 = mysqli_query($con, $sql2);

  if (!$result2) {
    die("Query failed: " . mysqli_error($con));
  } else {
    $row = mysqli_fetch_assoc($result2);
    $SubPerWeek = $row["subperweek"];
    $PeriodPerDay = $row["periodperday"];
  }

  $sql5 = "SELECT COUNT(*) as total FROM subject WHERE year_id = $year_id";
  $result5 = $con->query($sql5);
  $row5 = $result5->fetch_assoc();
  $Subject_count = $row5['total'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Universiity Timetable Management System</title>
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

          <!--Start Inner page content goes here -->

          <div class="page-category">

            <div class="col-md-12">
              <div class="card">
                <form action="Auto_caculate.php" method="post">
                  <div class="card-header">
                    <div class="d-flex align-items-center">
                      <h4 class="card-title">University Timetable Information</h4>
                    </div>

                  </div>
                  <div class="card-header">
                    <div class="card-title text-center" style="font-weight: bold;padding-left: 3%; ">
                      <p>Academic Year : <?php echo $acdyear; ?></p>
                      <p>Semester : <?php echo $semester; ?></p>
                      <p>Class Name : <?php echo $year_name; ?></p>
                      <p>Section Name : <?php echo $section_name; ?></p>
                      <input type="hidden" name="acdyear" value=" <?php echo $acdyear; ?>">
                      <input type="hidden" name="semester" value=" <?php echo $semester; ?>">
                      <input type="hidden" name="year_name" value=" <?php echo $year_name; ?>">
                      <input type="hidden" name="section_name" value=" <?php echo $section_name; ?>">
                    </div>

                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table
                        id="add-row"
                        class="display table table-hover ">
                        <thead class="table-info">
                          <tr>
                            <th>Subject Code</th>
                            <th>Subject Name</th>
                            <th>Teacher Name</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $sql3 = "SELECT section_id FROM section where section_name = '$section_name'";
                          $result3 = $con->query($sql3);
                          if ($result3->num_rows > 0) {
                            while ($row = $result3->fetch_assoc()) {
                              $section_id = $row["section_id"];
                            }
                          }
                          $teacher_map = [];
                          $teacher_name = [];
                          $subject = [];
                          $sql4 = "SELECT sub_id, teacher_name FROM teaches WHERE section_id = '$section_id' AND year_id = '$year_id'";
                          $result4 = $con->query($sql4);
                          if ($result4->num_rows > 0) {
                            while ($row = $result4->fetch_assoc()) {
                              $sub_id = $row['sub_id'];
                              $names = array_filter(array_map('trim', explode(',', $row['teacher_name'])), function ($v) {
                                return $v !== '';
                              });
                              if (!isset($teacher_map[$sub_id])) {
                                $teacher_map[$sub_id] = [];
                              }
                              $teacher_map[$sub_id] = array_values(array_unique(array_merge($teacher_map[$sub_id], $names)));
                            }
                          }
                          $sql1 = "SELECT sub_id, scode, sname FROM subject WHERE year_id = $year_id";
                          $result1 = $con->query($sql1);
                          while ($row1 = $result1->fetch_assoc()) {
                            $subject[] = $row1;
                            echo "<tr><td class='fw-bold'>{$row1['scode']}</td><td>{$row1['sname']}</td>";
                            $sub_id = $row1['sub_id'];
                            $teacherNames = isset($teacher_map[$sub_id]) ? implode(', ', $teacher_map[$sub_id]) : '';
                            $teacher_name[] = $teacherNames;
                            $displayName = $teacherNames !== '' ? $teacherNames : 'Not Assigned';
                            echo "<td>" . $displayName . "</td>";
                            echo "</tr>";
                          }
                          ?>
                        </tbody>
                      </table>
                      <input type="hidden" name="Subject_count" value="<?php echo $Subject_count; ?>">
                      <input type="hidden" name="PeriodPerDay" value="<?php echo $PeriodPerDay; ?>">
                      <input type="hidden" name="TeacherList" value='<?php echo json_encode($teacher_name); ?>'>
                      <input type="hidden" name="SubjectList" value='<?php echo json_encode($subject); ?>'>
                      <input type="hidden" name="year_id" value="<?php echo $year_id; ?>">
                      <input type="hidden" name="section_id" value="<?php echo $section_id; ?>">

                    </div>
                    <div class=" card-header">
                      <div style=" padding-top:10px ">
                        <p>Total Subject : <?php echo $Subject_count; ?></p>
                        <p>Subject per Week : <?php echo $SubPerWeek; ?></p>
                        <p>Period per Day : <?php echo $PeriodPerDay; ?></p>
                      </div>
                    </div>
                    <div class="card-action d-flex gap-2 flex-wrap">
                      <button class="btn btn-outline-success btn-round" name="caculate"><i class="fa fa-calculator me-1"></i>Caculate Schedule</button>
                      <button type="button" class="btn btn-outline-danger btn-round" onclick="window.location.href='auto.php'"><i class="fa fa-times me-1"></i>Cancel</button>
                    </div>
                  </div>
                </form>
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
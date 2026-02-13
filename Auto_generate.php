<?php include('conn.php');
session_start();

$acdyear = $_SESSION['acdyear'];
$semester = $_SESSION['semester'];
$year_name = $_SESSION['year_name'];
$section_name = $_SESSION['section_name'];

function getSlotValue($day, $period)
{
  $target = $day . '(' . $period . ')';
  for ($i = 0; $i < $_SESSION['Subject_count']; $i++) {
    if ($_SESSION['dt1'][$i] === $target || $_SESSION['dt2'][$i] === $target) {
      return $_SESSION['scode1'][$i];
    }
  }
  return '';
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
  <style>
    #add-row th,
    #add-row td {
      border: 2px solid black;
      border-collapse: collapse;
      text-align: center;
      vertical-align: middle;
      font-size: 16px;
      font-weight: bold;
    }

    #add-row input[type="text"] {
      border: none;
      outline: none;
      background: transparent;
      text-align: center;
      /* centers the value */
      width: 100%;
    }

    #add-row th {
      background-color: #f5f5f5;
      /* very light gray */
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
          <div class="logo-header" data-background-color="dark">
            <a href="index.php" class="logo">
              <img src="assets/img/Timetable/logo.jpg" alt="navbar brand" class="navbar-brand" height="20" />
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
        </div>
        <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
          <div class="container-fluid">
            <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
              <div class="input-group">
                <div class="input-group-prepend">
                  <button type="submit" class="btn btn-search pe-1">
                    <i class="fa fa-search search-icon"></i>
                  </button>
                </div>
                <input type="text" placeholder="Search ..." class="form-control" />
              </div>
            </nav>
            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
              <li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button">
                  <i class="fa fa-search"></i>
                </a>
                <ul class="dropdown-menu dropdown-search animated fadeIn">
                  <form class="navbar-left navbar-form nav-search">
                    <div class="input-group">
                      <input type="text" placeholder="Search ..." class="form-control" />
                    </div>
                  </form>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
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
                <form action="Auto_process.php" method="post">
                  <div class="card-header">
                    <h4 class="card-title">University Timetable</h4>
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
                        <thead>
                          <tr>
                            <th>Period</th>
                            <th>I</th>
                            <th>Break</th>
                            <th>II</th>
                            <th>III</th>
                          </tr>
                          <tr>
                            <th><b>Day/Time</b></th>
                            <th><input type="text" id="t1" name="t1" value="9:00-11:00 "></th>
                            <th><input type="text" id="t2" name="t2" value=" 11:00-12:00"></th>
                            <th><input type="text" id="t3" name="t3" value=" 12:00-2:00"></th>
                            <th><input type="text" id="t4" name="t4" value=" 2:00-4:00"></th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>
                              <b>Monday</b>
                            </td>
                            <td><input type="text" id="mon" name="mon1" value="<?php echo getSlotValue('Monday', 1); ?>"></td>
                            <td rowspan="6">
                              <h2>L<br>U<br>N<br>C<br>H</h2>
                            </td>
                            <td><input type="text" id="mon" name="mon2" value="<?php echo getSlotValue('Monday', 2); ?>"></td>
                            <td><input type="text" id="mon" name="mon3" value="<?php echo getSlotValue('Monday', 3); ?>"></td>
                          </tr>
                          <tr>
                            <td>
                              <b>Tuesday</b>
                            </td>
                            <td><input type="text" id="tue" name="tue1" value="<?php echo getSlotValue('Tuesday', 1); ?>"></td>
                            <td><input type="text" id="tue" name="tue2" value="<?php echo getSlotValue('Tuesday', 2); ?>"></td>
                            <td><input type="text" id="tue" name="tue3" value="<?php echo getSlotValue('Tuesday', 3); ?>"></td>
                          </tr>
                          <tr>
                            <td>
                              <b>Wednesday</b>
                            </td>
                            <td><input type="text" id="wed" name="wed1" value="<?php echo getSlotValue('Wednesday', 1); ?>"></td>
                            <td><input type="text" id="wed" name="wed2" value="<?php echo getSlotValue('Wednesday', 2); ?>"></td>
                            <td><input type="text" id="wed" name="wed3" value="<?php echo getSlotValue('Wednesday', 3); ?>"></td>
                          </tr>
                          <tr>
                            <td>
                              <b>Thursday</b>
                            </td>
                            <td><input type="text" id="thu" name="thu1" value="<?php echo getSlotValue('Thursday', 1); ?>"></td>
                            <td><input type="text" id="thu" name="thu2" value="<?php echo getSlotValue('Thursday', 2); ?>"></td>
                            <td><input type="text" id="thu" name="thu3" value="<?php echo getSlotValue('Thursday', 3); ?>"></td>
                          </tr>
                          <tr>
                            <td>
                              <b>Friday</b>
                            </td>
                            <td><input type="text" id="fri" name="fri1" value="<?php echo getSlotValue('Friday', 1); ?>"></td>
                            <td><input type="text" id="fri" name="fri2" value="<?php echo getSlotValue('Friday', 2); ?>"></td>
                            <td><input type="text" id="fri" name="fri3" value="<?php echo getSlotValue('Friday', 3); ?>"></td>
                          </tr>
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
                          $tname = $_SESSION['TeacherList'];
                          $i = 0;
                          foreach ($_SESSION['SubjectList'] as $data) {
                            echo "<tr style='border: none;'>";
                            echo "<td style='border: none;'>" . htmlspecialchars($data["scode"]) . "</td>";
                            echo "<td style='border: none;'>" . htmlspecialchars($data["sname"]) . "</td>";

                            if (isset($tname[$i])) {
                              echo "<td style='border: none;'>" . htmlspecialchars($tname[$i]) . "</td>";
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
                    <div class="card-action d-flex gap-2 flex-wrap">
                      <button class="btn btn-outline-success btn-round" name="save">
                        <i class="fa fa-save me-1"></i>
                        Save Timetable
                      </button>
                      <button class="btn btn-outline-success btn-round" name="print">
                        <i class="fa fa-file-pdf me-1"></i>
                        Print PDF File
                      </button>
                      <button type="submit" class="btn btn-outline-primary btn-round" formaction="Auto_caculate.php" formmethod="post">
                        <i class="fa fa-sync me-1"></i>
                        Re-generate
                      </button>
                      <button type="button" class="btn btn-outline-danger btn-round" onclick="window.location.href='auto.php'">
                        <i class="fa fa-times me-1"></i>
                        Cancel
                      </button>
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
  <!-- notify -->
  <?php if (isset($_GET['status'])): ?>
    <script>
      $(document).ready(function() {
        var status = "<?php echo $_GET['status']; ?>";
        var content = {};
        var placementFrom = $("#notify_placement_from option:selected").val();
        var placementAlign = $("#notify_placement_align option:selected").val();
        var state = "info"; // default
        var style = $("#notify_style option:selected").val();

        // Set default icon
        content.icon = "fa fa-bell";

        switch (status) {
          case 'success':
            content.message = 'successfully Save TimeTable !Click to Check';
            content.title = "Success";
            content.icon = "fa fa-check-circle";
            content.url = "TimeTable.php";
            content.target = "_blank";
            state = "success";
            break;
          case 'error':
            content.message = 'Error: This TimeTable is Already Save ! Click to Check';
            content.title = "Warning";
            content.icon = "fa fa-exclamation-triangle";
            content.url = "TimeTable.php";
            content.target = "_blank";
            state = "warning";
            break;
          default:
            content.message = 'An unknown status occurred.';
            content.title = "Notice";
            state = "info";
        }

        $.notify(content, {
          type: state,
          placement: {
            from: placementFrom,
            align: placementAlign,
          },
          time: 1000,
          delay: 6000,
          animate: {
            enter: 'animated fadeInDown',
            exit: 'animated fadeOutUp',
          },
        });

        // Remove 'status' from URL after showing notification
        if (window.history.replaceState) {
          const url = new URL(window.location);
          url.searchParams.delete('status');
          window.history.replaceState({}, document.title, url.pathname + url.search);
        }
      });
    </script>
  <?php endif; ?>
  <!-- notify -->

</body>

</html>
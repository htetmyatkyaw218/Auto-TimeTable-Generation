<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
  header('Location: login.php');
  exit;
}

include('conn.php');
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
    .page-inner {
      background: radial-gradient(circle at 15% 20%, rgba(96, 165, 250, 0.12), transparent 25%),
        radial-gradient(circle at 85% 10%, rgba(167, 139, 250, 0.12), transparent 22%),
        linear-gradient(135deg, #f8fafc, #eef2ff);
    }

    .dashboard-hero {
      background: linear-gradient(120deg, #4f46e5, #0ea5e9);
      color: #fff;
      border-radius: 16px;
      padding: 18px 20px;
      box-shadow: 0 12px 30px rgba(79, 70, 229, 0.25);
    }

    .dashboard-hero .pill {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: rgba(255, 255, 255, 0.15);
      padding: 6px 12px;
      border-radius: 999px;
      font-size: 12px;
      letter-spacing: 0.02em;
    }

    .dashboard-hero .title {
      font-weight: 700;
      margin: 6px 0 2px;
    }

    .dashboard-hero p {
      margin: 0;
      opacity: 0.9;
    }

    .metric-card .card {
      border: none;
      border-radius: 14px;
      box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
      transition: transform 0.12s ease, box-shadow 0.12s ease;
      background: #ffffffd6;
      backdrop-filter: blur(4px);
    }

    .metric-card .card:hover {
      transform: translateY(-4px);
      box-shadow: 0 18px 36px rgba(15, 23, 42, 0.12);
    }

    .metric-card .card-category {
      font-size: 13px;
      letter-spacing: 0.01em;
      color: #64748b;
    }

    .metric-card .card-title {
      font-weight: 700;
      color: #0f172a;
    }

    .metric-card .icon-big {
      width: 64px;
      height: 64px;
      border-radius: 16px;
      background: linear-gradient(135deg, rgba(79, 70, 229, 0.12), rgba(14, 165, 233, 0.08));
      display: inline-flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 8px 20px rgba(79, 70, 229, 0.18);
    }

    .metric-card .numbers small {
      display: inline-block;
      margin-top: 4px;
      color: #94a3b8;
      font-size: 12px;
      letter-spacing: 0.01em;
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
                        id="customSearchInput"
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
          <div
            class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
              <h3 class="fw-bold mb-3">Dashboard</h3>
              <h6 class="op-7 mb-2">University Timetable Management System</h6>
            </div>
            <div class="ms-md-auto py-2 py-md-0">
              <!--  <a href="#" class="btn btn-label-info btn-round me-2">Manage</a>
                <a href="#" class="btn btn-outline-primary btn-round">Add Customer</a> -->
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-12">
              <div class="dashboard-hero d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                <div>
                  <div class="pill">
                    <i class="fas fa-bolt"></i>
                    At-a-glance
                  </div>
                  <div class="title">Plan. Publish. Track.</div>
                  <p>Quickly view your timetable footprint, people, and subjects in one place.</p>
                </div>
                <div class="d-flex gap-2 flex-wrap mt-3 mt-md-0">
                  <a href="auto.php" class="btn btn-outline-light btn-round"><i class="fa fa-magic me-1"></i>Auto Generate</a>
                  <a href="manual.php" class="btn btn-outline-light btn-round"><i class="fa fa-pen me-1"></i>Manual Plan</a>
                </div>
              </div>
            </div>
          </div>

          <div class="row g-3 metric-card">
            <div class="col-12 col-sm-6 col-lg-3">
              <div class="card card-stats card-round h-100">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-icon">
                      <div
                        class="icon-big text-center icon-info bubble-shadow-small">

                        <i class="fas fa-table"></i>
                      </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                      <a href="TimeTable.php">
                        <div class="numbers">
                          <?php
                          $sql = "SELECT COUNT(DISTINCT year_id, section_id) AS count FROM timetable";
                          $result = $con->query($sql);

                          $count = 0; // default

                          if ($result) {
                            $row = $result->fetch_assoc();
                            $count = $row["count"];
                          } else {
                            // handle query error if needed
                            echo "Query error: " . $con->error;
                          }
                          ?>
                          <p class="card-category">TimeTable</p>
                          <h4 class="card-title"><?php echo $count; ?></h4>
                        </div>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
              <div class="card card-stats card-round h-100">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-icon">
                      <div
                        class="icon-big text-center icon-primary bubble-shadow-small">
                        <i class="fas fa-users"></i>
                      </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                      <a href="Teacher.php">
                        <div class="numbers">
                          <?php
                          $sql = "SELECT COUNT(*) as count FROM teacher";
                          $result = $con->query($sql);


                          if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $count = $row["count"];
                          }
                          ?>
                          <p class="card-category">Teacher</p>
                          <h4 class="card-title"><?php echo $count; ?></h4>
                        </div>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
              <div class="card card-stats card-round h-100">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-icon">
                      <div
                        class="icon-big text-center icon-info bubble-shadow-small">

                        <i class="icon-book-open"></i>
                      </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                      <a href="subject.php">
                        <div class="numbers">
                          <?php
                          $sql = "SELECT COUNT(*) as count FROM subject";
                          $result = $con->query($sql);


                          if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $count = $row["count"];
                          }
                          ?>
                          <p class="card-category">Subject</p>
                          <h4 class="card-title"><?php echo $count; ?></h4>
                        </div>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
              <div class="card card-stats card-round h-100">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-icon">
                      <div
                        class="icon-big text-center icon-success bubble-shadow-small">
                        <i class="icon-layers"></i>
                      </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                      <a href="department.php">
                        <div class="numbers">
                          <?php
                          $sql = "SELECT COUNT(*) as count FROM department";
                          $result = $con->query($sql);


                          if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $count = $row["count"];
                          }
                          ?>
                          <p class="card-category">Department</p>
                          <h4 class="card-title"><?php echo $count; ?></h4>
                        </div>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
              <div class="card card-stats card-round h-100">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-icon">
                      <div
                        class="icon-big text-center icon-secondary bubble-shadow-small">
                        <i class="icon-calendar"></i>
                      </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                      <a href="year.php">
                        <div class="numbers">
                          <?php
                          $sql = "SELECT COUNT(*) as count FROM year";
                          $result = $con->query($sql);


                          if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $count = $row["count"];
                          }
                          ?>
                          <p class="card-category">Semester</p>
                          <h4 class="card-title"><?php echo $count; ?></h4>
                        </div>
                      </a>
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

</body>

</html>

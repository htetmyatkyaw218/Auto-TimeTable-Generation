<?php include('conn.php');
if (isset($_GET['teacher_id'])) {
  $teacher_id = $_GET['teacher_id'];
  $query = "SELECT * FROM teacher WHERE teacher_id='$teacher_id'";
  $result = mysqli_query($con, $query);

  if (!$result) {
    die("Query failed: " . mysqli_error($con));
  } else {
    $row = mysqli_fetch_assoc($result);
  }
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
              <li class="nav-home">
                <a href="index.php">
                  <i class="icon-home"></i>
                </a>
              </li>
              <li class="separator">
                <i class="icon-arrow-right"></i>
              </li>
              <li class="nav-item">
                <a href="teacher.php">Add Data</a>
              </li>
              <li class="separator">
                <i class="icon-arrow-right"></i>
              </li>
              <li class="nav-item">
                <a href="teacher.php">Teacher</a>
              </li>
              <li class="separator">
                <i class="icon-arrow-right"></i>
              </li>
              <li class="nav-item">
                <a href="Teacher_Update.php">Update Teacher</a>
              </li>

            </ul>
          </div>

          <div class="page-category">

            <!--Start Inner page content goes here -->

            <div class="row">
              <div class="col-md-12">
                <div class="card">

                  <form action="Teacher_process.php" method="post">
                    <input type="hidden" name="teacher_id" value="<?php echo $row['teacher_id']; ?>">

                    <div class="card-header">
                      <div class="card-title">Add Teacher</div>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-12">

                          <div class="form-group">
                            <label>Name</label>
                            <input
                              type="text"
                              name="tname"
                              class="form-control"
                              required
                              value="<?php echo $row['tname']; ?>" />
                          </div>
                          <div class="form-group">
                            <label for="defaultSelect">Rank</label>
                            <select
                              class="form-select form-control"
                              id="defaultSelect"
                              name="rank">
                              <option selected value="<?php echo $row['rank']; ?>"><?php echo $row['rank']; ?></option>

                              <?php
                              $query = "select * from rank_db";
                              $result = mysqli_query($con, $query);
                              if (!$result) {
                                die("Connection failed: " . mysqli_connect_error());
                              } else {
                                while ($row = mysqli_fetch_assoc($result)) {
                              ?>
                                  <option value="<?php echo $row['rank']; ?>"><?php echo $row['rank'];  ?></option>

                              <?php
                                }
                              }
                              ?>
                            </select>
                          </div>
                          <?php
                          if (isset($_GET['teacher_id'])) {
                            $teacher_id = $_GET['teacher_id'];
                            $query = "SELECT * FROM teacher WHERE teacher_id='$teacher_id'";
                            $result = mysqli_query($con, $query);

                            if (!$result) {
                              die("Query failed: " . mysqli_error($con));
                            } else {
                              $row = mysqli_fetch_assoc($result);
                            }
                          }
                          ?>
                          <div class="form-group">
                            <label for="defaultSelect">Department Code</label>
                            <select
                              class="form-select form-control"
                              id="defaultSelect"
                              name="dept_code">
                              <option selected value="<?php echo $row['dept_code']; ?>"><?php echo $row['dept_code']; ?></option>

                              <?php
                              $query = "select * from department";
                              $result = mysqli_query($con, $query);
                              if (!$result) {
                                die("Connection failed: " . mysqli_connect_error());
                              } else {
                                while ($data = mysqli_fetch_assoc($result)) {
                              ?>
                                  <option value="<?php echo $data['dept_code']; ?>"><?php echo
                                                                                    $data['dept_code'];  ?></option>

                              <?php
                                }
                              }
                              ?>
                            </select>

                          </div>
                          <div class="form-group">
                            <label>Email</label>
                            <input
                              type="email"
                              name="email"
                              class="form-control "
                              value="<?php echo $row['email']; ?>" />
                          </div>
                          <div class="form-group">
                            <label>Phone</label>
                            <input
                              type="numbers"
                              name="ph_no"
                              class="form-control "
                              pattern="09[0-9]{9}"
                              title="Phone number must start with 09 and have exactly 11 digits (e.g., 09699185252)"
                              value="<?php echo $row['ph_no']; ?>" />
                            <span class="validity"></span>
                          </div>
                          <div class="form-group">
                            <label>Address</label>
                            <textarea class="form-control" required name="address" rows="4" cols="50"><?php echo $row['address']; ?></textarea>
                          </div>

                        </div>
                      </div>
                    </div>
                    <div class="card-action d-flex gap-2 flex-wrap">
                      <button class="btn btn-outline-success btn-round" name="update"><i class="fa fa-save me-1"></i>Update</button>

                      <button type="button" class="btn btn-outline-danger btn-round"  onclick="window.location.href='teacher.php'"><i class="fa fa-times me-1"></i>Cancel</button>

                    </div>
                </div>
                </form>
              </div>
            </div>

            <!-- End body -->

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
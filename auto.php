<?php include('conn.php');
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
   $query="SELECT DISTINCT acdyear FROM year";  
   $result=mysqli_query($con,$query);
   $query1="SELECT DISTINCT semester FROM year";  
   $result1=mysqli_query($con,$query1);
   $query2="SELECT DISTINCT year_name FROM year";  
   $result2=mysqli_query($con,$query2);
   $query3="SELECT DISTINCT section_name FROM section";  
   $result3=mysqli_query($con,$query3);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Universiity Timetable Management System</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
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

            <div class="page-category">
              <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <form action="Auto_process.php" method="post">
                      <div class="card-header">
                        <div class="card-title">Select Information For Generating TimeTable</div>
                      </div>
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-12">

                       
                        <div class="form-group">
                          <label for="defaultSelect">Academic Year <span style="color: red;  font-size: 1.2em;">*</span></label>
                          <select
                            class="form-select form-control"
                            id="defaultSelect"
                            name ="acdyear"
                            required>
                            <option disabled selected value="">Select Academic Year</option>
                              <?php
                              
                                 if(!$result){
                                 die("Connection failed: " . mysqli_connect_error());
                                 }
                                 else{
                                while ($row=mysqli_fetch_assoc($result)) {
                              ?>
                                <option value="<?php echo $row['acdyear'];?>"><?php echo $row['acdyear'];?></option>
                              <?php
                                 }
                               }
                              ?>
                          </select> 
                        </div>
                        <div class="form-group">
                          <label for="defaultSelect">Semester <span style="color: red;  font-size: 1.2em;">*</span></label>
                          <select
                            class="form-select form-control"
                            id="defaultSelect"
                            name ="semester"
                            required>
                            <option disabled selected value="">Select Semester</option>
                              <?php
                                 if(!$result1){
                                 die("Connection failed: " . mysqli_connect_error());
                                 }
                                 else{
                                while ($row=mysqli_fetch_assoc($result1)) {
                              ?>
                                <option value="<?php echo $row['semester'];?>"><?php echo $row['semester'];?></option>
                              <?php
                                 }
                               }
                              ?>
                          </select> 
                        </div>
                        <div class="form-group">
                          <label for="defaultSelect">Class <span style="color: red;  font-size: 1.2em;">*</span></label>
                          <select
                            class="form-select form-control"
                            id="defaultSelect"
                            name ="year_name"
                            required>
                            <option disabled selected value="">Select Class</option>
                              <?php
                                 if(!$result2){
                                 die("Connection failed: " . mysqli_connect_error());
                                 }
                                 else{
                                while ($row=mysqli_fetch_assoc($result2)) {
                              ?>
                                <option value="<?php echo $row['year_name'];?>"><?php echo $row['year_name'];?></option>
                              <?php
                                 }
                               }
                              ?>
                          </select> 
                        </div>
                        <div class="form-group">
                          <label for="defaultSelect">Section <span style="color: red;  font-size: 1.2em;">*</span></label>
                          <select
                            class="form-select form-control"
                            id="defaultSelect"
                            name ="section_name"
                            required>
                            <option disabled selected value="">Select Section</option>
                              <?php
                                 if(!$result3){
                                 die("Connection failed: " . mysqli_connect_error());
                                 }
                                 else{
                                while ($row=mysqli_fetch_assoc($result3)) {
                              ?>
                                <option value="<?php echo $row['section_name'];?>"><?php echo $row['section_name'];?></option>
                              <?php
                                 }
                               }
                              ?>
                          </select> 
                        </div>

                        </div>
                      </div>
                      <div class="card-action d-flex gap-2 flex-wrap">
                        <button class="btn btn-outline-primary btn-round" name="search"><i class="fa fa-search me-1"></i>Search</button>
                      </div>
                    </form>
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
                <li class="nav-item"><a class="nav-link" href="#"> Help </a></li>
                <li class="nav-item"><a class="nav-link" href="#"> Licenses </a></li>
              </ul>
            </nav>
            <div class="copyright">
              Developed by Faculty Of Computer Science <a href="http://www.ucspathein.edu.mm">UCS(Pathein)</a>
            </div>
            <div>
              Design by <a target="_blank" href="http://www.themekita.com">ThemeKita</a>.
            </div>
          </div>
        </footer>
      </div>
    </div>

    <!-- Core JS Files -->
    <script src="assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>
    <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <script src="assets/js/plugin/datatables/datatables.min.js"></script>
    <script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
    <script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>
    <script src="assets/js/kaiadmin.min.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', () => {
        const form = document.querySelector('form[action="Auto_process.php"]');
        if (!form) return;
        form.addEventListener('submit', (e) => {
          const requiredIds = ['acdyear', 'semester', 'year_name', 'section_name'];
          const missing = requiredIds.some((name) => {
            const el = form.querySelector(`[name=\"${name}\"]`);
            return !el || !el.value;
          });
          if (missing) {
            e.preventDefault();
            alert('Please select Academic Year, Semester, Class, and Section before searching.');
          }
        });
      });
    </script>

    <!-- notify -->
<?php if (isset($_GET['status'])): ?>
<script>
$(document).ready(function () {
    var status = "<?php echo $_GET['status']; ?>";
    var content = {};
    var placementFrom = $("#notify_placement_from option:selected").val();
    var placementAlign = $("#notify_placement_align option:selected").val();
    var state = "info"; // default
    var style = $("#notify_style option:selected").val();

    // Set default icon
    content.icon = "fa fa-bell";

    switch (status) {
        case 'error':
            content.message = 'There is no Information for this class ! ,Click to Check';
            content.title = "Warning";
            content.icon = "fa fa-exclamation-triangle";
            content.url = "Assign_Teacher.php";
            content.target = "_blank";
            state = "warning";
            break;
        case 'have_error':
            content.message = 'Error: This TimeTable is Already Generated ! Click to Check';
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

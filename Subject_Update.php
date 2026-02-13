<?php include('conn.php');
if (isset($_GET['sub_id'], $_GET['year_id'])) {
    $sub_id = $_GET['sub_id'];
    $year_id = $_GET['year_id'];

    $query = "SELECT * FROM year WHERE year_id = '$year_id'";
    $result = mysqli_query($con, $query);

    $query1 = "SELECT * FROM subject WHERE sub_id = '$sub_id'";
    $result1 = mysqli_query($con, $query1);

    // Fix: Logical error in condition and typo in variable name
    if (!$result || !$result1) {
        die("Query failed: " . mysqli_error($con));
    } else {
        $data = mysqli_fetch_assoc($result);   // from year table
        $data1 = mysqli_fetch_assoc($result1);  // from subject table
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
    <link rel="stylesheet" href="assets/css/main.css" />

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
                  <a href="subject.php">Add Data</a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="subject.php">Subject</a>
                </li>
                      <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="Subject_Update.php">Update Subject</a>
                </li>
               
              </ul>
            </div>

            <div class="page-category">

            <!--Start Inner page content goes here -->

            <div class="row">
              <div class="col-md-12">
                <div class="card">

                  <form action="Subject_process.php" method="post">

                  <div class="card-header">
                    <div class="card-title">Update Subject</div>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12">
                          
                        <div class="form-group">
                          <label for="defaultSelect">Academic Year <span style="color: red;  font-size: 1.2em;">*</span></label>
                          <select
                            class="form-select form-control"
                            id="defaultSelect"
                            name ="acdyear">
                            <option selected value="<?php echo $data['acdyear'];?>"><?php echo $data['acdyear'];?></option>
                              <?php
                                $query="SELECT DISTINCT acdyear FROM year"; 
                                $result=mysqli_query($con,$query);
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
                          <label for="defaultSelect">Semester <span style="color: red; font-size: 1.2em;">*</span></label>
                          <select
                            class="form-select form-control"
                            id="defaultSelect"
                            name ="semester">
                            <option  selected value="<?php echo $data['semester'];?>"><?php echo
                             $data['semester'];?></option>
                              <?php
                                $query="SELECT DISTINCT semester FROM year"; 
                                $result=mysqli_query($con,$query);
                                 if(!$result){
                                 die("Connection failed: " . mysqli_connect_error());
                                 }
                                 else{
                                while ($row=mysqli_fetch_assoc($result)) {
                              ?>
                                <option value="<?php echo $row['semester'];?>"><?php echo $row['semester'];?></option>
                              <?php
                                 }
                               }
                              ?>
                          </select> 
                        </div>
                          <div class="form-group">
                          <label for="defaultSelect">Year <span style="color: red; font-size: 1.2em;">*</span></label>
                          <select
                            class="form-select form-control"
                            id="defaultSelect"
                            name ="year_name">
                            <option selected value="<?php echo $data['year_name'];?>"><?php echo $data['year_name'];?></option>
                              <?php
                                $query="SELECT DISTINCT year_name FROM year"; 
                                $result=mysqli_query($con,$query);
                                 if(!$result){
                                 die("Connection failed: " . mysqli_connect_error());
                                 }
                                 else{
                                while ($row=mysqli_fetch_assoc($result)) {
                              ?>
                                <option value="<?php echo $row['year_name'];?>"><?php echo $row['year_name'];?></option>
                              <?php
                                 }
                               }
                              ?>
                          </select> 
                        </div>
                          <div class="form-group" style="display: none; ">
                         
                          <input type="hidden" name="sub_id" value="<?php echo $data1['sub_id'];?>">
                           <input type="hidden" name="year_id" value="<?php echo $data1['year_id'];?>">
                        </div>
                        
                        <div class="form-group">
                          <label>Subject Code <span style="color: red; font-size: 1.2em;">*</span></label>
                          <input
                            type="text"
                            name="scode"
                            class="form-control "
                            value="<?php echo $data1['scode'];?>"
                          />
                        </div>
                        <div class="form-group">
                          <label>Subject Name <span style="color: red; font-size: 1.2em;">*</span></label>
                          <input
                            type="numbers"
                            name="sname"
                            class="form-control "
                            value="<?php echo $data1['sname'];?>"                           
                          />
                        </div>
                         <div class="form-group">
                          <label>Pre-requisite</label>
                          <input
                            type="numbers"
                            name="pre_requisite"
                            class="form-control"
                            value="<?php echo $data1['pre_requisite'];?>"                          
                          />
                        </div>
                        <div class="form-group">
                          <label>Credit Unit <span style="color: red; font-size: 1.2em;">*</span></label>
                          <input
                            type="numbers"
                            name="credit_unit"
                            class="form-control "
                            value="<?php echo $data1['credit_unit'];?>"                          
                          />
                        </div>
                        <div class="form-group">
                          <label>Type <span style="color: red; font-size: 1.2em;">*</span></label>
                          <input
                            type="numbers"
                            name="type"
                            class="form-control "
                            value="<?php echo $data1['type'];?>"                          
                          />
                        </div>
                         <div class="form-group" style="position: relative;">
                            <label for="defaultSelect">Department Code <span style="color: red; font-size: 1.2em;">*</span></label>
                              <div class="custom-select-box" id="customSelect">
                                <span id="selectedText"><?php echo $data1['dept_code'];?></span>
                                <span class="remove-last" id="removeLastBtn" title="Remove last">×</span>
                              </div>
                          <div class="custom-dropdown " id="dropdown">

                             <?php
                              $query = "SELECT * FROM department";
                              $result = mysqli_query($con, $query);
                              $departments = [];
                                if ($result) {
                              while ($row = mysqli_fetch_assoc($result)) {
                                 $departments[] = $row['dept_code'];
                                    }
                                }
                              foreach ($departments as $dept): ?>
                            <div data-value="<?php echo $dept; ?>"><?php echo $dept; ?></div>
                           <?php endforeach; ?>
                         </div>
                          <input type="hidden" name="dept_code" id="selectedDepartmentsInput" value="<?php echo $data1['dept_code'];?>">
                        </div>
                          
                        <div class="form-group">
                          <label for="defaultSelect">Degree Type<span style="color: red; font-size: 1.2em;">*</span></label>
                          <select
                            class="form-select form-control"
                            id="defaultSelect"
                            name ="degree">
                            <option  selected value="<?php echo $data1['degree_type'];?>"><?php echo $data1['degree_type'];?></option>
                              <?php
                                $query="SELECT * FROM degree ORDER BY degree_type ASC"; 
                                $result=mysqli_query($con,$query);
                                 if(!$result){
                                 die("Connection failed: " . mysqli_connect_error());
                                 }
                                 else{
                                while ($row=mysqli_fetch_assoc($result)) {
                              ?>
                                <option value="<?php echo $row['degree_type'];?>"><?php echo $row['degree_type'];?></option>
                              <?php
                                 }
                               }
                              ?>
                          </select> 
                        </div>

                      </div>
                    </div>
                  </div>
                  <div class="card-action d-flex gap-2 flex-wrap">
                  <button class="btn btn-outline-success btn-round" name="update"><i class="fa fa-save me-1"></i>Update</button>
          
                  <button type="button" class="btn btn-outline-danger btn-round"  onclick="window.location.href='subject.php'"><i class="fa fa-times me-1"></i>Cancel</button>

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
    s
    <!-- Choose Department dropdown -->
    <script>
  const customSelect = document.getElementById("customSelect");
  const dropdown = document.getElementById("dropdown");
  const selectedText = document.getElementById("selectedText");
  const removeLastBtn = document.getElementById("removeLastBtn");
  const hiddenInput = document.getElementById("selectedDepartmentsInput");

  let selectedValues = [];

  customSelect.addEventListener("click", () => {
    dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";

  });

dropdown.addEventListener('click', function(event) {
  if (event.target && event.target.matches('div[data-value]')) {
    const value = event.target.getAttribute('data-value');
    if (!selectedValues.includes(value)) {
      selectedValues.push(value);
      updateDisplay();
    }
    dropdown.style.display = 'none';
  }
});

  removeLastBtn.addEventListener("click", (e) => {
    e.stopPropagation(); // prevent dropdown toggle
    if (selectedValues.length > 0) {
      selectedValues.pop();
      updateDisplay();
    }
  });

  function updateDisplay() {
    if (selectedValues.length === 0) {
      selectedText.textContent = "Select Department Code ";
    } else {
      selectedText.textContent = selectedValues.join(', ');
    }

    hiddenInput.value = selectedValues.join(','); // for form submission
  }

  document.addEventListener("click", function (event) {
    if (!customSelect.contains(event.target) && !dropdown.contains(event.target)) {
      dropdown.style.display = "none";
    }
  });
</script>

  </body>
</html>

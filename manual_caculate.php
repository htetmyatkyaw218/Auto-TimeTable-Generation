<?php include('conn.php');
session_start();
$Subject_count = isset($_POST['totalSubject']) ? (int)$_POST['totalSubject'] : 0;
$_SESSION['Subject_count'] = $Subject_count;
$PeriodPerDay = isset($_POST['Perday']) ? (int)$_POST['Perday'] : 0;

if ($Subject_count <= 0 || $PeriodPerDay <= 0) {
    die("Invalid data received");
}

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

$timetable = array(); //define timetable array
array_push($timetable, $monday);
array_push($timetable, $tuesday);
array_push($timetable, $wednesday);
array_push($timetable, $thursday);
array_push($timetable, $friday);


for ($b = 0; $b < $Subject_count; $b++) {
    $subT[$b] = new FirstTimetableObj("selfstudy", 4); //define subT array obj
    $secondSubT[$b] = new FirstTimetableObj("selfstudy", 5); //define secondSubT array obj
}

for ($i = 0; $i < count($subT); $i++) {
    $aa = true;
    while ($aa) {
        shuffle_recursive($timetable);
        $bb = $timetable[0][0]->day;
        $num = $timetable[0][0]->time;
        if ($bb !== "NoData") {
            $subT[$i] = $timetable[0][0];
            unset($timetable[0][0]);
            $timetable[0][0] = new FirstTimetableObj("NoData", 7);
            $aa = false;
        }
    }

    $firstDay[$i] = $subT[$i]->day;
    $fristTime[$i] = $subT[$i]->time;



    $ff = true;
    while ($ff) {
        shuffle_recursive($timetable);
        $cc = $timetable[0][0]->day;
        $x = $timetable[0][0]->time;
        if ($cc != "NoData" && $x != 7) {
            $secondSubT[$i] = $timetable[0][0];
            $ff = false;
        }
    }
    $s1 = $secondSubT[$i]->day;
    $t1 = $secondSubT[$i]->time;

    $flag = true;
    while ($flag) {
        if ($firstDay[$i] == $s1 || $fristTime[$i] == $t1) { 
            //check one subject on same day or same time
            $jj = true;
            while ($jj) {
                shuffle_recursive($timetable);
                $dd = $timetable[0][0]->day;
                $y = $timetable[0][0]->time;
                if ($dd != "NoData" && $y != 7) {
                    $secondSubT[$i] = $timetable[0][0];
                    $jj = false;
                }
            }
            $s1 = $secondSubT[$i]->day;
            $t1 = $secondSubT[$i]->time;

        } //end same day and time check

        if (($firstDay[$i] != $s1) && ($fristTime[$i] != $t1)) {
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
    $timeone[$i] = $firstDay[$i] . "(" . $fristTime[$i] . ")";
    $timetwo[$i] = $secondDay[$i] . "(" . $secondTime[$i] . ")";
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
                <li class="nav-home"><a href="index.php"><i class="icon-home"></i></a></li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item"><a href="manaul.php">Calculate Timetable</a></li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item"><a href="manaul.php">Manual Generating</a></li>
              </ul>
            </div>

            <!--Start Inner page content goes here -->

            <div class="page-category">

              <div class="col-md-12">
                <div class="card">
                  <form action="manual_generate.php" method="post">
                  <div class="card-header">
                    <div class="d-flex align-items-center">
                      <h4 class="card-title">University Timetable Schedule</h4>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
<?php
    $i = 0;
     for($jj=0;$jj < $Subject_count;$jj++){
            $scode[$jj]="subject11";
            $sname[$jj]="subject[$jj]"; 
    }

    for ($i = 0; $i < $Subject_count; $i++) {
        $finalTimetable[$i] = new SecondTimetableObj(
            $scode[$i], $sname[$i],
            $firstDay[$i], $fristTime[$i],
            $secondDay[$i], $secondTime[$i]
        );
    }

    for ($i = 0; $i < $Subject_count; $i++) {
        $finalTimetableNew[$i] = new ThirdTimetableObj(
            $scode[$i], $sname[$i],
            $timeone[$i], $timetwo[$i]
        );
    }
?>
                     <table
                        id="add-row"
                        class="display table table-hover table-bordered text-center"
                      >
                        <thead class="table-info">
                          <tr>
                            <th>Subject Name</th>
                            <th >First Day And Time</th>
                             <th >Second Day And Time</th>
                          </tr>
                        </thead>                        
                        <tbody>
                          <?php
                          foreach ($finalTimetableNew as $key => $value) {
                          ?>
                          <tr>
                            <td><?php echo  $value->sname1; ?></td>
                            <td><?php echo $value->dt1; ?></td>
                            <td><?php echo $value->dt2; ?></td>
                          </tr>
                          <?php
                            $_SESSION['sname1'][] = $value->sname1;
                            $_SESSION['dt1'][] = $value->dt1;
                            $_SESSION['dt2'][] = $value->dt2;
                         }
                          ?>
                        </tbody>         
                      </table>
                    </div>
                    <div class="card-header">
                  <div style=" padding-left: 2%; ">
                    <?php
                    for ($k = 0; $k < count($timetable); $k++) {
                      for ($n = 0; $n < count($timetable[$k]); $n++) {
                        if ($timetable[$k][$n]->day !== "NoData") {

                    ?>
                      <p>Self Study :  <?php echo $timetable[$k][$n]->day . ', ' . $timetable[$k][$n]->time; ?> </p>
                      <?php
                          }
                        }
                      }
                      ?>
                    </div>
                  </div>
                      <div class="card-action d-flex gap-2 flex-wrap">
                        <button class="btn btn-outline-success btn-round" name="caculate"><i class="fa fa-calculator me-1"></i>Generate Timetable</button>
                        <button type="button" class="btn btn-outline-danger btn-round"  onclick="window.location.href='manual.php'"><i class="fa fa-times me-1"></i>Cancel</button>
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

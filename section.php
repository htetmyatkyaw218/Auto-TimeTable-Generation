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
                <a href="section.php">Setting</a>
              </li>
              <li class="separator">
                <i class="icon-arrow-right"></i>
              </li>
              <li class="nav-item">
                <a href="section.php">Section</a>
              </li>

            </ul>
          </div>

          <!--Start Inner page content goes here -->

          <div class="page-category">

            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <div class="d-flex align-items-center">
                    <h4 class="card-title">Section Details</h4>
                    <a href="Add_Section.php"
                      class="btn btn-outline-primary btn-round ms-auto">

                      <i class="fa fa-plus me-1"></i>
                      Add Section
                    </a>
                  </div>
                </div>

                <div class="card-body">
                  <div class="table-responsive">
                    <table
                      id="add-row"
                      class="display table table-striped table-hover table-bordered text-center">
                      <thead class="table-info">
                        <tr>
                          <th>Section No</th>
                          <th>Section Name</th>
                          <th style="width: 10%">Action</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>Section No</th>
                          <th>Section Name</th>
                          <th>Action</th>
                        </tr>
                      </tfoot>
                      <tbody>
                        <?php

                        $query = "SELECT * FROM section ";

                        $result = mysqli_query($con, $query);
                        $i = 1;
                        while ($data = mysqli_fetch_assoc($result)) {
                        ?>
                          <tr>
                            <td><?php echo $i++; ?></td>
                            <td hidden><?php echo $data['section_id'];  ?></td>
                            <td><?php echo $data['section_name'];  ?></td>
                            <td>
                              <div class="form-button-action">
                                <a href="Section_Update.php?section_id=<?= $data['section_id']; ?>"
                                  type="button"
                                  data-bs-toggle="tooltip"
                                  title=""
                                  class="btn btn-link btn-primary btn-lg"
                                  data-original-title="Edit Task">
                                  <i class="fa fa-edit"></i>
                                </a>
                                <button
                                  type="button"
                                  data-bs-toggle="tooltip"
                                  data-rank="<?= $data['section_id']; ?>"
                                  class="btn btn-link btn-danger delete-btn"
                                  data-original-title="Remove">
                                  <i class="fas fa-trash-alt"></i>
                                </button>

                              </div>
                            </td>

                          </tr>
                        <?php
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

          </div>
          <!-- Hidden form to submit delete request -->
          <form id="deleteForm" method="post" action="Section_process.php" style="display:none;">
            <input type="hidden" name="section_id" id="section_id">
            <input type="hidden" name="action" value="delete">
          </form>

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
  <script src="assets/js/plugin/custom.js"></script>

  <script>
    $(".delete-btn").click(function(e) {
      var section_id = $(this).attr('data-rank');
      swal({
        icon: null,
        title: "Delete this item?",
        text: "This action will permanently remove the record. Continue?",
        buttons: {
          cancel: {
            visible: true,
            text: "Keep it",
            className: "btn btn-light btn-round border swal-btn-cancel",
          },
          confirm: {
            text: "Yes, delete",
            className: "btn btn-danger btn-round swal-btn-confirm",
          },

        },
        dangerMode: true,
      }).then((Delete) => {
        if (Delete) {
          $('#section_id').val(section_id); // put dept_code into hidden form
          $('#deleteForm').submit(); // submit the form
        } else {
          swal.close();
        }
      });
    });
  </script>

  <!-- sweetalert -->

  <!-- notify -->
  <?php if (isset($_GET['status'])): ?>
    <script>
      $(document).ready(function() {
        var status = "<?php echo $_GET['status']; ?>";
        var content = {};

        // Common values
        var placementFrom = $("#notify_placement_from option:selected").val();
        var placementAlign = $("#notify_placement_align option:selected").val();
        var state = $("#notify_state option:selected").val();
        var style = $("#notify_style option:selected").val();

        // Set default icon
        content.icon = "fa fa-bell";

        // Define messages based on status
        switch (status) {
          case 'success':
            content.message = 'Section added successfully!';
            content.title = "Success";
            break;
          case 'up_success':
            content.message = 'Section Updated Successfully!';
            content.title = "Success";
            break;
          case 'del_success':
            content.message = 'Section Deleted successfully!';
            content.title = "Success";
            content.icon = "fa fa-check-circle";
            state = "success";
            break;
          case 'del_unsuccess':
            content.message = 'Section Deleted Unsuccessfully!';
            content.title = "Warning";
            content.icon = "fa fa-times-circle";
            state = "warning";
            break;
          default:
            content.message = 'Deleted Unsuccessfully!';
            content.title = "Warning";
        }

        // Show notification
        $.notify(content, {
          type: state,
          placement: {
            from: placementFrom,
            align: placementAlign,
          },
          time: 1000,
          delay: 5000,
          animate: {
            enter: 'animated fadeInDown',
            exit: 'animated fadeOutUp',
          },
        });

        // Remove 'status' from URL
        if (window.history.replaceState) {
          const url = new URL(window.location);
          url.searchParams.delete('status');
          window.history.replaceState({}, document.title, url.pathname + url.search);
        }
      });
    </script>
  <?php endif; ?>

  <!-- notify -->

  <style>
    .swal-footer {
      display: flex;
      justify-content: center;
      gap: 10px;
      flex-wrap: wrap;
    }

    .swal-button--cancel {
      order: 1;
    }

    .swal-button--confirm {
      order: 2;
      margin-left: 4px;
    }
  </style>
</body>

</html>

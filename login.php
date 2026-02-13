<?php
session_start();
require_once 'conn.php';

// Redirect to dashboard if already logged in
if (isset($_SESSION['admin_id'])) {
  header('Location: index.php');
  exit;
}

$loginError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $password = trim($_POST['password'] ?? '');

  if ($username !== '' && $password !== '') {
    $stmt = $con->prepare('SELECT admin_id, username FROM login WHERE username = ? AND password = ? LIMIT 1');
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
      $_SESSION['admin_id'] = $row['admin_id'];
      $_SESSION['username'] = $row['username'];
      header('Location: index.php');
      exit;
    } else {
      $loginError = 'Invalid username or password.';
    }

    $stmt->close();
  } else {
    $loginError = 'Username and password are required.';
  }
}
?>
<!doctype html>
<html lang="en">

<head>
  <title>Timetable Management System</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <link
    rel="icon"
    href="assets/img/kaiadmin/favicon.ico"
    type="image/x-icon" />
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
  <link rel="stylesheet" type="text/css" href="assets/css/main.css">

  <style>
    body.login-theme {
      margin: 0;
      min-height: 100vh;
      background-color: #0b1530;
      background-image:
        radial-gradient(circle at 18% 20%, rgba(78, 195, 255, 0.28), transparent 26%),
        radial-gradient(circle at 82% 16%, rgba(74, 242, 197, 0.22), transparent 24%),
        radial-gradient(circle at 55% 78%, rgba(246, 201, 121, 0.16), transparent 26%),
        repeating-linear-gradient(90deg, var(--grid), var(--grid) 1px, transparent 1px, transparent 110px),
        repeating-linear-gradient(0deg, var(--grid), var(--grid) 1px, transparent 1px, transparent 78px),
        linear-gradient(135deg, var(--bg-1), var(--bg-2) 45%, var(--bg-3));
      background-size: 780px 780px, 740px 740px, 620px 620px, cover, 220px 220px, 180px 180px;
      background-repeat: no-repeat;
      background-attachment: fixed;
      color: #e2e8f0;
      position: relative;
      overflow: hidden;
    }

    .login-theme .grid-overlay {
      position: fixed;
      inset: 0;
      background-image:
        linear-gradient(90deg, rgba(94, 234, 212, 0.08) 1px, transparent 1px),
        linear-gradient(0deg, rgba(59, 130, 246, 0.07) 1px, transparent 1px);
      background-size: 110px 110px, 110px 110px;
      opacity: 0.38;
      mix-blend-mode: screen;
      pointer-events: none;
      animation: gridDrift 32s linear infinite;
    }

    @keyframes gridDrift {
      0% {
        transform: translate3d(0, 0, 0);
      }

      100% {
        transform: translate3d(-40px, -40px, 0);
      }
    }

    body.login-theme::before,
    body.login-theme::after {
      content: "";
      position: absolute;
      inset: -180px;
      background: conic-gradient(from 150deg, rgba(59, 130, 246, 0.22), rgba(45, 212, 191, 0.22), rgba(14, 165, 233, 0.2), rgba(59, 130, 246, 0.22));
      mix-blend-mode: screen;
      filter: blur(120px);
      opacity: 0.35;
      animation: glowShift 12s ease-in-out infinite alternate;
      pointer-events: none;
    }

    body.login-theme::after {
      animation-delay: 4s;
      opacity: 0.28;
    }

    @keyframes glowShift {
      0% {
        transform: translate3d(-4%, -2%, 0) scale(1);
      }

      100% {
        transform: translate3d(6%, 3%, 0) scale(1.05);
      }
    }

    .login-hero h2,
    .login-hero h3 {
      color: #e2e8f0;
    }

    .login-hero .heading-section.title {
      font-weight: 700;
      letter-spacing: -0.4px;
      display: inline-block;
      background: linear-gradient(120deg, #38bdf8, #a855f7 45%, #f59e0b 80%);
      background-clip: text;
      -webkit-background-clip: text;
      color: transparent;
      -webkit-text-fill-color: transparent;
    }

    .login-panel {
      background: linear-gradient(160deg, rgba(15, 23, 42, 0.8), rgba(18, 30, 60, 0.9));
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 18px;
      box-shadow: 0 24px 70px rgba(0, 0, 0, 0.48);
      backdrop-filter: blur(10px);
      position: relative;
      overflow: hidden;
      padding-top: 18px;
      isolation: isolate;
    }

    .login-panel::before {
      content: "";
      position: absolute;
      inset: 0;
      background: radial-gradient(circle at 20% 20%, rgba(59, 130, 246, 0.18), transparent 38%);
      pointer-events: none;
    }

    .login-panel::after {
      content: "";
      position: absolute;
      top: 0;
      left: 16px;
      right: 16px;
      height: 3px;
      border-radius: 999px;
      background: linear-gradient(120deg, #38bdf8, #a855f7, #f59e0b);
      box-shadow: 0 0 18px rgba(56, 189, 248, 0.4);
      opacity: 0.9;
    }

    .login-panel h3 {
      color: #e2e8f0;
    }

    .login-panel .form-control.transparent-input {
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.16);
      color: #e2e8f0;
      box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.08);
      border-radius: 14px;
      transition: border-color 0.15s ease, box-shadow 0.15s ease, transform 0.12s ease;
    }

    .login-panel .form-control.transparent-input:focus {
      border-color: rgba(59, 130, 246, 0.65);
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
      transform: translateY(-1px);
      background: rgba(255, 255, 255, 0.08);
    }

    .login-theme .btn-primary {
      background: linear-gradient(120deg, #2563eb, #22c55e);
      border: none;
      box-shadow: 0 10px 30px rgba(37, 99, 235, 0.45);
      transition: transform 0.15s ease, box-shadow 0.15s ease, filter 0.15s ease;
      border-radius: 14px;
    }

    .login-theme .btn-primary:hover {
      transform: translateY(-1px);
      box-shadow: 0 14px 36px rgba(37, 99, 235, 0.55);
      filter: brightness(1.04);
    }

    .login-theme .field-icon {
      color: rgba(255, 255, 255, 0.8);
    }

    .login-theme .login-panel .floating-accents span {
      position: absolute;
      width: 12px;
      height: 12px;
      border-radius: 50%;
      background: radial-gradient(circle, #60a5fa, transparent 60%);
      opacity: 0.6;
      animation: floaty 10s ease-in-out infinite;
      filter: blur(0.2px);
    }

    .login-theme .login-panel .floating-accents span:nth-child(2) {
      top: 50%;
      right: 16px;
      animation-delay: 2s;
      background: radial-gradient(circle, #22c55e, transparent 60%);
    }

    .login-theme .login-panel .floating-accents span:nth-child(3) {
      bottom: 12px;
      left: 20%;
      animation-delay: 4s;
      background: radial-gradient(circle, #a855f7, transparent 60%);
    }

    @keyframes floaty {
      0% {
        transform: translate3d(0, 0, 0) scale(1);
        opacity: 0.6;
      }

      50% {
        transform: translate3d(6px, -10px, 0) scale(1.1);
        opacity: 0.85;
      }

      100% {
        transform: translate3d(-4px, 8px, 0) scale(0.95);
        opacity: 0.6;
      }
    }

    .login-theme .info-row {
      display: flex;
      justify-content: center;
      gap: 12px;
      flex-wrap: wrap;
      margin-top: 12px;
      margin-bottom: 0;
    }

    .login-theme .info-pill {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 8px 12px;
      border-radius: 999px;
      background: rgba(255, 255, 255, 0.06);
      border: 1px solid rgba(255, 255, 255, 0.12);
      color: #cbd5e1;
      font-size: 13px;
      box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.08), 0 12px 24px rgba(0, 0, 0, 0.18);
      backdrop-filter: blur(4px);
    }

    .login-theme .info-pill i {
      color: #38bdf8;
    }
  </style>

</head>

<body class="login-theme">
  <div class="grid-overlay"></div>

  <section class="ftco-section">
    <div class="container" style="margin-top: 100px;">
      <div class="row justify-content-center">
        <div class="col-md-7 text-center mb-5 login-hero">
          <h3 class="heading-section title">Timetable Management System</h3>
          <div class="info-row">
            <div class="info-pill"><i class="fa fa-shield-alt"></i>Secure access</div>
            <div class="info-pill"><i class="fa fa-calendar-check"></i>Conflict-free scheduling</div>
            <div class="info-pill"><i class="fa fa-bolt"></i>Live timetable status</div>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
          <div class="login-wrap p-0 login-panel">
            <div class="floating-accents" aria-hidden="true">
              <span style="top: 18px; left: 12px;"></span>
              <span></span>
              <span></span>
            </div>
            <h3 class="mb-4 text-center">Admin</h3>
            <form name="f1" action="login.php" class="signin-form" onsubmit="return validation()" method="POST">
              <div class="form-group">
                <input type="text" id="username" class="form-control transparent-input" placeholder="Username" name="username" required>
              </div>
              <div class="form-group" style="position: relative;">
                <input id="password-field" type="password" class="form-control transparent-input " placeholder="Password" name="password" required>
                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password" style="position: absolute; right: 25px; top: 50%; transform: translateY(-50%); cursor: pointer;"></span>
              </div>


              <div class="form-group">
                <button type="submit" class="form-control btn btn-primary submit px-3">Login In</button>
              </div>
            </form>
          </div>
        </div>
      </div>
  </section>

  <script src="assets/js/core/jquery-3.7.1.min.js"></script>
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
  <script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
  <script src="assets/js/main.js"></script>
  <script>
    function validation() {
      var id = document.f1.username.value;
      var ps = document.f1.password.value;
      if (id.length == "" && ps.length == "") {
        alert("User Name and Password fields are empty");
        return false;
      } else {
        if (id.length == "") {
          alert("User Name is empty");
          return false;
        }
        if (ps.length == "") {
          alert("Password field is empty");
          return false;
        }
      }
    }

    $(document).ready(function() {
      var loginError = <?php echo json_encode($loginError); ?>;
      if (loginError) {
        var content = {
          message: loginError,
          title: "Warning",
          icon: "fa fa-exclamation-triangle"
        };
        $.notify(content, {
          type: "warning",
          placement: {
            from: "top",
            align: "center",
          },
          time: 1000,
          delay: 5000,
          animate: {
            enter: 'animated fadeInDown',
            exit: 'animated fadeOutUp',
          },
        });
      }
    });
  </script>
</body>

</html>
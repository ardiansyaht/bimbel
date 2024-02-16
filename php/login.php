<?php
session_start();
header("X-Frame-Options: DENY");

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'bimbel';

// Membuat koneksi ke database dengan PDO
try {
  $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Koneksi ke database gagal: " . $e->getMessage());
}

// Menangani data dari formulir
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
  $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');

  try {
    // Menggunakan prepared statement untuk query ke database
    $query = "SELECT * FROM tb_login WHERE email = :email";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
      // Jika email ditemukan, verifikasi password
      $hashedPassword = $result['password'];

      if (password_verify($password, $hashedPassword)) {
        // Password benar, set session email dan role
        $_SESSION['session_email'] = $result['email'];
        $_SESSION['role'] = $result['role'];

        // Redirect ke homepage.php sesuai role
        if ($_SESSION['role'] == 'admin') {
          header('Location: dashboard.php');
        } elseif ($_SESSION['role'] == 'user') {
          header('Location: homepage.php');
        }
        exit();
      } else {
        $_SESSION['login_message'] = 'Login gagal. Periksa kembali email dan password Anda.';
      }
    } else {
      $_SESSION['login_message'] = 'Login gagal. Periksa kembali email dan password Anda.';
    }
  } catch (PDOException $e) {
    $_SESSION['login_message'] = 'Error: ' . $e->getMessage();
  }
}

// Menutup koneksi
$conn = null;
?>



<!DOCTYPE html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    Login
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/material-kit.css?v=3.0.4" rel="stylesheet" />
  <!-- Nepcha Analytics (nepcha.com) -->
  <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
  <!-- <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script> -->
</head>
<div class="page-header align-items-start min-vh-100" style="background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');" loading="lazy">
  <span class="mask bg-gradient-dark opacity-6"></span>
  <div class="container my-auto">
    <div class="row">
      <div class="col-lg-4 col-md-8 col-12 mx-auto">
        <div class="card z-index-0 fadeIn3 fadeInBottom">
          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
              <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Sign in</h4>
              <div class="row mt-3">
                <div class="col-2 text-center ms-auto">
                  <a class="btn btn-link px-3" href="javascript:;">

                  </a>
                </div>

                <div class="col-2 text-center me-auto">
                  <a class="btn btn-link px-3" href="javascript:;">

                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="card-body">
            <form role="form" class="text-start" method="post">
              <div class="input-group input-group-outline my-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="exampleInputEmail1">
              </div>
              <div class="input-group input-group-outline mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="exampleInputPassword1">
              </div>
              <div class="form-check form-switch d-flex align-items-center mb-3">
                <!-- <input class="form-check-input" type="checkbox" id="rememberMe" checked> -->
                <!-- <label class="form-check-label mb-0 ms-3" for="rememberMe">Remember me</label> -->
              </div>
              <div class="text-center">
                <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Sign in</button>
              </div>
            </form>

            <p class="mt-4 text-sm text-center">
              Don't have an account? <a href="register.php">Register</a></p>
            </p>
            <p class="mt-4 text-sm text-center">
              <a href="forgot_password.php">Forgot Password</a>
            </p>
            </p>

          </div>
        </div>
      </div>
    </div>
    <div class="col-12">
      <div class="text-center">
        <p class="text-dark my-4 text-sm font-weight-normal">
          Copyright © <script>
            document.write(new Date().getFullYear())
          </script> 21552011098_M Wipaldi Nurpadilah_KELOMPOK3_TIFRP-221PA <a href="" target="_blank">UASWEB1</a>.
      </div>
      <footer class="footer position-absolute bottom-2 py-2 w-100">
        <div class="container">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-12 col-md-6 my-auto">
              <div class="copyright text-center text-sm text-white text-lg-start">
                <script>


                </script>
              </div>

            </div>
          </div>
      </footer>
    </div>
    <!--   Core JS Files   -->
    <script src="../assets/js/core/popper.min.js" type="text/javascript"></script>
    <script src="../assets/js/core/bootstrap.min.js" type="text/javascript"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <!-- Control Center for Material UI Kit: parallax effects, scripts for the example pages etc -->
    <!--  Google Maps Plugin    -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTTfWur0PDbZWPr7Pmq8K3jiDp0_xUziI"></script>
    <script src="../assets/js/material-kit.min.js?v=3.0.4" type="text/javascript"></script>

    </body>

</html>
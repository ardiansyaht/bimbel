<?php
session_start();

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'bimbel';

// Membuat koneksi ke database
$conn = new mysqli($host, $username, $password, $database);

// Memeriksa koneksi
if ($conn->connect_error) {
  die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Menangani data dari formulir
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Validasi apakah username sudah digunakan
  $checkUsernameQuery = "SELECT * FROM tb_login WHERE username = '$username'";
  $checkUsernameResult = $conn->query($checkUsernameQuery);

  // Validasi apakah email sudah digunakan
  $checkEmailQuery = "SELECT * FROM tb_login WHERE email = '$email'";
  $checkEmailResult = $conn->query($checkEmailQuery);

  if ($checkUsernameResult->num_rows > 0) {
    $_SESSION['register_message'] = 'Username sudah digunakan. Silakan gunakan yang lain.';
  } elseif ($checkEmailResult->num_rows > 0) {
    $_SESSION['register_message'] = 'Email sudah digunakan. Silakan gunakan yang lain.';
  } else {
    // Enkripsi password menggunakan bcrypt
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Menyimpan data pengguna ke database
    $query = "INSERT INTO tb_login (username, name, email, password, role) VALUES ('$username', '$name', '$email', '$hashedPassword', 'user')";

    // Eksekusi query
    if ($conn->query($query) === TRUE) {
      $_SESSION['register_message'] = 'Registrasi berhasil. Silakan login.';
      header("Location: login.php");
      exit();
    } else {
      $_SESSION['register_message'] = 'Registrasi gagal.';
    }
  }
}

// Menutup koneksi
$conn->close();
?>



<!DOCTYPE html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    Register
  </title>
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <link id="pagestyle" href="../assets/css/material-kit.css?v=3.0.4" rel="stylesheet" />
  <!-- <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script> -->
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <script>
    function validateForm() {
      var username = document.getElementById('exampleInputUsername').value;
      var email = document.getElementById('exampleInputEmail1').value;
      var password = document.getElementById('exampleInputPassword1').value;

      if (username === '' || email === '' || password === '') {
        alert('Semua kolom harus diisi.');
        return false;
      }

      // Tambahkan validasi lain sesuai kebutuhan

      return true;
    }
  </script>

</head>
<div class="page-header align-items-start min-vh-100" style="background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');" loading="lazy">
  <div class="container my-auto">
    <div class="row">
      <div class="col-lg-4 col-md-8 col-12 mx-auto">
        <div class="card z-index-0 fadeIn3 fadeInBottom">
          <div class="card-body">
            <form role="form" class="text-start" method="post" action="register.php" onsubmit="return validateForm();">
              <div class="mb-3">
                <input type="text" class="form-control" id="exampleInputUsername" name="username" placeholder="Username">
              </div>
              <div class="mb-3">
                <input type="text" class="form-control" id="exampleInputName" name="name" placeholder="Name">
              </div>
              <div class="mb-3">
                <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" placeholder="Email">
              </div>
              <div class="mb-3">
                <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Password">

              </div>
              <div class="text-center">
                <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Register</button>
              </div>
            </form>
            <div class="text-center">
              <?php
              if (isset($_SESSION['register_message'])) {
                echo $_SESSION['register_message'];
                unset($_SESSION['register_message']); // Hapus pesan agar tidak tampil lagi
              } else {
                echo 'Already have an account? <a href="login.php">Sign in</a>';
              }
              ?></p>
            </div>

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

      </footer>
    </div>
    <!-- End Page content -->

    <!-- Scripts -->
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/chartjs.min.js"></script>
    <script src="../assets/js/plugins/Chart.extension.js"></script>
    <script src="../assets/js/plugins/choices.min.js"></script>
    <script src="../assets/js/plugins/prism.min.js"></script>
    <script src="../assets/js/plugins/datepicker.min.js"></script>
    <script src="../assets/js/plugins/daterangepicker.min.js"></script>
    <script src="../assets/js/plugins/nouislider.min.js"></script>
    <script src="../assets/js/plugins/swiper.min.js"></script>
    <script src="../assets/js/plugins/slick.min.js"></script>
    <script src="../assets/js/plugins/interactjs.min.js"></script>
    <script src="../assets/js/material-kit.js?v=3.0.4"></script>
    <script>
      function validateForm() {
        var password = document.getElementById('exampleInputPassword1').value;

        // Validasi panjang password dan karakter khusus
        var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&*]{8,}$/;
        if (!passwordRegex.test(password)) {
          alert('Password harus minimal 8 karakter, mengandung setidaknya 1 huruf kecil, 1 huruf besar, dan 1 simbol.');
          return false;
        }

        return true;
      }
    </script>


    </body>

</html>
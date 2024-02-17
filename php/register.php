<?php
session_start();
header("X-Frame-Options: DENY");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

function connectToDatabase()
{
  $host = 'localhost';
  $username = 'root';
  $password = '';
  $database = 'bimbel';

  try {
    $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
  } catch (PDOException $e) {
    die("Koneksi ke database gagal: " . $e->getMessage());
  }
}

function generateOTP()
{
  return strval(rand(100000, 999999));
}

function sendOTPByEmail($to, $otp_code)
{
  $mail = new PHPMailer(true);

  try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'mccalister2306@gmail.com'; // Ganti dengan email Anda
    $mail->Password = 'zjcijgwvhntdeekm'; // Ganti dengan password email Anda
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('mccalister2306@gmail.com', 'CodinginAJA'); // Ganti dengan email dan nama Anda
    $mail->addAddress($to);
    $mail->Subject = 'Kode Verifikasi';
    $mail->Body = "Kode verifikasi Anda: $otp_code";

    $mail->send();
  } catch (Exception $e) {
    // Tangani kesalahan pengiriman email
    echo 'Gagal mengirim email verifikasi. Pesan error: ' . $mail->ErrorInfo;
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $conn = connectToDatabase();

  $username = $_POST['username'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Gunakan parameterized query untuk mencegah SQL injection
  $checkUsernameQuery = "SELECT * FROM tb_login WHERE username = :username";
  $checkEmailQuery = "SELECT * FROM tb_login WHERE email = :email";

  $stmtUsername = $conn->prepare($checkUsernameQuery);
  $stmtUsername->bindParam(':username', $username);
  $stmtUsername->execute();
  $checkUsernameResult = $stmtUsername->fetch(PDO::FETCH_ASSOC);

  $stmtEmail = $conn->prepare($checkEmailQuery);
  $stmtEmail->bindParam(':email', $email);
  $stmtEmail->execute();
  $checkEmailResult = $stmtEmail->fetch(PDO::FETCH_ASSOC);

  if ($checkUsernameResult) {
    $_SESSION['register_message'] = 'Username sudah digunakan. Silakan gunakan yang lain.';
  } elseif ($checkEmailResult) {
    $_SESSION['register_message'] = 'Email sudah digunakan. Silakan gunakan yang lain.';
  } else {
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $otp_code = generateOTP();

    // Simpan data pengguna ke database menggunakan parameterized query
    $query = "INSERT INTO tb_login (username, name, email, password, role, otp_code) VALUES (:username, :name, :email, :password, 'user', :otp_code)";

    $stmtInsert = $conn->prepare($query);
    $stmtInsert->bindParam(':username', $username);
    $stmtInsert->bindParam(':name', $name);
    $stmtInsert->bindParam(':email', $email);
    $stmtInsert->bindParam(':password', $hashedPassword);
    $stmtInsert->bindParam(':otp_code', $otp_code);

    try {
      $conn->beginTransaction();
      $stmtInsert->execute();
      $conn->commit();

      sendOTPByEmail($email, $otp_code);

      $_SESSION['register_message'] = 'Registrasi berhasil. Silakan cek email Anda untuk kode verifikasi.';
      // Pindah ke verification.php setelah 2 detik
      echo "<script>
                setTimeout(function () {
                    window.location.href = 'verification.php';
                }, 2000);
            </script>";
    } catch (PDOException $e) {
      // Rollback jika terjadi kesalahan
      $conn->rollBack();
      $_SESSION['register_message'] = 'Registrasi gagal.';
    }
  }

  $conn = null; // Tutup koneksi database
}
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
  <span class="mask bg-gradient-dark opacity-6"></span>
  <div class="container my-auto">
    <div class="row">
      <div class="col-lg-4 col-md-8 col-12 mx-auto">
        <div class="card z-index-0 fadeIn3 fadeInBottom">
          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
              <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Register</h4>
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
            <form role="form" class="text-start" method="post" action="register.php" onsubmit="return validateForm();">
              <div class="mb-3">
                <input type="text" class="form-control" id="exampleInputUsername" name="username" placeholder="Username" required>
              </div>
              <div class="mb-3">
                <input type="text" class="form-control" id="exampleInputName" name="name" placeholder="Name" required>
              </div>
              <div class="mb-3">
                <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" placeholder="Email" required>
              </div>
              <div class="mb-3">
                <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Password" required>
              </div>
              <div class="text-center">
                <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Register</button>
              </div>
            </form>
            <div class="text-center">
              <?php
              if (isset($_SESSION['register_message'])) {
                echo htmlspecialchars($_SESSION['register_message'], ENT_QUOTES, 'UTF-8');
                unset($_SESSION['register_message']); // Hapus pesan agar tidak tampil lagi
              } else {
                echo 'Already have an account? <a href="login.php">Sign in</a>';
              }
              ?>
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
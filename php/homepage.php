<?php
session_start();
header("X-Frame-Options: DENY");

// Check if the user is not logged in
if (!isset($_SESSION['session_email'])) {
  // Redirect to the login page
  $_SESSION['login_message'] = 'Anda harus login terlebih dahulu.';
  header('Location: login.php');
  exit();
}


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

$userRole = isset($_SESSION['role']) ? $_SESSION['role'] : '';
?>



<!DOCTYPE html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    CodinginAJA
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
  <!-- <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script> -->
</head>

<body class="about-us bg-gray-200">
  <!-- Navbar Transparent -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="#"> Welcome TO CodinginAJA</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a href="create.php" class="btn btn-sm bg-white mb-0 me-1 mt-2 mt-md-0">Daftar</a>
          </li>
          <li class="nav-item">
            <a href="profile_page.php" class="btn btn-sm bg-white mb-0 me-1 mt-2 mt-md-0">Profile</a>
          </li>
          <?php if ($userRole == 'admin') : ?>
            <li class="nav-item">
              <a href="dashboard.php" class="btn btn-sm bg-white mb-0 me-1 mt-2 mt-md-0">Dashboard</a>
            </li>
          <?php endif; ?>
          <li class="nav-item">
            <a href="#" class="btn btn-sm bg-white mb-0 me-1 mt-2 mt-md-0" onclick="logout()">Log Out</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- End Navbar -->
  <header class="bg-gradient-dark">
    <div class="page-header min-vh-75" style="background-image: url('../assets/img/bg12.jpg');">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8 text-center mx-auto my-auto">
            <h1 class="text-white">Eksplorasi Dunia Digital </h1>
            <p class="lead mb-4 text-white opacity-8">Kembangkan Keterampilan Teknologi Anda dan Temukan Kreativitas Anda dalam Kode</p>

            <h6 class="text-white mb-2 mt-5">Find us on</h6>
            <div class="d-flex justify-content-center">
              <a href="javascript:;"><i class="fab fa-facebook text-lg text-white me-4"></i></a>
              <a href="javascript:;"><i class="fab fa-instagram text-lg text-white me-4"></i></a>
              <a href="javascript:;"><i class="fab fa-twitter text-lg text-white me-4"></i></a>
              <a href="javascript:;"><i class="fab fa-google-plus text-lg text-white"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
  <!-- -------- END HEADER 7 w/ text and video ------- -->
  <div class="card card-body shadow-xl mx-3 mx-md-4 mt-n6">
    <!-- Section with four info areas left & one card right with image and waves -->
    <section class="py-7">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6">
            <div class="row justify-content-start">
              <div class="col-md-6">
                <div class="info">
                  <i class="material-icons text-3xl text-gradient text-info mb-3">public</i>
                  <h5>Fully integrated</h5>
                  <p>Dengan fitur-fitur yang terintegrasi sepenuhnya, kami memastikan pengalaman tanpa gangguan</p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="info">


                </div>
              </div>
            </div>
            <div class="row justify-content-start mt-4">
              <div class="col-md-6">
                <div class="info">
                  <i class="material-icons text-3xl text-gradient text-info mb-3">apps</i>
                  <h5>Kelas</h5>
                  <p>Belajar dari mana saja dengan kelas online kami dan Jelajahi juga materi pelajaran secara mendalam dalam kelas offline kami yang terarah</p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="info">
                  <i class="material-icons text-3xl text-gradient text-info mb-3">3p</i>
                  <h5>platform</h5>
                  <p>Nikmati fitur-fitur baru dan peningkatan kinerja dengan platform kami yang diperbaharui</p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 ms-auto mt-lg-0 mt-4">
            <div class="card">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <a class="d-block blur-shadow-image">
                  <img src="https://images.unsplash.com/photo-1544717302-de2939b7ef71?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80" alt="img-colored-shadow" class="img-fluid border-radius-lg">
                </a>
              </div>
              <div class="card-body text-center">
                <h5 class="font-weight-normal">
                  <a href="javascript:;">Get insights on Search</a>
                </h5>
                <p class="mb-0">
                  Dengan platform kami, Anda dapat memperoleh pemahaman yang mendalam tentang perilaku pengguna dalam pencarian
                </p>
                <button type="button" class="btn bg-gradient-info btn-sm mb-0 mt-3">Find out more</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- END Section with four info areas left & one card right with image and waves -->
    <!-- -------- START Features w/ pattern background & stats & rocket -------- -->
    <section class="pb-5 position-relative bg-gradient-dark mx-n3">
      <div class="container">
        <div class="row">
          <div class="col-md-8 text-start mb-5 mt-5">
            <h3 class="text-white z-index-1 position-relative">Paket Populer</h3>
            <p class="text-white opacity-8 mb-0">Pilihlah dari paket-paket populer kami untuk pengalaman terbaik</p>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6 col-12">
            <div class="card card-profile mt-4">
              <div class="row">
                <div class="col-lg-4 col-md-6 col-12 mt-n5">
                  <a href="javascript:;">
                    <div class="p-3 pe-md-0">
                      <img class="w-100 border-radius-md shadow-lg" src="../assets/img/pemrograman.jpg" alt="image">
                    </div>
                  </a>
                </div>
                <div class="col-lg-8 col-md-6 col-12 my-auto">
                  <div class="card-body ps-lg-0">
                    <h5 class="mb-0">Paket Dasar Pemrograman</h5>
                    <h6 class="text-info">Bahasa Pemrograman</h6>
                    <p class="mb-0">Bangun karier Anda dalam dunia teknologi dengan kursus bahasa pemrograman kami! Dapatkan diskon khusus untuk mendaftar sekarang</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-12">
            <div class="card card-profile mt-lg-4 mt-5">
              <div class="row">
                <div class="col-lg-4 col-md-6 col-12 mt-n5">
                  <a href="javascript:;">
                    <div class="p-3 pe-md-0">
                      <img class="w-100 border-radius-md shadow-lg" src="../assets/img/data.jpg" alt="image">
                    </div>
                  </a>
                </div>
                <div class="col-lg-8 col-md-6 col-12 my-auto">
                  <div class="card-body ps-lg-0">
                    <h5 class="mb-0">Paket Basis Data dan Manajemen Informasi</h5>
                    <h6 class="text-info">Struktur Basis Data</h6>
                    <p class="mb-0">Pelajari konsep penting dalam Struktur Basis Data dengan instruktur ahli kami. Hemat hingga 40% dengan pendaftaran sekarang</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-lg-6 col-12">
            <div class="card card-profile mt-4 z-index-2">
              <div class="row">
                <div class="col-lg-4 col-md-6 col-12 mt-n5">
                  <a href="javascript:;">
                    <div class="p-3 pe-md-0">
                      <img class="w-100 border-radius-md shadow-lg" src="../assets/img/jaringan.jpg" alt="image">
                    </div>
                  </a>
                </div>
                <div class="col-lg-8 col-md-6 col-12 my-auto">
                  <div class="card-body ps-lg-0">
                    <h5 class="mb-0">Paket Jaringan Komputer</h5>
                    <h6 class="text-info">Pengelolaan Jaringan</h6>
                    <p class="mb-0">Jadilah ahli dalam administrasi jaringan dengan kursus kami. Bergabung sekarang dan dapatkan konsultasi gratis bersama instruktur kami</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-12">
            <div class="card card-profile mt-lg-4 mt-5 z-index-2">
              <div class="row">
                <div class="col-lg-4 col-md-6 col-12 mt-n5">
                  <a href="javascript:;">
                    <div class="p-3 pe-md-0">
                      <img class="w-100 border-radius-md shadow-lg" src="../assets/img/ui.jpg" alt="image">
                    </div>
                  </a>
                </div>
                <div class="col-lg-8 col-md-6 col-12 my-auto">
                  <div class="card-body ps-lg-0">
                    <h5 class="mb-0">Paket Pengembangan Aplikasi Mobile</h5>
                    <h6 class="text-info">Desain Antarmuka Pengguna (UI/UX)</h6>
                    <p class="mb-0">Pelajari teknik desain UI/UX terbaik dengan kursus kami. Tawaran spesial untuk pendaftaran awal! Jangan lewatkan kesempatan ini.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- -------- END Features w/ pattern background & stats & rocket -------- -->
    <section class="pt-4 pb-6" id="count-stats">


  </div>
  </div>
  </section>
  <!-- -------- START PRE-FOOTER 1 w/ SUBSCRIBE BUTTON AND IMAGE ------- -->
  <section class="my-5 pt-5">
    <div class="container">
      <div class="row">
        <div class="col-md-6 m-auto">
          <!-- <h4>Be the first to see the news</h4>
          <p class="mb-4">
            Your company may not be in the software business,
            but eventually, a software company will be in your business.
          </p>
          <div class="row">
            <div class="col-8">
              <div class="input-group input-group-outline">
                <label class="form-label">Email Here...</label>
                <input type="text" class="form-control mb-sm-0">
              </div>
            </div>
            <div class="col-4 ps-0">
              <button type="button" class="btn bg-gradient-info mb-0 h-100 position-relative z-index-2">Subscribe</button>
            </div> -->
        </div>
      </div>
      <div class="col-md-5 ms-auto">
        <div class="position-relative">
          <img class="max-width-50 w-100 position-relative z-index-2" src="../assets/img/macbook.png" alt="image">
        </div>
      </div>
    </div>
    </div>
  </section>
  <!-- -------- END PRE-FOOTER 1 w/ SUBSCRIBE BUTTON AND IMAGE ------- -->
  </div>
  <footer class="footer pt-5 mt-5">
    <div class="container">
      <div class=" row">
        <div class="col-md-3 mb-4 ms-auto">
          <div>
            <a href="">
              <img src="../assets/img/logo-ct-dark.png" class="mb-3 footer-logo" alt="main_logo">
            </a>
            <h6 class="font-weight-bolder mb-4">CodinginAJA</h6>
          </div>
          <div>
            <ul class="d-flex flex-row ms-n3 nav">
              <li class="nav-item">
                <a class="nav-link pe-1" href="https://www.facebook.com/" target="_blank">
                  <i class="fab fa-facebook text-lg opacity-8"></i>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link pe-1" href="https://twitter.com/" target="_blank">
                  <i class="fab fa-twitter text-lg opacity-8"></i>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link pe-1" href="https://www.youtube.com/" target="_blank">
                  <i class="fab fa-youtube text-lg opacity-8"></i>
                </a>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-md-2 col-sm-6 col-6 mb-4">
          <div>
            <h6 class="text-sm">Company</h6>
            <ul class="flex-column ms-n3 nav">
              <li class="nav-item">
                <a class="nav-link" href="" target="_blank">
                  About Us
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="" target="_blank">
                  Blog
                </a>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-md-2 col-sm-6 col-6 mb-4">
          <div>
            <h6 class="text-sm">Resources</h6>
            <ul class="flex-column ms-n3 nav">
              <li class="nav-item">
                <a class="nav-link" href="" target="_blank">
                  Illustrations
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="" target="_blank">
                  Affiliate Program
                </a>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-md-2 col-sm-6 col-6 mb-4">
          <div>
            <h6 class="text-sm">Help & Support</h6>
            <ul class="flex-column ms-n3 nav">
              <li class="nav-item">
                <a class="nav-link" href="" target="_blank">
                  Contact Us
                </a>
              </li>

              </li>
            </ul>
          </div>
        </div>
        <div class="col-md-2 col-sm-6 col-6 mb-4 me-auto">
          <div>
            <h6 class="text-sm">Legal</h6>
            <ul class="flex-column ms-n3 nav">
              <li class="nav-item">
                <a class="nav-link" href="" target="_blank">
                  Terms & Conditions
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="" target="_blank">
                  Privacy
                </a>
              </li>

            </ul>
          </div>
        </div>
        <div class="col-12">
          <div class="text-center">
            <p class="text-dark my-4 text-sm font-weight-normal">
              Copyright © <script>
                document.write(new Date().getFullYear())
              </script> 21552011098_M Wipaldi Nurpadilah_KELOMPOK3_TIFRP-221PA <a href="" target="_blank">UASWEB1</a>.
            </p>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script>
    function logout() {
      $.ajax({
        type: "POST",
        url: "logout.php", // Sesuaikan dengan nama file logout.php
        success: function(response) {
          // Handle response jika diperlukan
          console.log(response);

          // Redirect ke halaman login setelah logout
          window.location.href = "login.php";
        }
      });
    }
  </script>
</body>

</html>
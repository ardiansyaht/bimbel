<?php
session_start();
header("X-Frame-Options: DENY");

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

function validateOTP($email, $otp)
{
    $conn = connectToDatabase();

    $sql = "SELECT * FROM tb_login WHERE email = ? AND otp_code = ? AND status = 'notverified'";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email, $otp]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $conn = null;

    return $result !== false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = connectToDatabase();

    $email = $_POST['email'];
    $otp_code = $_POST['otp_code'];

    if (validateOTP($email, $otp_code)) {
        // Update status menjadi verified
        $updateStatusSQL = "UPDATE tb_login SET status = 'verified' WHERE email = ?";
        $updateStatusStmt = $conn->prepare($updateStatusSQL);
        $updateStatusStmt->execute([$email]);

        header("Location: login.php");
        exit();
    } else {
        $_SESSION['verification_message'] = 'Verifikasi gagal. Kode OTP tidak valid atau sudah kedaluwarsa.';
    }

    $conn = null;
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
        Verification
    </title>
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link id="pagestyle" href="../assets/css/material-kit.css?v=3.0.4" rel="stylesheet" />
</head>

<body>
    <div class="page-header align-items-start min-vh-100" style="background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');" loading="lazy">
        <span class="mask bg-gradient-dark opacity-6"></span>
        <div class="container my-auto">
            <div class="row">
                <div class="col-lg-4 col-md-8 col-12 mx-auto">
                    <div class="card z-index-0 fadeIn3 fadeInBottom">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                                <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Verification</h4>
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
                                <div class="mb-3">
                                    <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" placeholder="Email" required>
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control" id="exampleInputOTP" name="otp_code" placeholder="OTP Code" required>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Verify</button>
                                </div>
                            </form>
                            <div class="text-center">
                                <?php
                                if (isset($_SESSION['verification_message'])) {
                                    echo htmlspecialchars($_SESSION['verification_message'], ENT_QUOTES, 'UTF-8');
                                    unset($_SESSION['verification_message']); // Hapus pesan agar tidak tampil lagi
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
                <footer class="footer position-absolute bottom-2 py-2 w-100"></footer>
            </div>
        </div>
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
</body>

</html>
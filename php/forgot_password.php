<?php
// Tambahkan koneksi ke database dan logika reset password di sini
$resetMessage = '';
$showPasswordInput = false;

// Buat koneksi ke database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'bimbel';

try {
    $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi ke database gagal: " . $e->getMessage());
}

function validatePassword($password)
{
    // Sesuaikan aturan validasi sesuai kebutuhan
    $length = strlen($password) >= 8;
    $containsLower = preg_match('/[a-z]/', $password);
    $containsUpper = preg_match('/[A-Z]/', $password);
    $containsSymbol = preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password);

    return $length && $containsLower && $containsUpper && $containsSymbol;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil email dari formulir
    $email = $_POST['email'];

    // Cek apakah email ada di database
    $emailExists = true; // Ganti dengan logika cek email di database
    if ($emailExists) {
        // Jika email ada, ganti tampilan ke input password
        $showPasswordInput = true;
    } else {
    }
}

// Logika untuk mengganti password di sini
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['new_password'])) {
    // Ambil email dan password baru dari formulir
    $email = $_POST['email'];
    $newPassword = $_POST['new_password'];

    // Validasi password
    if (!validatePassword($newPassword)) {
        $resetMessage = 'Password harus memiliki minimal 8 karakter, 1 huruf kecil, 1 huruf besar, dan 1 simbol.';
    } else {
        // Proses penggantian password di database
        // ...

        // Hash password menggunakan Bcrypt
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        // Implementasikan query UPDATE untuk mengubah password di database
        $query = "UPDATE tb_login SET password = :hashedPassword WHERE email = :email";

        // Persiapkan dan eksekusi statement
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':hashedPassword', $hashedPassword);
        $stmt->bindParam(':email', $email);

        // Eksekusi query dan periksa kesalahan
        if ($stmt->execute()) {
            $resetMessage = 'Password telah berhasil diubah.';
        } else {
            $resetMessage = 'Gagal mengubah password. Kesalahan: ' . implode(" ", $stmt->errorInfo());
        }
    }
}
?>




<!DOCTYPE html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <title>Forgot Password</title>
    <!-- Fonts and icons -->
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
</head>

<body class="about-us bg-gray-200">
    <!-- Navbar Transparent -->
    <!-- Add your navigation bar here if needed -->

    <div class="page-header align-items-start min-vh-100" style="background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');" loading="lazy">
        <span class="mask bg-gradient-dark opacity-6"></span>
        <div class="container my-auto">
            <div class="row">
                <div class="col-lg-4 col-md-8 col-12 mx-auto">
                    <div class="card z-index-0 fadeIn3 fadeInBottom">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                                <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Forgot Password</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($resetMessage)) : ?>
                                <div class="alert alert-success" role="alert">
                                    <?php echo htmlspecialchars($resetMessage, ENT_QUOTES, 'UTF-8'); ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($showPasswordInput) : ?>
                                <!-- Tampilkan formulir input password -->
                                <form role="form" class="text-start" method="post">
                                    <div class="input-group input-group-outline my-3">
                                        <label class="form-label">New Password</label>
                                        <input type="password" class="form-control" name="new_password" required>
                                        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>">
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Change Password</button>
                                    </div>
                                </form>
                            <?php else : ?>
                                <!-- Tampilkan formulir input email -->
                                <form role="form" class="text-start" method="post">
                                    <div class="input-group input-group-outline my-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" id="exampleInputEmail1" required>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Reset Password </button>
                                    </div>
                                </form>
                            <?php endif; ?>

                            <p class="mt-4 text-sm text-center">
                                <a href="login.php">Back to Login</a>
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
                    </p>
                </div>
                <footer class="footer position-absolute bottom-2 py-2 w-100">
                    <!-- Add your footer content here if needed -->
                </footer>
            </div>
        </div>
    </div>

    <!--   Core JS Files   -->
    <script src="../assets/js/core/popper.min.js" type="text/javascript"></script>
    <script src="../assets/js/core/bootstrap.min.js" type="text/javascript"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/material-kit.min.js?v=3.0.4" type="text/javascript"></script>
</body>

</html>
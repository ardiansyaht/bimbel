<?php
// Include the PDO connection
include "koneksi.php";
if ($_SESSION['role'] !== 'admin') {
    $_SESSION['login_message'] = 'Anda tidak memiliki izin untuk mengakses halaman ini.';
    header('Location: unauthorized.php'); // Redirect ke halaman tidak diizinkan
    exit();
}

// Inisialisasi $isUpdateForm
$isUpdateForm = isset($_GET['id']);

// Jika tidak dalam mode update, inisialisasi $dataPeserta
if (!$isUpdateForm) {
    $dataPeserta = array(); // Inisialisasi jika tidak dalam mode update
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $sekolah = $_POST['sekolah'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $no_hp = $_POST['phone']; // Perbaikan nama field
    $bidang = $_POST['subject']; // Perbaikan nama field

    // Query untuk update data
    $sql = "UPDATE tb_peserta SET nama=:nama, sekolah=:sekolah, gender=:gender, email=:email, no_hp=:no_hp, bidang=:bidang WHERE id=:id";
    $stmt = $pdo->prepare($sql);

    // Bind parameter
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nama', $nama);
    $stmt->bindParam(':sekolah', $sekolah);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':no_hp', $no_hp);
    $stmt->bindParam(':bidang', $bidang);

    // Eksekusi query
    $stmt->execute();

    header("Location: dashboard.php"); // Redirect kembali ke halaman tabel.php setelah update
    exit();
}

// Ambil data peserta berdasarkan ID jika dalam mode update
if ($isUpdateForm) {
    $id = htmlspecialchars($_GET["id"]);
    $sql = "SELECT * FROM tb_peserta WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $dataPeserta = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Colorlib Templates">
    <meta name="author" content="Colorlib">
    <meta name="keywords" content="Colorlib Templates">
    <title>Au Register Forms by Colorlib</title>
    <link href="../assets/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="../assets/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="../assets/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="../assets/vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">
    <link href="../assets/css/main.css" rel="stylesheet" media="all">
</head>

<body>
    <div class="page-wrapper bg-gra-02 p-t-130 p-b-100 font-poppins">
        <div class="wrapper wrapper--w680">
            <div class="card card-4">
                <div class="card-body">
                    <h2 class="title"><?php echo $isUpdateForm ? 'Update Form' : 'Registration Form'; ?></h2>
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateForm()">
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Nama</label>
                                    <input class="input--style-4" type="text" name="nama" value="<?php echo $isUpdateForm ? $dataPeserta['nama'] : ''; ?>">
                                    <input type="hidden" name="id" value="<?php echo $isUpdateForm ? $dataPeserta['id'] : ''; ?>">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Sekolah</label>
                                    <input class="input--style-4" type="text" name="sekolah" value="<?php echo $isUpdateForm ? $dataPeserta['sekolah'] : ''; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <!-- <label class="label">Tanggal</label> -->
                                    <div class="input-group-icon">
                                        <!-- <input class="input--style-4 js-datepicker" type="text" name="tanggal"> -->
                                        <!-- <i class="zmdi zmdi-calendar-note input-icon js-btn-calendar"></i> -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Gender</label>
                                    <div class="p-t-10">
                                        <label class="radio-container m-r-45">Male
                                            <input type="radio" value="laki-laki" <?php echo ($isUpdateForm && $dataPeserta['gender'] === 'laki-laki') ? 'checked="checked"' : ''; ?> name="gender">
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="radio-container">Female
                                            <input type="radio" value="perempuan" <?php echo ($isUpdateForm && $dataPeserta['gender'] === 'perempuan') ? 'checked="checked"' : ''; ?> name="gender">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Email</label>
                                    <input class="input--style-4" type="email" name="email" value="<?php echo $isUpdateForm ? $dataPeserta['email'] : ''; ?>">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Phone Number</label>
                                    <input class="input--style-4" type="number" name="phone" value="<?php echo $isUpdateForm ? $dataPeserta['no_hp'] : ''; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="input-group">
                            <label class="label">Subject</label>
                            <div class="rs-select2 js-select-simple select--no-search">
                                <select name="subject">
                                    <option disabled="disabled" selected="selected">Choose option</option>
                                    <option value="web-development" <?php echo ($isUpdateForm && $dataPeserta['bidang'] === 'web-development') ? 'selected="selected"' : ''; ?>>Web Development</option>
                                    <option value="data-science" <?php echo ($isUpdateForm && $dataPeserta['bidang'] === 'data-science') ? 'selected="selected"' : ''; ?>>Data Science</option>
                                    <option value="full-stack-development" <?php echo ($isUpdateForm && $dataPeserta['bidang'] === 'full-stack-development') ? 'selected="selected"' : ''; ?>>Full Stack Development</option>
                                    <option value="mobile-app-development" <?php echo ($isUpdateForm && $dataPeserta['bidang'] === 'mobile-app-development') ? 'selected="selected"' : ''; ?>>Mobile App Development</option>
                                </select>
                                <div class="select-dropdown"></div>
                            </div>
                        </div>
                        <div class="p-t-15">
                            <button class="btn btn--radius-2 btn--blue" type="submit" name="submit"><?php echo $isUpdateForm ? 'Update' : 'Submit'; ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery JS-->
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <!-- Vendor JS-->
    <script src="../assets/vendor/select2/select2.min.js"></script>
    <script src="../assets/vendor/datepicker/moment.min.js"></script>
    <script src="../assets/vendor/datepicker/daterangepicker.js"></script>
    <script src="../assets/js/global.js"></script>
    <script>
        function validateForm() {
            var nama = document.forms["registrationForm"]["nama"].value;
            var sekolah = document.forms["registrationForm"]["sekolah"].value;
            var gender = document.forms["registrationForm"]["gender"].value;
            var email = document.forms["registrationForm"]["email"].value;
            var phone = document.forms["registrationForm"]["phone"].value;
            var subject = document.forms["registrationForm"]["subject"].value;

            if (nama == "" || sekolah == "" || gender == "" || email == "" || phone == "" || subject == "") {
                // Gunakan alert untuk notifikasi sederhana
                alert("Harap isi semua field pada formulir.");
                return false;
            }

            return true;
        }
    </script>
</body>

</html>
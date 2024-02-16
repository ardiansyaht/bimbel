<?php
session_start();
header("X-Frame-Options: DENY");

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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $nama = isset($_POST['nama']) ? $_POST['nama'] : '';
    $sekolah = isset($_POST['sekolah']) ? $_POST['sekolah'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $subject = isset($_POST['subject']) ? $_POST['subject'] : '';

    if (empty($nama) || empty($sekolah) || empty($gender) || empty($email) || empty($phone) || empty($subject)) {
        $_SESSION['error_message'] = 'Harap isi semua field pada formulir.';
    } else {
        try {
            $query = "INSERT INTO tb_peserta (nama, sekolah, gender, email, no_hp, bidang) VALUES (:nama, :sekolah, :gender, :email, :no_hp, :bidang)";
            $stmt = $conn->prepare($query);

            $stmt->bindParam(':nama', $nama);
            $stmt->bindParam(':sekolah', $sekolah);
            $stmt->bindParam(':gender', $gender);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':no_hp', $phone);
            $stmt->bindParam(':bidang', $subject);

            $stmt->execute();

            $_SESSION['success_message'] = 'Data berhasil disimpan.';
        } catch (PDOException $e) {
            $_SESSION['error_message'] = 'Error: ' . $e->getMessage();
            echo 'Error: ' . $e->getMessage();
        }
    }
}

$conn = null;
?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Colorlib Templates">
    <meta name="author" content="Colorlib">
    <meta name="keywords" content="Colorlib Templates">
    <title>CodinginAJA</title>
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
                    <h2 class="title">Registration Form</h2>
                    <form method="POST" action="create.php" onsubmit="return validateForm()">
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Nama</label>
                                    <input class="input--style-4" type="text" name="nama" value="<?php echo htmlspecialchars($nama); ?>">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Sekolah</label>
                                    <input class="input--style-4" type="text" name="sekolah" value="<?php echo htmlspecialchars($nama); ?>">
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
                                            <input type="radio" value="laki-laki" checked="checked" name="gender" value="<?php echo htmlspecialchars($nama); ?>">
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="radio-container">Female
                                            <input type="radio" value="perempuan" name="gender" value="<?php echo htmlspecialchars($nama); ?>">
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
                                    <input class="input--style-4" type="email" name="email" value="<?php echo htmlspecialchars($nama); ?>">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Phone Number</label>
                                    <input class="input--style-4" type="number" name="phone" value="<?php echo htmlspecialchars($nama); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="input-group">
                            <label class="label">Subject</label>
                            <div class="rs-select2 js-select-simple select--no-search">
                                <select name="subject">
                                    <option disabled="disabled" selected="selected">Choose option</option>
                                    <option value="web-development">Web Development</option>
                                    <option value="data-science">Data Science</option>
                                    <option value="full-stack-development">Full Stack Development</option>
                                    <option value="mobile-app-development">Mobile App Development</option>
                                </select>
                                <div class="select-dropdown"></div>
                            </div>
                        </div>
                        <div class="p-t-15">
                            <button class="btn btn--radius-2 btn--blue" type="submit" name="submit">Submit</button>

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

    <!-- Main JS-->
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

                alert("Harap isi semua field pada formulir.");
                return false;
            }

            return true;
        }
    </script>

</body>

</html>
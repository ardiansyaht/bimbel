<?php
// Include the PDO connection
include "koneksi.php";
if ($_SESSION['role'] !== 'admin') {
    $_SESSION['login_message'] = 'Anda tidak memiliki izin untuk mengakses halaman ini.';
    header('Location: unauthorized.php'); // Redirect ke halaman tidak diizinkan
    exit();
}

// Check if there is a form submission via the GET method
if (isset($_GET['id'])) {
    $id = htmlspecialchars($_GET["id"]);
    $sql = "DELETE FROM tb_peserta WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

// Processing Search
if (isset($_GET['search'])) {
    $keyword = '%' . $_GET['search'] . '%';
    $sql = "SELECT * FROM tb_peserta WHERE nama LIKE :keyword";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
} else {
    $sql = "SELECT * FROM tb_peserta";
    $stmt = $pdo->query($sql);
}

$stmt->execute();
$no = 0;
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <title>Codingin Aja</title>
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <span class="navbar-brand mb-0 h1">Codingin Aja</span>
    </nav>
    <div class="container">
        <br>
        <h4>
            <center>DAFTAR PESERTA PELATIHAN</center>
            <a type="btn" class="btn btn-success" href="create.php">TambahData</a>
        </h4>

        <table class="my-3 table table-bordered">
            <thead>
                <tr class="table-primary">
                    <th>No</th>
                    <th>Nama</th>
                    <th>Sekolah</th>
                    <th>Gender</th>
                    <th>Email</th>
                    <th>No_Hp</th>
                    <th>Bidang</th>
                    <th colspan='2'>Aksi</th>
                </tr>
            </thead>
            <?php
            while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $no++;
            ?>
                <tbody>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $data["nama"]; ?></td>
                        <td><?php echo $data["sekolah"];   ?></td>
                        <td><?php echo $data["gender"];   ?></td>
                        <td><?php echo $data["email"];   ?></td>
                        <td><?php echo $data["no_hp"];   ?></td>
                        <td><?php echo $data["bidang"];   ?></td>
                        <td>
                            <a href="update.php?id=<?php echo htmlspecialchars($data['id']); ?>" class="btn btn-warning" role="button">Update</a>
                            <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?id=<?php echo $data['id']; ?>" class="btn btn-danger" role="button">Delete</a>
                        </td>
                    </tr>
                </tbody>
            <?php
            }
            ?>
        </table>
        <a href="generate_pdf.php" class="btn btn-danger" role="button">Download PDF</a>
        <a href="generate_excel.php" class="btn btn-success" role="button">Download Excel</a>
    </div>
</body>

</html>
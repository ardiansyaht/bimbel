<?php
require '../tcpdf/tcpdf.php';
include "koneksi.php"; // Pastikan file koneksi.php ada
session_start();


// Cek apakah peran pengguna adalah "admin"
if ($_SESSION['role'] !== 'admin') {
    $_SESSION['login_message'] = 'Anda tidak memiliki izin untuk mengakses halaman ini.';
    header('Location: unauthorized.php'); // Redirect ke halaman tidak diizinkan
    exit();
}


$pdf = new TCPDF();

// Set dokumen PDF
$pdf->SetAuthor('CodinginAJA');
$pdf->SetTitle('Daftar Peserta Bimbel');

// Tambahkan halaman
$pdf->AddPage();

// Konten PDF
$content = '<h1>Daftar Peserta Pelatihan</h1>';
$content .= '<table border="1">';
$content .= '<thead><tr><th>No</th><th>Nama</th><th>Sekolah</th><th>Gender</th><th>Email</th><th>No hp</th><th>Bidang</th></tr></thead>';
$content .= '<tbody>';

$sql = "SELECT * FROM tb_peserta";
$stmt = $pdo->query($sql);
$no = 0;

while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $no++;
    $content .= "<tr>";
    $content .= "<td>{$no}</td>";
    $content .= "<td>{$data['nama']}</td>";
    $content .= "<td>{$data['sekolah']}</td>";
    $content .= "<td>{$data['gender']}</td>";
    $content .= "<td>{$data['email']}</td>";
    $content .= "<td>{$data['no_hp']}</td>";
    $content .= "<td>{$data['bidang']}</td>";
    $content .= "</tr>";
}

$content .= '</tbody></table>';

// Tambahkan konten ke halaman PDF
$pdf->writeHTML($content, true, false, true, false, '');

// Simpan file PDF ke server
$pdf->Output('daftar_peserta_bimbel.pdf', 'D');

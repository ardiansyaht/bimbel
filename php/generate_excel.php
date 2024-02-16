<?php
include "koneksi.php";
require  '../vendorexcel/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

session_start();

if ($_SESSION['role'] !== 'admin') {
    $_SESSION['login_message'] = 'Anda tidak memiliki izin untuk mengakses halaman ini.';
    header('Location: unauthorized.php'); // Redirect ke halaman tidak diizinkan
    exit();
}

// Inisialisasi objek Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Judul kolom
$sheet->setCellValue('A1', 'No');
$sheet->setCellValue('B1', 'Nama');
$sheet->setCellValue('C1', 'Sekolah');
$sheet->setCellValue('D1', 'Gender');
$sheet->setCellValue('E1', 'Email');
$sheet->setCellValue('F1', 'No hp');
$sheet->setCellValue('G1', 'Bidang');


// Data peserta
$sql = "SELECT * FROM tb_peserta";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$no = 0;
$row = 2;

while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $no++;
    $sheet->setCellValue('A' . $row, $no);
    $sheet->setCellValue('B' . $row, $data['nama']);
    $sheet->setCellValue('C' . $row, $data['sekolah']);
    $sheet->setCellValue('D' . $row, $data['gender']);
    $sheet->setCellValue('E' . $row, $data['email']);
    $sheet->setCellValue('F' . $row, $data['no_hp']);
    $sheet->setCellValue('G' . $row, $data['bidang']);

    $row++;
}

// Set lebar kolom otomatis
foreach (range('A', 'H') as $column) {
    $sheet->getColumnDimension($column)->setAutoSize(true);
}

// Set nama file Excel
$excelFileName = 'daftar_peserta_bimbel.xlsx';

// Mengatur header agar browser mengenali sebagai file Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $excelFileName . '"');
header('Cache-Control: max-age=0');

// Simpan ke format Excel 2007 (xlsx)
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

// Hentikan eksekusi script
exit();

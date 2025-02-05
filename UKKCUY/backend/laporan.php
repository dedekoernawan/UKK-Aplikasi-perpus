<?php
require('fpdf/fpdf.php');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "perpusdigital";

// Buat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Buat objek PDF baru
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(190, 10, 'Laporan Perpustakaan', 0, 1, 'C');
$pdf->Ln(10);

// **Bagian 1: Data Anggota**
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(190, 10, 'Data Anggota', 0, 1, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(10, 7, 'ID', 1);
$pdf->Cell(50, 7, 'Nama', 1);
$pdf->Cell(50, 7, 'Email', 1);
$pdf->Cell(50, 7, 'Alamat', 1);
$pdf->Ln();

$query = "SELECT UserID, NamaLengkap, Email, alamat FROM user";
$result = $conn->query($query);
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(10, 7, $row['UserID'], 1);
    $pdf->Cell(50, 7, $row['NamaLengkap'], 1);
    $pdf->Cell(50, 7, $row['Email'], 1);
    $pdf->Cell(50, 7, $row['alamat'], 1);
    $pdf->Ln();
}
$pdf->Ln(10);

// **Bagian 2: Data Buku**
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(190, 10, 'Data Buku', 0, 1, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(10, 7, 'ID', 1);
$pdf->Cell(80, 7, 'Judul Buku', 1);
$pdf->Cell(50, 7, 'Penulis', 1);
$pdf->Cell(40, 7, 'Tahun', 1);
$pdf->Ln();

$query = "SELECT BukuID, Judul, Penulis, TahunTerbit FROM buku";
$result = $conn->query($query);
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(10, 7, $row['BukuID'], 1);
    $pdf->Cell(80, 7, $row['Judul'], 1);
    $pdf->Cell(50, 7, $row['Penulis'], 1);
    $pdf->Cell(40, 7, $row['TahunTerbit'], 1);
    $pdf->Ln();
}
$pdf->Ln(10);

// **Bagian 3: Data Peminjaman**
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(190, 10, 'Data Peminjaman', 0, 1, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(20, 7, 'ID', 1);
$pdf->Cell(50, 7, 'Nama Anggota', 1);
$pdf->Cell(70, 7, 'Judul Buku', 1);
$pdf->Cell(30, 7, 'Tanggal Pinjam', 1);
$pdf->Cell(30, 7, 'Tanggal Kembali', 1);
$pdf->Ln();

$query = "SELECT p.PeminjamanID, u.NamaLengkap, b.Judul, p.TanggalPinjam, p.TanggalKembali
          FROM peminjaman p
          JOIN user u ON p.UserID = u.UserID
          JOIN buku b ON p.BukuID = b.BukuID";
$result = $conn->query($query);
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(20, 7, $row['PeminjamanID'], 1);
    $pdf->Cell(50, 7, $row['NamaLengkap'], 1);
    $pdf->Cell(70, 7, $row['Judul'], 1);
    $pdf->Cell(30, 7, $row['TanggalPinjam'], 1);
    $pdf->Cell(30, 7, $row['TanggalKembali'], 1);
    $pdf->Ln();
}

// Tutup koneksi
$conn->close();

// Output PDF
$pdf->Output('D', 'Laporan_Perpus.pdf');
?>

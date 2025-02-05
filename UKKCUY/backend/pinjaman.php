<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include "../db/koneksi.php";

// Pastikan koneksi berhasil
if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
}
include 'config.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: http://localhost/UKKCUY/views/login.html");
    exit();
}

if (!isset($_GET['id'])) {
    echo "Buku tidak ditemukan!";
    exit();
}

$id_buku = $_GET['id'];

$query = "SELECT * FROM buku WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_buku);
$stmt->execute();
$result = $stmt->get_result();
$buku = $result->fetch_assoc();

if (!$buku) {
    echo "Buku tidak tersedia!";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'];
    $tanggal_peminjaman = date("Y-m-d");

    $query = "INSERT INTO peminjaman (username, id_buku, tanggal_peminjaman, status) VALUES (?, ?, ?, 'Dipinjam')";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sis", $username, $id_buku, $tanggal_peminjaman);

    if ($stmt->execute()) {
        echo "<script>alert('Buku berhasil dipinjam!'); window.location='my_loans.php';</script>";
    } else {
        echo "<script>alert('Gagal meminjam buku.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Buku</title>
</head>
<body>
    <h2>Detail Buku</h2>
    <p><strong>Judul:</strong> <?= $buku['judul']; ?></p>
    <p><strong>Penulis:</strong> <?= $buku['penulis']; ?></p>
    <p><strong>Penerbit:</strong> <?= $buku['penerbit']; ?></p>
    
    <form method="POST">
        <button type="submit">Pinjam Buku</button>
    </form>

    <br>
    <a href="browse_books.php">Kembali</a>
</body>
</html>

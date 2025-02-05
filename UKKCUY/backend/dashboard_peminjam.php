<?php
include "../db/koneksi.php";
session_start();


if (!isset($_SESSION['username']) || $_SESSION['role'] != 'peminjam') {
    header("Location: login_process.php");
    exit();
}


$koneksi = mysqli_connect("localhost", "dedekurniawan", "dedeiku07", "perpusdigital");

if (mysqli_connect_errno()) {
    echo "Gagal terhubung ke database: " . mysqli_connect_error();
    exit();
}


$username = $_SESSION['username'];
$query = "SELECT * FROM peminjam WHERE username='$username'";
$result = mysqli_query($koneksi, $query);
$data_peminjam = mysqli_fetch_assoc($result);


$id_peminjam = $data_peminjam['id_peminjam']; 
$query_buku = "SELECT * FROM pinjaman WHERE id_peminjam='$id_peminjam'";
$result_buku = mysqli_query($koneksi, $query_buku);

mysqli_close($koneksi);
?>

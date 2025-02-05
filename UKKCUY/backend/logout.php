<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include "../db/koneksi.php";

// Pastikan koneksi berhasil
if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
session_start();

session_unset();
session_destroy();

header("Location: http://localhost/UKKCUY/views/login.html");
exit();
?>

<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include "../db/koneksi.php";

// Pastikan koneksi berhasil
if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
session_start();

$users = [
    'admin' => ['password' => 'admin123', 'role' => 'admin'],
    'petugas' => ['password' => 'petugas123', 'role' => 'petugas'],
    'peminjam' => ['password' => 'peminjam123', 'role' => 'peminjam']
];

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (isset($users[$username]) && $users[$username]['password'] === $password) {
    $_SESSION['username'] = $username;
    $_SESSION['role'] = $users[$username]['role'];

    if ($_SESSION['role'] === 'admin') {
        header("Location: http://localhost/UKKCUY/views/dasboard.html");
    } elseif ($_SESSION['role'] === 'petugas') {
        header("Location: http://localhost/UKKCUY/views/dashpetugas.html");
    } elseif ($_SESSION['role'] === 'peminjam') {
        header("Location: http://localhost/UKKCUY/views/berandaperpus.html");
    }
    exit;
} else {
    echo "Login gagal! <a href=''>Coba lagi</a>";
    exit;
}l
?>

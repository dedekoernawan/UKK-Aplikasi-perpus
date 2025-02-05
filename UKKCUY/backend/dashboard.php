<?php
include "../db/koneksi.php";
include 'config.php';
session_start();
if (!is_logged_in()) {
    header("Location: index.php");
    exit();
}
$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - <?php echo ucfirst($role); ?></title>
</head>
<body>
    <h2>Selamat datang, <?php echo $_SESSION['username']; ?>!</h2>
    <nav>
        <?php if ($role === 'admin') : ?>
            <a href="#">Kelola User</a>
            <a href="#">Kelola Buku</a>
        <?php elseif ($role === 'petugas') : ?>
            <a href="#">Kelola Peminjaman</a>
        <?php elseif ($role === 'user') : ?>
            <a href="#">Lihat Buku</a>
            <a href="#">Pinjaman Saya</a>
        <?php endif; ?>
    </nav>
    <a href="logout.php">Logout</a>
</body>
</html>


<?php
include 'config.php';
session_start();
if (!is_logged_in() || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}
$query = "SELECT * FROM user";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
</head>
<body>
    <h2>Dashboard Admin</h2>
    <a href="dashboard.php">Kembali ke Dashboard</a>
    <h3>Daftar Pengguna</h3>
    <table border="1">
        <tr>
            <th>UserID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Nama Lengkap</th>
            <th>Role</th>
        </tr>
        <?php while ($user = $result->fetch_assoc()) : ?>
        <tr>
            <td><?php echo $user['UserID']; ?></td>
            <td><?php echo $user['Username']; ?></td>
            <td><?php echo $user['Email']; ?></td>
            <td><?php echo $user['NamaLengkap']; ?></td>
            <td><?php echo $user['Role']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include "../db/koneksi.php";

if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form dengan validasi
    $Username = filter_input(INPUT_POST, 'Username');
    $NamaLengkap = filter_input(INPUT_POST, 'NamaLengkap');
    $Email = filter_input(INPUT_POST, 'Email');
    $Password = filter_input(INPUT_POST, 'Password');
    $Alamat = filter_input(INPUT_POST, 'Alamat');
    $Role = filter_input(INPUT_POST, 'Role'); // Ambil role dari input

    
    $allowed_roles = ['admin', 'peminjam'];
    if (!in_array($Role, $allowed_roles)) {
        die("Error: Role tidak valid!");
    }

    if ($Username && $NamaLengkap && $Email && $Password && $Alamat && $Role) {
        $PasswordHashed = password_hash($Password, PASSWORD_DEFAULT);

        $checkTable = $conn->query("SHOW TABLES LIKE 'user'");
        if ($checkTable->num_rows == 0) {
            die("Error: Tabel 'user' tidak ditemukan!");
        }

        $stmt = $conn->prepare("INSERT INTO user (Username, NamaLengkap, Email, Password, Alamat, Role) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param("ssssss", $Username, $NamaLengkap, $Email, $PasswordHashed, $Alamat, $Role);

        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            header("Location: http://localhost/UKKCUY/views/berandaperpus.html");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: Semua field harus diisi!";
    }
} else {
    echo "Error: Metode request tidak valid!";
}

$conn->close();
?>

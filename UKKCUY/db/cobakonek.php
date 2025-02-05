<?php
include "http://localhost/UKKCUY/db/koneksi.php";

if ($conn) {
    echo "Koneksi berhasil!";
} else {
    echo "Koneksi gagal: " . mysqli_connect_error();
}
?>
<?php
// koneksi ke database db_perpustakaan
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_perpustakaan2";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi gagal: " . htmlspecialchars(mysqli_connect_error()));
}
mysqli_set_charset($koneksi, "utf8mb4");
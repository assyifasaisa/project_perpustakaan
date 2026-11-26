<?php
require_once "koneksi.php";

// hanya bisa diproses lewat tombol Update Data
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['update'])) {
    header("Location: data.php");
    exit;
}

// mengambil data dari form
$id            = (int) ($_POST['id'] ?? 0);
$no_anggota    = trim($_POST['no_anggota'] ?? '');
$nama_lengkap  = trim($_POST['nama_lengkap'] ?? '');
$email         = trim($_POST['email'] ?? '');
$no_hp         = trim($_POST['no_hp'] ?? '');
$jenis_anggota = trim($_POST['jenis_anggota'] ?? '');
$alamat        = trim($_POST['alamat'] ?? '');

// validasi data
if ($id <= 0 || $no_anggota === '' || $nama_lengkap === '' || $email === '' ||
    $no_hp === '' || $jenis_anggota === '' || $alamat === '') {
    die("Semua data wajib diisi.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Format email tidak valid.");
}

try {
    // membuat query UPDATE
    $query = "UPDATE anggota SET 
                no_anggota = ?, 
                nama_lengkap = ?, 
                email = ?, 
                no_hp = ?, 
                jenis_anggota = ?, 
                alamat = ? 
              WHERE id = ?";

    $stmt = mysqli_prepare($koneksi, $query);

    if (!$stmt) {
        die("Query gagal disiapkan: " . mysqli_error($koneksi));
    }

    // 6 string (s) dan 1 integer (i)
    mysqli_stmt_bind_param(
        $stmt,
        "ssssssi",
        $no_anggota,
        $nama_lengkap,
        $email,
        $no_hp,
        $jenis_anggota,
        $alamat,
        $id
    );

    if (!mysqli_stmt_execute($stmt)) {
        die("Gagal mengubah data: " . mysqli_stmt_error($stmt));
    }

    mysqli_stmt_close($stmt);
    header("Location: data.php");
    exit;
} catch (mysqli_sql_exception $e) {
    die("Gagal mengubah data: " . htmlspecialchars($e->getMessage()));
}
?>
<?php
// proses_anggota.php - validasi di sisi server + INSERT dengan prepared statement
session_start();
require_once "koneksi.php";

// Hanya terima request POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: form_anggota.php");
    exit;
}

// 1. Ambil input (isset + trim)
$no_anggota    = isset($_POST['no_anggota'])    ? trim($_POST['no_anggota'])    : "";
$nama_lengkap  = isset($_POST['nama_lengkap'])  ? trim($_POST['nama_lengkap'])  : "";
$email         = isset($_POST['email'])         ? trim($_POST['email'])         : "";
$no_hp         = isset($_POST['no_hp'])         ? trim($_POST['no_hp'])         : "";
$jenis_anggota = isset($_POST['jenis_anggota']) ? trim($_POST['jenis_anggota']) : "";
$alamat        = isset($_POST['alamat'])        ? trim($_POST['alamat'])        : "";

$errors = [];

// 2. Validasi Nomor Anggota
if (empty($no_anggota)) {
    $errors[] = "Nomor anggota wajib diisi.";
} elseif (!ctype_digit($no_anggota)) {
    $errors[] = "Nomor anggota hanya boleh berisi angka.";
} elseif (strlen($no_anggota) > 15) {
    $errors[] = "Nomor anggota maksimal 15 digit.";
}

// 3. Validasi Nama Lengkap
if (empty($nama_lengkap)) {
    $errors[] = "Nama lengkap wajib diisi.";
} elseif (mb_strlen($nama_lengkap) > 100) {
    $errors[] = "Nama lengkap maksimal 100 karakter.";
}

// 4. Validasi Email
if (empty($email)) {
    $errors[] = "Email wajib diisi.";
} elseif (mb_strlen($email) > 100) {
    $errors[] = "Email maksimal 100 karakter.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Format email tidak valid.";
}

// 5. Validasi Nomor HP
if (empty($no_hp)) {
    $errors[] = "Nomor HP wajib diisi.";
} elseif (!ctype_digit($no_hp)) {
    $errors[] = "Nomor HP hanya boleh berisi angka.";
} elseif (strlen($no_hp) < 10 || strlen($no_hp) > 13) {
    $errors[] = "Nomor HP harus 10 sampai 13 digit.";
}

// 6. Validasi Jenis Anggota
$jenis_valid = ["Mahasiswa", "Dosen", "Tenaga Kependidikan"];
if (empty($jenis_anggota)) {
    $errors[] = "Jenis anggota wajib dipilih.";
} elseif (!in_array($jenis_anggota, $jenis_valid, true)) {
    $errors[] = "Jenis anggota tidak valid. Pilih Mahasiswa, Dosen, atau Tenaga Kependidikan.";
}

// 7. Validasi Alamat
if (empty($alamat)) {
    $errors[] = "Alamat wajib diisi.";
}

// 8. Jika ada error: kembali ke form beserta pesan dan data lama
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = [
        'no_anggota'    => $no_anggota,
        'nama_lengkap'  => $nama_lengkap,
        'email'         => $email,
        'no_hp'         => $no_hp,
        'jenis_anggota' => $jenis_anggota,
        'alamat'        => $alamat,
    ];
    header("Location: form_anggota.php");
    exit;
}

// 9. Simpan dengan prepared statement
$sql  = "INSERT INTO anggota (no_anggota, nama_lengkap, email, no_hp, jenis_anggota, alamat)
         VALUES (?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($koneksi, $sql);

if (!$stmt) {
    $_SESSION['errors'] = ["Gagal menyiapkan query: " . mysqli_error($koneksi)];
    header("Location: form_anggota.php");
    exit;
}

mysqli_stmt_bind_param($stmt, "ssssss", $no_anggota, $nama_lengkap, $email, $no_hp, $jenis_anggota, $alamat);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION['sukses'] = "Pendaftaran berhasil! Anggota " . $nama_lengkap . " telah tersimpan.";
} else {
    $_SESSION['errors'] = ["Data gagal disimpan: " . mysqli_stmt_error($stmt)];
    $_SESSION['old'] = [
        'no_anggota'    => $no_anggota,
        'nama_lengkap'  => $nama_lengkap,
        'email'         => $email,
        'no_hp'         => $no_hp,
        'jenis_anggota' => $jenis_anggota,
        'alamat'        => $alamat,
    ];
}

mysqli_stmt_close($stmt);
mysqli_close($koneksi);

header("Location: form_anggota.php");
exit;

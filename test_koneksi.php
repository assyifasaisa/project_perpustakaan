<?php
// test_koneksi.php - menguji koneksi ke database
require_once "koneksi.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Test Koneksi</title>
</head>
<body>
    <div>
        <h3>Koneksi berhasil!</h3>
        <p>PHP berhasil terhubung ke database <strong>
            <?= htmlspecialchars($db) ?></strong>.</p>
    </div>
</body>
</html>
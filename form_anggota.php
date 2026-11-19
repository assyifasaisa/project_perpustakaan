<?php
// form pendaftaran anggota perpustakaan
session_start();

// Ambil notifikasi dari proses_anggota.php (flash message), lalu hapus
$sukses = $_SESSION['sukses'] ?? "";
$errors = $_SESSION['errors'] ?? [];
$old    = $_SESSION['old'] ?? [];
unset($_SESSION['sukses'], $_SESSION['errors'], $_SESSION['old']);

function old($key, $old) {
    return htmlspecialchars($old[$key] ?? "", ENT_QUOTES, 'UTF-8');
}

$jenis_list = ["Mahasiswa", "Dosen", "Tenaga Kependidikan"];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendaftaran Anggota Perpustakaan Kampus</title>
</head>
<body>
<div>
    <h2>Pendaftaran Anggota Perpustakaan</h2>

    <?php if ($sukses !== ""): ?>
        <div><?= htmlspecialchars($sukses) ?></div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div>
            <strong>Pendaftaran gagal:</strong>
            <ul>
                <?php foreach ($errors as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="proses_anggota.php" method="post" novalidate>
        <label for="no_anggota">Nomor Anggota</label><br>
        <input type="text" id="no_anggota" name="no_anggota" maxlength="15" value="<?= old('no_anggota', $old) ?>"><br><br>

        <label for="nama_lengkap">Nama Lengkap</label><br>
        <input type="text" id="nama_lengkap" name="nama_lengkap" maxlength="100" value="<?= old('nama_lengkap', $old) ?>"><br><br>

        <label for="email">Email</label><br>
        <input type="text" id="email" name="email" maxlength="100" value="<?= old('email', $old) ?>"><br><br>

        <label for="no_hp">Nomor HP</label><br>
        <input type="text" id="no_hp" name="no_hp" maxlength="13" value="<?= old('no_hp', $old) ?>"><br><br>

        <label for="jenis_anggota">Jenis Anggota</label><br>
        <select id="jenis_anggota" name="jenis_anggota">
            <option value="">-- Pilih jenis anggota --</option>
            <?php foreach ($jenis_list as $j): ?>
                <option value="<?= htmlspecialchars($j) ?>" <?= (($old['jenis_anggota'] ?? "") === $j) ? "selected" : "" ?>>
                    <?= htmlspecialchars($j) ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="alamat">Alamat</label><br>
        <textarea id="alamat" name="alamat"><?= old('alamat', $old) ?></textarea><br><br>

        <button type="submit">Daftar</button>
    </form>
</div>
</body>
</html>

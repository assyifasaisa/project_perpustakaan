<?php
require_once 'koneksi.php';

$sql = "select * from anggota";
$hasil = mysqli_query ($koneksi, $sql);
$jumlah = mysqli_num_rows ($hasil);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #e5e5e5;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        button {
            padding: 5px 10px;
            cursor: pointer;
        }

        a {
            text-decoration: none;
            color: blue;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <th>No</th>
            <th>No Anggota</th>
            <th>Nama Lengkap</th>
            <th>Email</th>
            <th>No HP</th>
            <th>Jenis Anggota</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>
        <?php $no = 1; while ($baris = mysqli_fetch_assoc($hasil)) { ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo htmlspecialchars($baris["no_anggota"]); ?></td>
            <td><?php echo htmlspecialchars($baris["nama_lengkap"]); ?></td>
            <td><?php echo htmlspecialchars($baris["email"]); ?></td>
            <td><?php echo htmlspecialchars($baris["no_hp"]); ?></td>
            <td><?php echo htmlspecialchars($baris["jenis_anggota"]); ?></td>
            <td><?php echo htmlspecialchars($baris["alamat"]); ?></td>

            <td>
            <form action="hapus_anggota.php" method ="POST" style="display_inline;"
                onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                <input type="hidden" name="id" value="<?php echo (int) $baris["id"]; ?>">
                <button type="submit">Hapus</button>
            </form>
            </td>
        </tr>
    <?php } ?>
    </table>
    <br>
    <button>
        <a href="form_anggota.php">Kembali ke form</a>
    </button>
</body>
</html>
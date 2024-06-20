<?php
session_start();

require_once '../inc/dbconn.php';
require_once 'process_cabang.php';

$database = new Database();
$cabangManager = new Cabang($database->koneksi);
$cabangList = $cabangManager->getAllCabang();


include '../inc/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Cabang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Data Cabang</h2>
    <a href="add_cabang.php" class="btn btn-primary mb-3">Tambah Data Cabang</a>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID Cabang</th>
            <th>Nama Cabang</th>
            <th>Alamat</th>
            <th>No HP</th>
            <th>Kacab</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($cabangList as $cabang) {
            echo "<tr>
                    <td>".$cabang['idcabang']."</td>
                    <td>".$cabang['nama_cabang']."</td>
                    <td>".$cabang['alamat']."</td>
                    <td>".$cabang['no_telp']."</td>
                    <td>".$cabang['kacab']."</td>
                    <td>
                        <a href='edit_cabang.php?id=".$cabang['idcabang']."' class='btn btn-warning btn-sm'>Edit</a>
                        <button class='btn btn-danger btn-sm' onclick='konfirmasiDelete(".$cabang['idcabang'].")'>Delete</button>
                    </td>
                  </tr>";
        }
        ?>
        </tbody>
    </table>
</div>
<script>
    function konfirmasiDelete(id) {
        var konfirmasi = confirm("Apakah Anda yakin ingin menghapus data ini?");
        if (konfirmasi) {
            window.location.href = 'delete_cabang.php?id=' + id;
        }
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

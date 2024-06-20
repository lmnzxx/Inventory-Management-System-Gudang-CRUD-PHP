<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../inc/dbconn.php';
    require_once 'process_cabang.php';

    $database = new Database();
    $cabangManager = new Cabang($database->koneksi);

    $nama_cabang = $_POST['nama_cabang'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];
    $kacab = $_POST['kacab'];

    // Lakukan validasi data jika diperlukan

    // Proses tambah data
    $result = $cabangManager->tambahCabang($nama_cabang, $alamat, $no_hp, $kacab);

    if ($result) {
        header("Location: cabang.php");
        exit();
    } else {
        echo "Gagal menambahkan data cabang. Error: " . $database->koneksi->error;
    }
}
?>

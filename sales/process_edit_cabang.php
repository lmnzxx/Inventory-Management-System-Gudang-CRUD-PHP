<?php
session_start();

require_once '../inc/dbconn.php';
require_once 'process_cabang.php';

$database = new Database();
$cabangManager = new Cabang($database->koneksi);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nama_cabang = $_POST['nama_cabang'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];
    $kacab = $_POST['kacab'];

    // Lakukan validasi data jika diperlukan

    // Proses update data
    $result = $cabangManager->updateCabang($id, $nama_cabang, $alamat, $no_hp, $kacab);

    if ($result) {
        // Jika berhasil, arahkan kembali ke halaman cabang.php
        header("Location: cabang.php");
        exit();
    } else {
        echo "Gagal mengupdate data cabang. Error: " . $database->koneksi->error;
    }
}
?>

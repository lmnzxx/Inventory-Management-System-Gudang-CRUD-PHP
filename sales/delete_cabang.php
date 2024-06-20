<?php
session_start();

require_once '../inc/dbconn.php';
require_once 'process_cabang.php';

$database = new Database();
$cabangManager = new Cabang($database->koneksi);

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Proses delete data
    $result = $cabangManager->deleteCabang($id);

    if ($result) {
        // Jika berhasil, arahkan kembali ke halaman cabang.php
        header("Location: cabang.php");
        exit();
    } else {
        echo "Gagal menghapus data cabang. Error: " . $database->koneksi->error;
    }
} else {
    // Jika tidak ada parameter id, kembali ke halaman cabang.php
    header("Location: cabang.php");
    exit();
}
?>

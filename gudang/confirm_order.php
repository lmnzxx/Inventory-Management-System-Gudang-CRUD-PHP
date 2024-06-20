<?php
session_start();

require_once '../inc/dbconn.php';

if (isset($_GET['orderid'])) {
    $order_id = $_GET['orderid'];

    // Melakukan konfirmasi order (misalnya, mengubah status_order menjadi "Dikonfirmasi")
    $database = new Database();
    $confirmationResult = $database->confirmOrder($order_id);

    if ($confirmationResult) {
        header("Location: index.php");
    } else {
        echo "Gagal melakukan konfirmasi order.";
    }
} else {
    echo "Order ID tidak valid.";
}
?>

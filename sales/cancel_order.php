<?php
session_start();

// Pastikan user telah login
if (!isset($_SESSION['userid'])) {
    header('Location: login.php'); // Ganti login.php dengan halaman login Anda
    exit();
}

require_once '../inc/dbconn.php';
require_once 'ShoppingCart.php';

$database = new database();
$cart = new ShoppingCart($database);

// Ambil orderid dari parameter URL
$orderid = $_GET['orderid'];

// Batalkan pesanan
$cart->cancelOrder($orderid);

// Redirect kembali ke halaman order history
header('Location: order.php');
exit();
?>

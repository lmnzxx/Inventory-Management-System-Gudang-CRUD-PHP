<?php
session_start();

require_once '../inc/dbconn.php';
require_once 'ShoppingCart.php';

$database = new database();
$cart = new ShoppingCart($database);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = $_POST['productId'];
    $qty = $_POST['qty'];

    // Mendapatkan informasi produk dari database (gantilah dengan logika sesuai kebutuhan)
    $productInfo = $database->getProductById($productId);

    // Menambahkan produk ke dalam keranjang belanja
    $cart->addItem($productId, $qty, $productInfo['harga']);

    // Redirect kembali ke halaman daftar produk atau halaman keranjang belanja
    header('Location: index.php');
    exit();
}
?>

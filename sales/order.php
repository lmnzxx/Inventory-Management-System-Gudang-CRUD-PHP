<?php
session_start();

require_once '../inc/dbconn.php';
require_once 'ShoppingCart.php';

$database = new database();
$cart = new ShoppingCart($database);

$orderHistory = $cart->getOrderHistory($_SESSION['userid']);

include '../inc/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h1>Order History</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Nama Admin</th>
                            <th>Nama Cabang</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orderHistory as $order): ?>
                            <tr>
                                <td><?php echo $order['orderid']; ?></td>
                                <td><?php echo $order['nama_admin']; ?></td>
                                <td><?php echo $order['nama_cabang']; ?></td>
                                <td><?php echo $order['total']; ?></td>
                                <td><?php echo $order['status_order']; ?></td>
                                <td>
                                    <?php if ($order['status_order'] == 'Menunggu Konfirmasi'): ?>
                                        <!-- Tampilkan tombol batalkan hanya jika dapat dibatalkan -->
                                        <a href="cancel_order.php?orderid=<?php echo $order['orderid']; ?>" class="btn btn-danger">Batalkan Pesanan</a>
                                    <?php else: ?>
                                        <!-- Tampilkan teks "No action available" jika status bukan Menunggu Konfirmasi -->
                                        No action available
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

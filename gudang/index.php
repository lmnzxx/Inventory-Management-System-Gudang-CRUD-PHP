<?php
session_start();

require_once '../inc/dbconn.php';

$database = new database();
$orders = $database->getAllOrders();
include '../inc/header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Order List</title>
</head>

<body>
    <div class="container mt-5">
        <h2>Order List</h2>
        <?php
        if (!empty($orders)) {
            ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nama Admin</th>
                        <th>Cabang</th>
                        <th>Status Order</th>
                        <th>Total Harga</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order) : ?>
                        <tr>
                            <td><?= $order['nama']; ?></td>
                            <td><?= $order['nama_cabang']; ?></td>
                            <td><?= $order['status_order']; ?></td>
                            <td><?= $order['total']; ?></td>
                            <td>
                            <td>
                                <a href="order_details.php?order_id=<?= htmlspecialchars($order['orderid']); ?>" class="btn btn-primary">
                                    Details
                                </a>
                                <?php if ($order['status_order'] == 'Menunggu Konfirmasi'): ?>
                                    <!-- Tampilkan tombol batalkan hanya jika dapat dibatalkan -->
                                    <a href="confirm_order.php?orderid=<?php echo $order['orderid']; ?>" class="btn btn-primary">Konfirmasi Order</a>
                                <?php else: ?>
                                    <!-- Tampilkan teks "No action available" jika status bukan Menunggu Konfirmasi -->
                                     
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php
    } else {
        echo "<p>No orders found.</p>";
    }
    ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>

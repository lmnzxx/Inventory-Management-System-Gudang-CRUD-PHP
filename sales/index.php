<?php
session_start();

require_once '../inc/dbconn.php';

$database = new database();
$products = $database->getAllProducts();
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
            <h1>Product List</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Stok</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Foto</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo $product['nama']; ?></td>
                            <td><?php echo $product['stok']; ?></td>
                            <td><?php echo $product['kategori']; ?></td>
                            <td><?php echo $product['harga']; ?></td>
                            <td>
                                <img src="<?php echo $product['foto']; ?>" alt="<?php echo $product['nama']; ?>" width="50">
                            </td>
                            <td>
                                <form action="process_cart.php" method="post">
                                    <input type="hidden" name="productId" value="<?php echo $product['idproduk']; ?>">
                                    <input type="number" name="qty" value="1" min="1" required>
                                    <button type="submit" class="btn btn-primary">Add to Cart</button>
                                </form>
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

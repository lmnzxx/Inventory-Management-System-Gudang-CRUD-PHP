<?php
session_start();

require_once '../inc/dbconn.php';

$database = new Database();
$products = $database->getAllProducts();
include '../inc/header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Produk List</title>
</head>

<body>
    <div class="container mt-5">
        <h2>Product List</h2>
        <a href="add_product.php" class="btn btn-primary mb-3">Tambah Produk</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Stok</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Foto</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product) : ?>
                    <tr>
                        <td><?= $product['idproduk']; ?></td>
                        <td><?= $product['nama']; ?></td>
                        <td><?= $product['stok']; ?></td>
                        <td><?= $product['kategori']; ?></td>
                        <td><?= $product['harga']; ?></td>
                        <td>
                            <?php if (!empty($product['foto'])) : ?>
                                <img src="<?= $product['foto']; ?>" alt="<?= $product['nama']; ?>" class="img-thumbnail" style="width: 120px;">
                            <?php else : ?>
                                No Image
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="edit_product.php?idproduk=<?= $product['idproduk']; ?>" class="btn btn-warning">Edit</a>
                            <a href="delete_product.php?idproduk=<?= $product['idproduk']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>

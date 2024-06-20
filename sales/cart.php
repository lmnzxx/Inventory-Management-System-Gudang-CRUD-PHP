<?php
session_start();

require_once '../inc/dbconn.php';
require_once 'ShoppingCart.php';

$database = new database();
$cart = new ShoppingCart($database);

// Proses order jika tombol "Order Now" diklik
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['orderNow'])) {
    $idCabang = $_POST['idCabang'];

    // Lakukan proses order
    $orderSuccess = $cart->processOrder($idCabang);

    if ($orderSuccess) {
        // Pesan berhasil diorder
        $orderMessage = "Order berhasil. Terima kasih!";
    } else {
        // Pesan gagal diorder
        $orderMessage = "Gagal melakukan order. Silakan coba lagi.";
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['product_id'])) {
    $productIdToRemove = $_GET['product_id'];
    $cart->removeItem($productIdToRemove);
}

$cartItems = $cart->getItems();
$cabangList = $database->getAllCabang(); 
include '../inc/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h1>Shopping Cart</h1>
            
            <!-- Tampilkan pesan setelah order -->
            <?php if (isset($orderMessage)) : ?>
                <div class="alert alert-<?php echo ($orderSuccess ? 'success' : 'danger'); ?>" role="alert">
                    <?php echo $orderMessage; ?>
                </div>
            <?php endif; ?>

            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                        <tr>
                            <td><?php echo $item['product_id']; ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td><?php echo $item['harga']; ?></td>
                            <td><?php echo $item['quantity'] * $item['harga']; ?></td>
                            <td>
                                <a class="btn btn-warning" href="cart.php?action=remove&product_id=<?php echo $item['product_id']; ?>">Remove</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Form Order Now -->
            <form action="cart.php" method="post">
                <div class="mb-3">
                    <label for="idCabang" class="form-label">Pilih Cabang:</label>
                    <select name="idCabang" class="form-select" required>
                        <?php foreach ($cabangList as $cabang): ?>
                            <option value="<?php echo $cabang['idcabang']; ?>"><?php echo $cabang['nama_cabang']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" name="orderNow" class="btn btn-primary">Order Now</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

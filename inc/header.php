
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="">Inventory Management WRPY</a>
        
        <?php if ($_SESSION['role'] == 'Sales') : ?>
            <!-- Navbar for Sales -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Product</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cart.php">Cart</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="order.php">Order</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cabang.php">Cabang</a>
                </li>
            </ul>
        <?php elseif ($_SESSION['role'] == 'Gudang') : ?>
            <!-- Navbar for Gudang -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="product.php">Product</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Order</a>
                </li>
            </ul>
        <?php endif; ?>

        <div class="navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="">Welcome, <?php echo $_SESSION['nama']; ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../index.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<?php
session_start();

require_once '../inc/dbconn.php';

if (isset($_GET['idproduk'])) {
    $idproduk = $_GET['idproduk'];

    $database = new Database();
    $product = $database->getProductById($idproduk);

    if ($product) {
            $deleteResult = $database->deleteProduct($idproduk);

            if ($deleteResult) {
                // Redirect to product.php with an alert
                echo '<script>alert("Product deleted successfully!");</script>';
                echo '<script>window.location.href = "product.php";</script>';
                exit();
            } else {
                echo '<script>alert("Product not deleted! Something is wrong");</script>';
                echo '<script>window.location.href = "product.php";</script>';            
            }
    } else {
        echo "Product not found.";
    }
} else {
    echo "Product ID is not provided.";
}
?>

<?php
session_start();

require_once '../inc/dbconn.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();

    // Get form data
    $nama = $_POST['nama'];
    $stok = $_POST['stok'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];

    // Check if a file is uploaded
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        // Set the upload directory
        $uploadDir = '../img/';
        
        // Generate a unique filename
        $fileName = $_FILES['foto']['name'];
        
        // Set the complete path for the uploaded file
        $filePath = $uploadDir . $fileName;
        
        // Move the uploaded file to the destination directory
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $filePath)) {
            // Insert the product data into the database
            $insertResult = $database->insertProduct($nama, $stok, $kategori, $harga, $filePath);

            if ($insertResult) {
                $_SESSION['success_message'] = 'Product added successfully!';
            } else {
                $_SESSION['error_message'] = 'Error adding product.';
            }
        } else {
            $_SESSION['error_message'] = 'Error uploading file.';
        }
    } else {
        $_SESSION['error_message'] = 'Please upload a file.';
    }
}

// Redirect back to the form page
header('Location: product.php');
exit();

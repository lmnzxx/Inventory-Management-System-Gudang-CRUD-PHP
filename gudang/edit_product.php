<?php
session_start();

require_once '../inc/dbconn.php';

if (isset($_GET['idproduk'])) {
    $idproduk = $_GET['idproduk'];

    $database = new Database();
    $product = $database->getProductById($idproduk);

    if ($product) {
        include '../inc/header.php';

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Perform the update logic here
            $newNama = $_POST['newNama'];
            $newStok = $_POST['newStok'];
            $newKategori = $_POST['newKategori'];
            $newHarga = $_POST['newHarga'];

            $updateResult = $database->updateProduct($idproduk, $newNama, $newStok, $newKategori, $newHarga);

            if ($updateResult) {
                echo '<div class="container mt-5"><div class="alert alert-success" role="alert">Product updated successfully!</div></div>';
            } else {
                echo '<div class="container mt-5"><div class="alert alert-danger" role="alert">Error updating product.</div></div>';
            }
        }
?>
        <div class="container mt-5">
            <h2>Edit Product</h2>
            <form method="POST">
                <div class="mb-3">
                    <label for="newNama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="newNama" name="newNama" value="<?= $product['nama']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="newStok" class="form-label">Stok</label>
                    <input type="number" class="form-control" id="newStok" name="newStok" value="<?= $product['stok']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="newKategori" class="form-label">Kategori</label>
                    <select class="form-select" id="newKategori" name="newKategori" required>
                        <option value="Susu" <?php echo ($product['kategori'] == 'Susu') ? 'selected' : ''; ?>>Susu</option>
                        <option value="Biji Kopi" <?php echo ($product['kategori'] == 'Biji Kopi') ? 'selected' : ''; ?>>Biji Kopi</option>
                        <option value="Syrup" <?php echo ($product['kategori'] == 'Syrup') ? 'selected' : ''; ?>>Syrup</option>
                        <option value="Cup" <?php echo ($product['kategori'] == 'Cup') ? 'selected' : ''; ?>>Cup</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="newHarga" class="form-label">Harga</label>
                    <input type="number" class="form-control" id="newHarga" name="newHarga" value="<?= $product['harga']; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Product</button>
            </form>
        </div>
<?php
    } else {
        echo "Product not found.";
    }
} else {
    echo "Product ID is not provided.";
}
?>

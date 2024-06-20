<?php
session_start();

require_once '../inc/dbconn.php';
require_once 'process_cabang.php';

$database = new Database();
$cabangManager = new Cabang($database->koneksi);

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $cabang = $cabangManager->getCabangById($id);

    // Tampilkan formulir edit
    include '../inc/header.php';
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edit Data Cabang</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    </head>
    <body>

    <div class="container mt-5">
        <h2 class="mb-4">Edit Data Cabang</h2>
        <form action="process_edit_cabang.php" method="post">
            <input type="hidden" name="id" value="<?php echo $cabang['idcabang']; ?>">
            <div class="mb-3">
                <label for="nama_cabang" class="form-label">Nama Cabang</label>
                <input type="text" class="form-control" id="nama_cabang" name="nama_cabang" value="<?php echo $cabang['nama_cabang']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $cabang['alamat']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="no_hp" class="form-label">No HP</label>
                <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?php echo $cabang['no_telp']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="kacab" class="form-label">Kacab</label>
                <input type="text" class="form-control" id="kacab" name="kacab" value="<?php echo $cabang['kacab']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>

<?php
} else {
    // Jika tidak ada parameter id, kembali ke halaman cabang.php
    header("Location: cabang.php");
    exit();
}
?>

<?php
class ShoppingCart {
    private $database;
    private $items = array();

    public function __construct(database $database){
        $this->database = $database;
        
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        $this->items = &$_SESSION['cart'];
    }

    public function addItem($productId, $quantity, $harga) {
        // Menambahkan produk ke dalam keranjang belanja
        $this->items[] = array(
            'product_id' => $productId,
            'quantity' => $quantity,
            'harga' => $harga
        );
    }

    public function removeItem($productId) {
        // Menghapus item berdasarkan product_id
        foreach ($this->items as $key => $item) {
            if ($item['product_id'] == $productId) {
                unset($this->items[$key]);
                return true; // Item ditemukan dan dihapus
            }
        }
        return false; // Item tidak ditemukan
    }

    public function processOrder($idCabang) {
        // Hitung total harga dari keranjang
        $total = $this->calculateTotal();

        // Input ke tabel order untuk mendapatkan orderid
        $userId = isset($_SESSION['userid']) ? $_SESSION['userid'] : null; // Perbaikan di sini
        $orderId = $this->inputOrder($idCabang, $userId, $total);
        
        // Input ke tabel order_details
        $this->inputOrderDetails($orderId);

        // Kosongkan keranjang setelah order berhasil
        $this->clearCart();

        return true; // Atau return false jika terjadi kegagalan
    }

    private function calculateTotal() {
        $total = 0;

        foreach ($this->items as $item) {
            $total += $item['quantity'] * $item['harga'];
        }

        return $total;
    }

    private function inputOrder($idCabang, $userId, $total) {
        $statusOrder = "Menunggu Konfirmasi";

        $query = "INSERT INTO `order` (idcabang, userid, status_order, total) VALUES (?, ?, ?, ?)";
        $statement = $this->database->koneksi->prepare($query);
        $statement->bind_param("iisd", $idCabang, $userId, $statusOrder, $total);
        $statement->execute();

        return $this->database->koneksi->insert_id; // Mendapatkan orderid yang baru saja dibuat
    }

    private function inputOrderDetails($orderId) {
        foreach ($this->items as $item) {
            $productId = $item['product_id'];
            $quantity = $item['quantity'];
            $hargaSatuan = $item['harga'];
            $totalHarga = $quantity * $hargaSatuan;

            $this->updateProductStock($productId, $quantity);

            $query = "INSERT INTO order_details (orderid, idproduk, qty, harga) VALUES (?, ?, ?, ?)";
            $statement = $this->database->koneksi->prepare($query);
            $statement->bind_param("iiid", $orderId, $productId, $quantity, $totalHarga);
            $statement->execute();
        }
    }

    private function updateProductStock($productId, $quantity) {
        // Ambil stok produk saat ini
        $currentStock = $this->getCurrentProductStock($productId);
    
        // Kurangkan stok berdasarkan quantity
        $newStock = $currentStock - $quantity;
    
        // Update stok produk
        $query = "UPDATE produk SET stok = ? WHERE idproduk = ?";
        $statement = $this->database->koneksi->prepare($query);
        $statement->bind_param("ii", $newStock, $productId);
        $statement->execute();
    }
    
    private function getCurrentProductStock($productId) {
        // Ambil stok produk saat ini dari database
        $query = "SELECT stok FROM produk WHERE idproduk = ?";
        $statement = $this->database->koneksi->prepare($query);
        $statement->bind_param("i", $productId);
        $statement->execute();
        $result = $statement->get_result();
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['stok'];
        } else {
            return 0; // Atur nilai default jika tidak ada hasil
        }
    }

    public function clearCart() {
        $_SESSION['cart'] = array();
    }

    public function getItems() {
        return $this->items;
    }

    public function getOrderHistory($userid) {
        $query = "
            SELECT
                user.nama AS nama_admin,
                cabang.nama_cabang,
                `order`.orderid,
                `order`.total,
                `order`.status_order
            FROM
                `order`
            INNER JOIN
                user ON `order`.userid = user.userid
            INNER JOIN
                cabang ON `order`.idcabang = cabang.idcabang
            WHERE
                `order`.userid = ?
        ";
    
        $statement = $this->database->koneksi->prepare($query);
        $statement->bind_param("i", $userid);
        $statement->execute();
        $result = $statement->get_result();
    
        $orderHistory = array();
        while ($row = $result->fetch_assoc()) {
            $row['can_cancel'] = ($row['status_order'] == 'Menunggu Konfirmasi');
            $orderHistory[] = $row;
        }
    
        return $orderHistory;
    }

    public function cancelOrder($orderid) {
        $query = "UPDATE `order` SET status_order = 'Dibatalkan' WHERE orderid = ?";
        $statement = $this->database->koneksi->prepare($query);
        $statement->bind_param("i", $orderid);
        $statement->execute();
    }

    
}
?>

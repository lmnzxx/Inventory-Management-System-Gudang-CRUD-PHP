<?php
    class database {
        private $host = "localhost";
        private $username = "root";
        private $password = "";
        private $database = "eskrim_bakar";
        public $koneksi;

        public function __construct(){
            $this->koneksi = new mysqli($this->host, $this->username, $this->password, $this->database);

            if($this->koneksi->connect_error){
                die("Koneksi gagal: " . $this->koneksi->connect_error);
            }
        }
        public function getAllProducts() {
            $query = "SELECT * FROM produk";
            $result = $this->koneksi->query($query);
    
            if ($result) {
                $products = array();
    
                while ($row = $result->fetch_assoc()) {
                    $products[] = $row;
                }
    
                $result->free(); // Bebaskan hasil setelah selesai
    
                return $products;
            } else {
                die("Error: " . $this->koneksi->error);
            }
        }
        public function getProductById($productId) {
            $query = "SELECT idproduk, nama, stok, kategori, harga, foto FROM produk WHERE idproduk = ?";
            $statement = $this->koneksi->prepare($query);
            $statement->bind_param("i", $productId);
            $statement->execute();
            $result = $statement->get_result();
    
            if ($result->num_rows > 0) {
                return $result->fetch_assoc();
            } else {
                return null;
            }
        }

        public function getAllCabang() {
            $query = "SELECT idcabang, nama_cabang FROM cabang";
            $result = $this->koneksi->query($query);
    
            $cabangList = array();
    
            while ($row = $result->fetch_assoc()) {
                $cabangList[] = $row;
            }
    
            return $cabangList;
        }

        public function getAllOrders()
        {
            $query = "SELECT user.nama, cabang.nama_cabang, `order`.status_order, `order`.total, `order`.orderid
                      FROM `order`
                      JOIN user ON `order`.userid = user.userid
                      JOIN cabang ON `order`.idcabang = cabang.idcabang";
    
            $result = $this->koneksi->query($query);
    
            if ($result) {
                $orders = array();
    
                while ($row = $result->fetch_assoc()) {
                    $orders[] = $row;
                }
    
                $result->free(); // Bebaskan hasil setelah selesai
    
                return $orders;
            } else {
                die("Error: " . $this->koneksi->error);
            }
        }

        public function confirmOrder($order_id) {
            $query = "UPDATE `order` SET status_order = 'Dikonfirmasi' WHERE orderid = $order_id";
            $result = $this->koneksi->query($query);

            if ($result) {
                return true;
            } else {
                die("Error: " . $this->koneksi->error);
            }
        }

        public function getOrderDetails($orderId) {
            $query = "SELECT produk.nama AS product_name, order_details.qty, produk.harga AS unit_price, order_details.qty * produk.harga AS total_price
                        FROM order_details
                        JOIN produk ON order_details.idproduk = produk.idproduk
                        WHERE order_details.orderid = $orderId";

            $result = $this->koneksi->query($query);

            if ($result) {
                $orderDetails = array();

                while ($row = $result->fetch_assoc()) {
                    $orderDetails[] = $row;
                }

                $result->free();

                return $orderDetails;
            } else {
                die("Error: " . $this->koneksi->error);
            }
        }

        public function getOrderById($orderId)
        {
            $query = "SELECT * FROM `order` WHERE orderid = $orderId";
            $result = $this->koneksi->query($query);
    
            if ($result) {
                return $result->fetch_assoc();
            } else {
                die("Error: " . $this->koneksi->error);
            }
        }
    
        public function updateProduct($idproduk, $newNama, $newStok, $newKategori, $newHarga)
        {
            $query = "UPDATE produk SET nama = '$newNama', stok = '$newStok', kategori = '$newKategori', harga = '$newHarga' WHERE idproduk = $idproduk";
            $result = $this->koneksi->query($query);
    
            if ($result) {
                return true;
            } else {
                die("Error: " . $this->koneksi->error);
            }
        }
    
        public function deleteProduct($idproduk)
        {
            $query = "DELETE FROM produk WHERE idproduk = $idproduk";
            $result = $this->koneksi->query($query);
    
            if ($result) {
                return true;
            } else {
                die("Error: " . $this->koneksi->error);
            }
        }

        public function insertProduct($nama, $stok, $kategori, $harga, $fotoPath) {
            $query = "INSERT INTO produk (nama, stok, kategori, harga, foto) VALUES (?, ?, ?, ?, ?)";
            
            $stmt = $this->koneksi->prepare($query);
            $stmt->bind_param("sisis", $nama, $stok, $kategori, $harga, $fotoPath);
            
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }
    
?>

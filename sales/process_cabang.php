<?php
class Cabang {
    private $koneksi;

    public function __construct($koneksi) {
        $this->koneksi = $koneksi;
    }

    public function getAllCabang() {
        $query = "SELECT idcabang, nama_cabang, alamat, no_telp, kacab FROM cabang";
        $result = $this->koneksi->query($query);

        if ($result) {
            $cabangList = array();

            while ($row = $result->fetch_assoc()) {
                $cabangList[] = $row;
            }

            $result->free(); // Bebaskan hasil setelah selesai

            return $cabangList;
        } else {
            die("Error: " . $this->koneksi->error);
        }
    }
    public function tambahCabang($nama_cabang, $alamat, $no_hp, $kacab) {
        $query = "INSERT INTO cabang (nama_cabang, alamat, no_telp, kacab) VALUES ('$nama_cabang', '$alamat', '$no_hp', '$kacab')";
        $result = $this->koneksi->query($query);
    
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    
    public function getCabangById($id) {
        $query = "SELECT * FROM cabang WHERE idcabang = $id";
        $result = $this->koneksi->query($query);
    
        if ($result) {
            return $result->fetch_assoc();
        } else {
            die("Error: " . $this->koneksi->error);
        }
    }
    
    public function updateCabang($id, $nama_cabang, $alamat, $no_hp, $kacab) {
        $query = "UPDATE cabang SET nama_cabang='$nama_cabang', alamat='$alamat', no_telp='$no_hp', kacab='$kacab' WHERE idcabang=$id";
        return $this->koneksi->query($query);
    }
    
    public function deleteCabang($id) {
        $query = "DELETE FROM cabang WHERE idcabang = $id";
        return $this->koneksi->query($query);
    }
    
}
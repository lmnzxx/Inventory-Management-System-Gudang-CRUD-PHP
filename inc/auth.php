<?php
class auth {
    private $database;

    public function __construct(database $database){
        $this->database = $database;
    }

    public function authenticate($username, $password){
        $storedPassword = $this->getStoredPassword($username);

        if ($storedPassword !== null && $password === $storedPassword) {
            // Authentication success
            return true;
        } else {
            // Authentication failed
            return false;
        }
    }

    private function getStoredPassword($username){
        $query = "SELECT password FROM user WHERE username = ?";
        $statement = $this->database->koneksi->prepare($query);
        $statement->bind_param("s", $username);
        $statement->execute();
        $result = $statement->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['password'];
        } else {
            return null;
        }
    }

    public function getRole($username){
        $query = "SELECT role FROM user WHERE username = ?";
        $statement = $this->database->koneksi->prepare($query);
        $statement->bind_param("s", $username);
        $statement->execute();
        $result = $statement->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['role'];
        } else {
            return null;
        }
    }

    public function getNama($username){
        $query = "SELECT nama FROM user WHERE username = ?";
        $statement = $this->database->koneksi->prepare($query);
        $statement->bind_param("s", $username);
        $statement->execute();
        $result = $statement->get_result();
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['nama'];
        } else {
            return null;
        }
    }

    public function getUserId($username){
        $query = "SELECT userid FROM user WHERE username = ?";
        $statement = $this->database->koneksi->prepare($query);
        $statement->bind_param("s", $username);
        $statement->execute();
        $result = $statement->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['userid'];
        } else {
            return null;
        }
    }
}
?>

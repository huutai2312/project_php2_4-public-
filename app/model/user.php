<?php
class User
{
    private $db;

    public function __construct()
    {
        $this->db = new database();
    }

    private function getConnection()
    {
        return $this->db->connection_database();
    }

    public function getAllProducts()
    {
        $conn = $this->getConnection();

        $query = "SELECT * FROM ps_products";
        $stmt = $conn->prepare($query);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function register($password, $email, $phone, $address, $is_admin)
    {
        $conn = $this->getConnection();

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO ps_user (password, email, phone, address, is_admin) VALUES (?, ?, ?, ?, 0)";
        $stmt = $conn->prepare($query);

        $stmt->bind_param("sssss", $hashedPassword, $email, $phone, $address);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}

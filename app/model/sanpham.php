<?php
namespace App\model;
use PDO;
class SanPham
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

    public function getNew5Products($limit = 5)
    {
        $conn = $this->getConnection();

        $query = "SELECT * FROM ps_products ORDER BY Date_import DESC LIMIT :limit";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function getPopular5Products($limit = 5)
    {
        $conn = $this->getConnection();

        $query = "SELECT * FROM ps_products ORDER BY Viewsp DESC LIMIT :limit";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function getSale5Products($limit = 5)
    {
        $conn = $this->getConnection();

        $query = "SELECT * FROM ps_products WHERE Sale > 0 LIMIT :limit";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }


    public function getProductById($product_id)
    {
        $conn = $this->getConnection();

        $query = "SELECT * FROM ps_products WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $product_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
}
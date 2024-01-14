<?php
namespace App\model;
use PDO;

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

    public function getUserByEmail($email)
    {
        $conn = $this->getConnection();

        $query = "SELECT * FROM ps_user WHERE email = :email";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function registerUser($name, $email, $password)
    {
        $conn = $this->getConnection();

        // Thực hiện câu truy vấn để thêm thông tin người dùng vào cơ sở dữ liệu
        $query = "INSERT INTO ps_user (name, email, password, address, phone, is_admin) VALUES (:name, :email, :password, :address, :phone, :is_admin)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindValue(':address', '', PDO::PARAM_STR);
        $stmt->bindValue(':phone', '0', PDO::PARAM_STR);
        $stmt->bindValue(':is_admin', '0', PDO::PARAM_STR);

        // Thực thi câu truy vấn
        $stmt->execute();

        header("Location: /?registerSuccess=1");  // Điều hướng về địa chỉ trang home với tham số query "success=1"
        exit();  // Đảm bảo dừng kịch bản ngay sau lệnh chuyển hướng
    }
}

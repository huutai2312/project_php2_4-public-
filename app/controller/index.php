<?php

namespace App\controller;

use App\model\SanPham;
use App\model\User;

class Controller
{
    // Start import header, footer
    public function importHeader()
    {
        include_once "../asm/app/view/inc/header.php";
    }

    public function importFooter()
    {
        include_once "../asm/app/view/inc/footer.php";
    }
    // End import header, footer

    public function index()
    {
        $this->importHeader();
        $sanPhamModel = new SanPham();
        $products = $sanPhamModel->getAllProducts();
        include "../asm/app/view/home.php";

        // Kiểm tra nếu có tham số query "success"
        if (isset($_GET['registerSuccess']) && $_GET['registerSuccess'] == 1) {
            // Hiển thị cảnh báo (alert) với JavaScript
            echo "<script>alert('Đăng ký thành công!');</script>";
        }

        $this->importFooter();
    }

    public function productDetail($product_id)
    {
        $this->importHeader();
        $sanPhamModel = new SanPham();
        $productDetail = $sanPhamModel->getProductById($product_id);
        if ($productDetail) {
            include "../asm/app/view/san-pham.php";
        } else {
            echo "<script>window.location.href = '/'</script>";
        }
        $this->importFooter();
    }

    public function cuahang()
    {
        $this->importHeader();
        $sanPhamModel = new SanPham();
        $products = $sanPhamModel->getAllProducts();
        include "../asm/app/view/cua-hang.php";
        $this->importFooter();
    }

    public function indexUser()
    {
        $this->importHeader();
        include "../asm/app/view/tai-khoan.php";
        $this->importFooter();
    }

    public function login()
    {
        $this->importHeader();
        include "../asm/app/view/login.php";
        $this->importFooter();
    }

    public function register()
    {
        $this->importHeader();
        include "../asm/app/view/register.php";
        $this->importFooter();
    }

    public function registerUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Kiểm tra và xử lý thông tin đăng ký từ form
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // Thực hiện các kiểm tra và xử lý đăng ký ở đây

            // Ví dụ: Kiểm tra rỗng
            if (empty($name) || empty($email) || empty($password) || empty($confirmPassword)) {
                echo "Vui lòng điền đầy đủ thông tin!";
                return;
            }

            // Ví dụ: Kiểm tra mật khẩu và xác nhận mật khẩu
            if ($password !== $confirmPassword) {
                echo "Mật khẩu và xác nhận mật khẩu không khớp!";
                return;
            }

            // Hash mật khẩu trước khi lưu vào cơ sở dữ liệu
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Thêm thông tin người dùng vào cơ sở dữ liệu
            $userModel = new User();
            $userModel->registerUser($name, $email, $hashedPassword);

            // Điều hướng hoặc hiển thị thông báo thành công
            echo "<script>alert('Đăng ký thành công!')</script>";
            return;
        }

        // Nếu không phải là phương thức POST, hiển thị trang đăng ký
        $this->importHeader();
        include "../asm/app/view/register.php";
        $this->importFooter();
    }
}

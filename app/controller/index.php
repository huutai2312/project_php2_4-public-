<?php

namespace App\controller;

use App\model\SanPham;
use App\model\User;

class Controller
{
    public function importHeader()
    {
        include_once "../asm/app/view/inc/header.php";
    }

    public function importFooter()
    {
        include_once "../asm/app/view/inc/footer.php";
    }

    public function index()
    {
        $this->importHeader();
        $sanPhamModel = new SanPham();
        $products = $sanPhamModel->getAllProducts();
        include "../asm/app/view/home.php";

        // Kiểm tra nếu có tham số query "success"
        if (isset($_GET['registerSuccess']) && $_GET['registerSuccess'] == 1) {
            echo "<script>alert('Đăng ký thành công, vui lòng đăng nhập lại tài khoản của bạn!');</script>";
        }

        if (isset($_GET['loginSuccess']) && $_GET['loginSuccess'] == 1) {
            echo "<script>alert('Đăng nhập thành công!');</script>";
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

    public function taiKhoan()
    {
        session_start();
        // Kiểm tra xem có session người dùng hay không
        if (isset($_SESSION['user'])) {
            // Nếu có, hiển thị trang "Tài Khoản" với thông tin người dùng
            $this->importHeader();
            include "../asm/app/view/tai-khoan.php";
            $this->importFooter();
        } else {
            header("Location: /login");
            exit();
        }
    }

    public function login()
    {
        $this->importHeader();
        include "../asm/app/view/login.php";
        $this->importFooter();
    }

    public function loginUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Nhận thông tin đăng nhập từ form
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            // Thực hiện kiểm tra đăng nhập ở đây
            $userModel = new User();
            $user = $userModel->getUserByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                // Đăng nhập thành công, lưu thông tin người dùng vào session
                session_start();
                $_SESSION['user'] = $user;

                // Chuyển hướng về trang home với tham số query "loginSuccess"
                header("Location: /?loginSuccess=1");
                exit();
            } else {
                // Đăng nhập không thành công, hiển thị cảnh báo
                // echo "<script>alert('Đăng nhập không thành công. Vui lòng kiểm tra lại thông tin đăng nhập.');</script>";
                header("Location: /login?loginFailed=1");
                exit();
            }
        }
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
                header("Location: /register?registerFailed=1");
                exit();
                // echo "Vui lòng điền đầy đủ thông tin!";
                // return;
            }

            // Ví dụ: Kiểm tra mật khẩu và xác nhận mật khẩu
            if ($password !== $confirmPassword) {
                header("Location: /register?registerFailed=2");
                exit();
                // echo "Mật khẩu và xác nhận mật khẩu không khớp!";
                // return;
            }

            if ($this->checkUserExists($email)) {
                header("Location: /register?registerFailed=3");
                exit();
                // echo "Email đã được sử dụng, vui lòng chọn email khác!";
                // return;
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

    public function checkUserExists($email)
    {
        $userModel = new User();
        $existingUser = $userModel->getUserByEmail($email);

        return $existingUser !== false;
    }

    public function logout()
    {
        session_start();
        // Xóa toàn bộ thông tin người dùng khỏi session
        unset($_SESSION['user']);
        // Hủy toàn bộ session
        session_destroy();
        // Chuyển hướng về trang đăng nhập với thông báo đăng xuất thành công
        header("Location: /");
        exit();
    }
}

<?php
namespace App\controller;
use App\model\SanPham;

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
}

<?php

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
        $this->importFooter();
    }
    
    public function productDetail($product_id){
        $this->importHeader();
        $sanPhamModel = new SanPham();
        $productDetail = $sanPhamModel->getProductById($product_id);
        include "../asm/app/view/san-pham.php";
        $this->importFooter();
    }
}

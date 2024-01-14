<?php
require_once(__DIR__ . '/public/router.php');
require_once(__DIR__ . '/app/controller/index.php');
require_once realpath("vendor/autoload.php");
use App\controller\Controller;

$router = new Router();
$router
    ->get('/', [Controller::class, 'index'])
    ->get('/cua-hang', [Controller::class, 'cuahang'])
    ->get('/san-pham', [Controller::class, 'productDetail'])
    ->get('/tai-khoan', [Controller::class, 'taikhoan'])
    ->get('/login', [Controller::class, 'login'])
    ->post('/loginUser', [Controller::class, 'loginUser'])
    ->get('/register', [Controller::class, 'register'])
    ->post('/register', [Controller::class, 'registerUser'])
    ->get('/logout', [Controller::class, 'logout']);

echo $router->resolve(
    $_SERVER['REQUEST_URI'],
    strtolower($_SERVER['REQUEST_METHOD']),
    // Truyền giá trị $product_id nếu có
    isset($_GET['id']) ? $_GET['id'] : null
);
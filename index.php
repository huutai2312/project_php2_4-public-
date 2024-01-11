<?php
require_once(__DIR__ . '/public/router.php');
require_once(__DIR__ . '/app/controller/index.php');


// auto loading
spl_autoload_register('model');
function model($className)
{
    $path = "../asm/app/model/";
    $extension = ".php";
    $fullpath = $path . $className . $extension;
    include_once($fullpath);
}


$router = new Router();
$router
    ->get('/', [Controller::class, 'index'])
    ->get('/san-pham', [Controller::class, 'productDetail']);

echo $router->resolve(
    $_SERVER['REQUEST_URI'],
    strtolower($_SERVER['REQUEST_METHOD']),
    // Truyền giá trị $product_id nếu có
    isset($_GET['id']) ? $_GET['id'] : null
);


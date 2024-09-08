<?php
require_once 'ApiClient.php';
require 'vendor/autoload.php';

use MyProject\ApiClient;

$apiClient = new ApiClient();
$dataProducts = $apiClient->getProductos();
$dataCategorias = $apiClient->getCategorias();


$product_id = (int) $_REQUEST['id'];
$productsById = [];
foreach ($dataProducts as $product) {
    $productsById[$product['id']][] = $product;
}
// Luego puedes acceder a los productos de una categoría específica directamente
$products = isset($productsById[$product_id]) ? $productsById[$product_id] : [];

echo  $product['description'];
var_dump($dataProducts);

include 'product_details.html';
?>

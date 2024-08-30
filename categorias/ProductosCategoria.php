<?php
require_once '../ApiClient.php';
require '../vendor/autoload.php';

use MyProject\ApiClient;

$apiClient = new ApiClient();
$dataProducts = $apiClient->getProductos();
$dataCategorias = $apiClient->getCategorias();

// $parentCategory = 4;
// $filteredCategories = array_filter($dataCategorias, function ($category) use ($parentCategory) {
//     return $category['parent_category'] === $parentCategory;
// });

  if(isset($_REQUEST['id'])){
    $dataProductsCategory = $apiClient->getProductosCategorias($_REQUEST['id']);
    if(is_numeric($_REQUEST['id'])) {
      $category_id = (int) $_REQUEST['id'];
    }
    $productsByCategory = [];
    foreach ($dataProducts as $product) {
        $productsByCategory[$product['category_id']][] = $product;
    }
    // Luego puedes acceder a los productos de una categoría específica directamente
    $products = isset($productsByCategory[$category_id]) ? $productsByCategory[$category_id] : [];
  }else{
    $products = $dataProducts;
  }

include 'productoCategoria.html';
?>

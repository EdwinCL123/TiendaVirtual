<?php
require_once 'ApiClient.php';
require 'vendor/autoload.php';

use MyProject\ApiClient;

$apiClient = new ApiClient();
$dataProducts = $apiClient->getProductos();
$dataCategorias = $apiClient->getCategorias();


$dataCategorias = $dataCategorias;

include 'index.html';
?>

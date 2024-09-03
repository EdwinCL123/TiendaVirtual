<?php

namespace MyProject;

class ApiClient
{
    private $apiUrlProducts;
    private $apiUrlCategorias;


    public function __construct()
    {
        $this->apiUrlProducts = 'https://api-ecommerce-01.azurewebsites.net/api/productos/';
        $this->apiUrlCategorias = 'https://api-ecommerce-01.azurewebsites.net/api/categorias/';
        // $this->apiUrlProducts = 'https://api-ecommerce-01.azurewebsites.net/api/producto/';
        // $this->apiUrlCategorias = 'https://api-ecommerce-01.azurewebsites.net/api/categoria_producto/';

    }

    public function getProductos()
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->apiUrlProducts);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
            return [];
        }

        curl_close($ch);
        return json_decode($response, true);
    }


    public function getProductosCategorias($categoryId = null)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->apiUrlProducts);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
            return [];
        }

        curl_close($ch);
        $productos = json_decode($response, true);

        if ($categoryId !== null) {
            $productos = array_filter($productos, function($producto) use ($categoryId) {
                return $producto['category'] == $categoryId;
            });
        }

        return $productos;
    }




    public function getCategorias()
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->apiUrlCategorias);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
            return [];
        }

        curl_close($ch);


        return json_decode($response, true);
    }

    private function getToken()
    {
        // Aquí deberías obtener tu token de acceso
        return 'tu_token_de_acceso';
    }
}
?>

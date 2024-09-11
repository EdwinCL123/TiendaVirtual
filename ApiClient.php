<?php

namespace MyProject;

class ApiClient
{
    private $apiUrlProducts;
    private $apiUrlCategorias;
    private $apiUrlImagenes;

    public function __construct()
    {
        $this->apiUrlProducts = 'https://api-ecommerce-01.azurewebsites.net/api/productos/';
        $this->apiUrlCategorias = 'https://api-ecommerce-01.azurewebsites.net/api/categorias/';
        $this->apiUrlImagenes = 'https://api-ecommerce-01.azurewebsites.net/api/imagenes/';
    }

    public function getProductos()
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->apiUrlProducts);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);  // Tiempo máximo de espera de 10 segundos

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
            curl_close($ch);
            return []; // Retorna un arreglo vacío en caso de error
        }

        curl_close($ch);
        return json_decode($response, true);
    }

    public function getProductosCategorias($categoryId = null)
    {
        $productos = $this->getProductos(); // Reutilizamos la función anterior

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
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);  // Tiempo máximo de espera de 10 segundos

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
            curl_close($ch);
            return []; // Retorna un arreglo vacío en caso de error
        }

        curl_close($ch);
        return json_decode($response, true);
    }

    public function getImagenes($productId)
    {
        $ch = curl_init();
    
        // Configuramos la URL correcta para obtener las imágenes
        curl_setopt($ch, CURLOPT_URL, $this->apiUrlImagenes);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);  // Tiempo máximo de espera de 10 segundos
    
        $response = curl_exec($ch);
    
        // Verificar si hubo un error en la solicitud
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
            curl_close($ch);
            return []; // Retorna un arreglo vacío en caso de error
        }
    
        curl_close($ch);
    
        // Decodificar la respuesta JSON a un array
        $imagenes = json_decode($response, true);
    
        // Si no se pudo decodificar la respuesta o no hay imágenes, retornar un array vacío
        if (!is_array($imagenes)) {
            return [];
        }
    
        // Filtrar las imágenes del producto específico usando el campo "producto"
        $imagenesFiltradas = array_filter($imagenes, function($imagen) use ($productId) {
            // Comparamos el ID del producto con el campo "producto" en la imagen
            return isset($imagen['producto']) && $imagen['producto'] == $productId;
        });
    
        return $imagenesFiltradas;
    }
    

    // Devolver la primera imagen encontrada o todas si lo prefieres
    // return reset($imagenes)['ruta']; // Si hay varias imágenes y deseas la primera


    private function getToken()
    {
        // Aquí deberías obtener tu token de acceso
        return 'tu_token_de_acceso';
    }
}
?>

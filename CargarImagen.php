<?php

    // Permitir solicitudes desde el origen específico
    header("Access-Control-Allow-Origin: http://localhost:4200");
    // Permitir ciertos métodos HTTP (GET, POST, etc.)
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    // Permitir ciertos encabezados
    header("Access-Control-Allow-Headers: Content-Type, Authorization");

    $targetDir = "C:/Users/pipe1/OneDrive/Escritorio/";
    $targetFile = $targetDir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {

        // Respuesta de éxito
        $response = [
            'ruta' => $targetFile,  // Esta es la ruta completa del archivo subido
            'status' => 'OK',
            'message' => 'El archivo ' . basename($_FILES["file"]["name"]) . ' ha sido cargado correctamente.'
        ];
        echo json_encode($response);  // Enviar el JSON

    } else {
        // Respuesta de éxito
        $response = [
            'message' => 'Error'
        ];
        echo json_encode($response);  // Enviar el JSON

    }
        
?>
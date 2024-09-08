<?php
// Permitir solicitudes desde el origen específico
header("Access-Control-Allow-Origin: http://localhost:4200");
// Permitir ciertos métodos HTTP (GET, POST, OPTIONS)
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
// Permitir ciertos encabezados
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Directorio dentro del proyecto donde se guardarán las imágenes
$targetDir = __DIR__ . "/assets/uploads/";  // Usar una carpeta relativa dentro del proyecto
// Verificar si el directorio existe, si no, crearlo
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}

$targetFile = $targetDir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

// Mover el archivo a la ubicación dentro del proyecto
if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
    // Generar la URL de la imagen
    $imageUrl = "/assets/uploads/" . basename($_FILES["file"]["name"]);

    // Respuesta de éxito con la ruta relativa
    $response = [
        'ruta' => $imageUrl,  // Esta es la URL de la imagen cargada
        'status' => 'OK',
        'message' => 'El archivo ' . basename($_FILES["file"]["name"]) . ' ha sido cargado correctamente.'
    ];
    echo json_encode($response);  // Enviar el JSON

} else {
    // Respuesta de error
    $response = [
        'message' => 'Error al subir el archivo.'
    ];
    echo json_encode($response);  // Enviar el JSON
}
?>

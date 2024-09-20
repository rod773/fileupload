<?php 
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, X-WP-Nonce, Content-Type, Accept, Authorization');
if ('OPTIONS' == $_SERVER['REQUEST_METHOD']) {
    header("Status: 200 Ok");
    exit;
}

$response = array();
$upload_dir = 'uploads/';
$server_url = 'http://localhost/wordpress/tienda/';


// if (isset($_FILES['file'])) {
//     $nombre = $_FILES['file']['name'];
//     $tipo = $_FILES['file']['type'];
//     $tamano = $_FILES['file']['size'];
//     $temporal = $_FILES['file']['tmp_name'];
//     $error = $_FILES['file']['error'];


//     echo json_encode([$nombre,$tipo,$tamano,$temporal,$error]);
// }

// Verificar si se subió un archivo sin errores
if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
    // Tamaño máximo permitido en bytes (2 MB)
    $tamanoMaximo = 2 * 1024 * 1024;

    // Tipos de archivo permitidos (jpg y png)
    $tiposPermitidos = ['image/jpeg', 'image/png'];

    // Validar tamaño y tipo del archivo
    if ($_FILES['file']['size'] <= $tamanoMaximo && in_array($_FILES['file']['type'], $tiposPermitidos)) {
        
        $directorioDestino = '../uploads/';
        $ubicacionFinal = $directorioDestino . basename($_FILES['file']['name']);

        if (move_uploaded_file($_FILES['file']['tmp_name'], $ubicacionFinal)) {
            echo json_encode([
                'message' => "El archivo se ha subido correctamente.",
                'url' => $server_url.$upload_dir
            ]);
        } else {
            echo "Error al mover el archivo.";
        }

    } else {
        echo "El archivo no cumple con los requisitos de tamaño o tipo.";
    }
} else {
    echo "Error al subir el archivo.";
}





 

// echo json_encode($response);
?>
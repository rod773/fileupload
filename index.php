<?php


$origin = '*';
header('Content-Type: application/json; charset=utf-8, multipart/form-data');
header('Access-Control-Allow-Origin: '.$origin);
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, X-WP-Nonce, Content-Type, Accept, Authorization');
if ('OPTIONS' == $_SERVER['REQUEST_METHOD']) {
    header("Status: 200 Ok");
    exit;
}






$root = $_SERVER["DOCUMENT_ROOT"];

require_once($root."/wp-load.php");

$method = $_SERVER['REQUEST_METHOD'];



switch($method){

    case "GET":

        header("Location:  /");

        exit();

    break;

    case "POST":

        $request = file_get_contents("php://input");

                
                
        $server_url = get_site_url();

        $upload_dir = "/tienda/uploads/";

        


        if (isset($_FILES['file']) 
        && $_FILES['file']['error'] == 0
        ) {


            


        $nombre = $_FILES['file']['name'];
        $tipo = $_FILES['file']['type'];
        $tamano = $_FILES['file']['size'];
        $temporal = $_FILES['file']['tmp_name'];
        $error = $_FILES['file']['error'];

        //Tamaño máximo permitido en bytes (2 MB)
        $tamanoMaximo = 2 * 1024 * 1024;

        //Tipos de archivo permitidos (jpg y png)
        $tiposPermitidos = ['image/jpeg', 'image/png','image/svg+xml'];

        //Validar tamaño y tipo del archivo
        if ($_FILES['file']['size'] <= $tamanoMaximo && in_array($_FILES['file']['type'], $tiposPermitidos)) {
            
            $directorioDestino = $root.'/tienda/uploads/';
            $ubicacionFinal = $directorioDestino . basename($_FILES['file']['name']);

            if (move_uploaded_file($_FILES['file']['tmp_name'], $ubicacionFinal)) {
                echo json_encode([
                    'message' => "El archivo se ha subido correctamente.",
                    'url' => $server_url . $upload_dir . $nombre 
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


       

    break;
}








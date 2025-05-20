<?php
//Conecta con la base de datos
require_once("./config/databaseConfig.php");
//Controlador que maneja la logica del CRUD (sirve para el switch que sigue)
require_once("./controllers/studentsController.php");

//Todos los heandle...($conn) estan definidos en studentsController
//$conn viene de la coneccion que se hizo en config.php
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        handleGet($conn);
        break;
    case 'POST':
        handlePost($conn);
        break;
    case 'PUT':
        handlePut($conn);
        break;
    case 'DELETE':
        handleDelete($conn);
        break;
    default:
        http_response_code(405);
        echo json_encode(["error" => "Método no permitido"]);
        break;
}
?>
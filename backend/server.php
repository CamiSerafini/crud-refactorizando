<?php
/**
 * DEBUG MODE
 */
ini_set('display_errors', 1);
//para que muestre errores directamente en pantalla (ideal para el desarrollo,
//pero no para "la entrega", la idea es que el cliente no vea estos errores internos)
error_reporting(E_ALL);
//muestra todo tipo de errores, por lo cual tambien desactivar en sitios reales

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
//estas 3 ultimas lineas son claves para que funcione bien fetch() en JS

//lo siguiente se agrega para preflight: al js hacer una solicitud al servidor con fetch
//que esta en otro dominio o puerto, el navegador envia una solicitud OPTIONS
//para consultar si esta permitido que tal origen haga la solicitud.
//Entonces cuando recibe eso le doy http_response_code(200)=OK
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

//Inluimos el archivo que define las rutas o la lógica que responderá la petición.
require_once("./routes/studentsRoutes.php");
?>
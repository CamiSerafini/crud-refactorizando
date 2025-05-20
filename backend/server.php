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

$uri = parse_url($_SERVER['REQUEST_URI']);
//toma toda la URL y la separa en partes
//parse_url la convierte en estudiante como:
/*[
  'path' => '/routes.php',
  'query' => 'module=estudiantes'
]*/

$query = $uri['query'];
//extrae solo la parte del query string
//$query = 'module=estudiantes';

parse_str($query,$query_array);
//$query = 'module=estudiantes';
//$query_array = ['module' => 'estudiantes'];

$module = $query_array['module'];
//$query_array = ['module' => 'estudiantes'];

if (!$module) 
{
    http_response_code(400);
    echo json_encode(["error" => "Módulo no especificado"]);
    exit();
}

$routeFile = __DIR__ . "/routes/{$module}Routes.php";
//__DIR__ es una constante de PHP que me devuelve la ruta absoluta del
//directorio actual, en este caso server.php
//convierte {$module} teniendo asi la ruta completa del archivo


if (file_exists($routeFile)) 
{
    require_once($routeFile);
} 
else 
{
    http_response_code(404);
    echo json_encode(["error" => "Ruta para el módulo '{$module}' no encontrada"]);
}

//Inluimos el archivo que define las rutas o la lógica que responderá la petición.
// require_once("./routes/studentsRoutes.php");
?>
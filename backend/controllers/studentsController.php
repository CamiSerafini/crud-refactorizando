<?php
//se incluye students.php para principio de separacion de responsabilidades
//el controlador no accede directamente a la DB, sino que delega esa tarea al modelo
//pasandole la coneccion
require_once("./models/students.php");

function handleGet($conn) {
    if (isset($_GET['id'])) { //me devuelve el estudiante
        $result = getStudentById($conn, $_GET['id']); /*Funcion en modelos*/
        echo json_encode($result->fetch_assoc());
    } else { //me devuelve la lista completa
        $result = getAllStudents($conn); /*Funcion en modelos*/
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data); //pasa a JSON para que el frontend pueda interpretarlo
    }
}

function handlePost($conn) {
    //recibe en formato JSON los datos enviados para un nuevo estudiante
    //por eso "decode"
    $input = json_decode(file_get_contents("php://input"), true);/*Funcion en modelos*/
    if (createStudent($conn, $input['fullname'], $input['email'], $input['age'])) {
        echo json_encode(["message" => "Estudiante agregado correctamente"]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "No se pudo agregar"]);
    }
}

function handlePut($conn) {
    //requiere id de estudiante a editar y nuevos valores
    $input = json_decode(file_get_contents("php://input"), true);
    if (updateStudent($conn, $input['id'], $input['fullname'], $input['email'], $input['age'])) {
        /*Funcion en modelos*/
        echo json_encode(["message" => "Actualizado correctamente"]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "No se pudo actualizar"]);
    }
}

function handleDelete($conn) {
    //recibe el id en formato json
    $input = json_decode(file_get_contents("php://input"), true);
    if (deleteStudent($conn, $input['id'])) { /*Funcion en modelos*/
        echo json_encode(["message" => "Eliminado correctamente"]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "No se pudo eliminar"]);
    }
}
?>
<?php
function getAllStudents($conn) {
    $sql = "SELECT * FROM students";
    return $conn->query($sql);
    /*$conn->query($sql); es un metodo de la clase mysqli.
    query ejecuta la instruccion SQL, es un meto sincronico.
    La consulta es de lectura (SELECT) entonces devuelve un objeto
    msqli_result que tiene todos los resultado que devolvió la base de datos
    Puedes recorrerlos con métodos como:
    - $result->fetch_assoc() → devuelve una fila como un array asociativo.
    - $result->fetch_all() → devuelve todas las filas de una vez.*/
}

function getStudentById($conn, $id) {
    $sql = "SELECT * FROM students WHERE id = ?";
    //El signo de interrogación ? es un marcador de posición, que se 
    //reemplazará por el valor real de $id usando un método seguro (evita inyecciones SQL).
    $stmt = $conn->prepare($sql); //Prepara la consulta SQL para su ejecución.
    //Devuelve un objeto mysqli_stmt (statement).
    $stmt->bind_param("i", $id);
    //bind_param Asocia el parámetro $id al ? de la consulta.
    //"i" indica que el tipo de datos es integer
    $stmt->execute();
    //Ejecuta la consulta preparada con el valor ya enlazado a $id.
    return $stmt->get_result(); //Devuelve el resultado de la consulta como un objeto mysqli_result.
}

function createStudent($conn, $fullname, $email, $age) {
    $sql = "INSERT INTO students (fullname, email, age) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $fullname, $email, $age);
    //string, string, integer
    return $stmt->execute(); //devuelve true o false
}

function updateStudent($conn, $id, $fullname, $email, $age) {
    $sql = "UPDATE students SET fullname = ?, email = ?, age = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $fullname, $email, $age, $id);
    return $stmt->execute();
}

function deleteStudent($conn, $id) {
    $sql = "DELETE FROM students WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}
/*Uso entonces prepare y bind-param cuando hay entradas de usuario
ya que sino pueden leer datos sensibles, mofidicar o eliminar datos,
obtener el control del servidor.
Envian los datos separados al servidor

Prepare() le dice a MySQL "esto es un espacio seguro para un datos, no lo interpretes como un código"
*/
?>
# Descripción general

Tengo la parte del frontend:
- html
- css
- js

Y la parte del backend:
- php
- sql

## Conexiones entre archivos
1. En primer lugar esta HTML con la estructura básica. Este conecta con CSS y JS.
2. CSS da los estilos.
3. JS genera interactividad y es donde hago la conexion con el backend, con server.php
4. server.php: deriva el procesamiento de peticiones a studentsRoutes.php. Debe analizar la URL, el metodo y decidir que controlador usar.
5. studentsRoutes.php se conecta con config.php (para conectar a la base de datos) y con studentsController.php (para manejar la logica del CRUD segun la petición)
6. config.php: configura y establece una conexión con la base de datos
7. studentsController.php Recibe, procesa y responde las solicitudes HTTP. Se conecta con model -> students.php
8. students.php interactua con la base de datos
9. El código para la creacion de la base de datos, usuario, contraseña, otorgamiento de permisos, creacion de tablas y todo esta en un archivo .sql
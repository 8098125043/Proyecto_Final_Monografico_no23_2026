<?php
include("conexion.php");

$correo = "admin@gmail.com";
$password = password_hash("123456", PASSWORD_DEFAULT);

mysqli_query($conn,"
INSERT INTO administradores(correo,password)
VALUES('$correo','$password')
");

echo "Administrador creado correctamente";
?>
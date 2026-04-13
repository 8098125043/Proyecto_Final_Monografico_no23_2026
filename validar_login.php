<?php

session_start();

include("conexion.php");

$correo = $_POST['correo'];
$password = $_POST['password'];

$query = "SELECT * FROM administradores 
WHERE correo='$correo' AND password='$password'";

$resultado = mysqli_query($conn,$query);

if(mysqli_num_rows($resultado) > 0){

$_SESSION['admin'] = $correo;

header("Location: dashboard.php");

}else{

echo "Datos incorrectos";

}

?>
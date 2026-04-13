<?php

$host = "localhost";
$usuario = "root";
$password = "0101";
$bd = "SistemaContable";

$conn = mysqli_connect($host, $usuario, $password, $bd);

if(!$conn){
    die("Error de conexión a la bse de datos");
}

?>

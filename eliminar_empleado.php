<?php
include("conexion.php");

$id = $_GET['id'];


mysqli_query($conn, "UPDATE empleados SET estado='inactivo' WHERE id=$id");

header("Location: empleados.php");
?>

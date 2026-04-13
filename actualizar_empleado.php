<?php
include("conexion.php");

/* VALIDAR */
if(!isset($_POST['id'])){
    die("Error ID");
}

$id = intval($_POST['id']);
$cargo = $_POST['cargo'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];

/* SALARIO AUTOMÁTICO */
switch($cargo){
    case "Director": $salario = 80000; break;
    case "Coordinador": $salario = 45000; break;
    case "Profesor": $salario = 35000; break;
    case "Secretaria": $salario = 25000; break;
    case "Asistente": $salario = 20000; break;
    case "Conserje": $salario = 18000; break;
}

/* SOLO ACTUALIZA ESTO */
$sql = "UPDATE empleados SET 
cargo='$cargo',
salario='$salario',
telefono='$telefono',
correo='$correo'
WHERE id='$id'";

$result = mysqli_query($conn, $sql);

if(!$result){
    die("Error: " . mysqli_error($conn));
}

/* HISTORIAL */
mysqli_query($conn, "
INSERT INTO historial_movimientos(tipo_movimiento, descripcion, monto)
VALUES('Empleado','Empleado actualizado ID: $id','$salario')
");

header("Location: empleados.php?edit=ok");
exit();
?>
<?php
include("conexion.php");

/* VALIDAR */
if(!isset($_POST['id'])){
    die("Error: ID no recibido");
}

$id = intval($_POST['id']);
$curso = $_POST['curso'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];

/* SOLO ACTUALIZA ESTO */
$sql = "UPDATE estudiantes 
SET 
curso='$curso',
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
VALUES('Actualización','Estudiante actualizado ID: $id',0)
");

/* REDIRECCIÓN */
header("Location: estudiantes.php?edit=ok");
exit();
?>
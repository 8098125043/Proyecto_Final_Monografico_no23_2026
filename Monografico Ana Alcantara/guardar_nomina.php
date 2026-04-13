<?php
include("conexion.php");

/* VALIDAR DATOS */
if(
empty($_POST['id_empleado']) ||
empty($_POST['salario']) ||
empty($_POST['fecha_pago'])
){
    die("Faltan datos");
}

/* DATOS */
$id_empleado = $_POST['id_empleado'];
$salario = $_POST['salario'];
$bono = $_POST['bono'] ?? 0;
$deduccion = $_POST['deduccion'] ?? 0;
$fecha_pago = $_POST['fecha_pago'];

/* CALCULO TOTAL */
$total = ($salario + $bono) - $deduccion;

/* INSERT NOMINA */
$result = mysqli_query($conn,"
INSERT INTO nomina(id_empleado, salario, bono, deduccion, total_pagado, fecha_pago)
VALUES('$id_empleado','$salario','$bono','$deduccion','$total','$fecha_pago')
");

if(!$result){
    die("Error: " . mysqli_error($conn));
}

/* 🔥 GUARDAR ID ANTES DEL HISTORIAL */
$id_pago = mysqli_insert_id($conn);

/* HISTORIAL */
mysqli_query($conn,"
INSERT INTO historial_movimientos(tipo_movimiento, descripcion, monto)
VALUES('Nómina','Pago empleado ID $id_empleado','$total')
");

/* REDIRECCIÓN */
header("Location: recibo_nomina.php?id=$id_pago");
exit();
?>
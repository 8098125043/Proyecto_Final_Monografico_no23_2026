<?php
include("conexion.php");

/* =========================
FUNCION PRECIO
========================= */
function obtenerPrecioCurso($curso){

if(is_numeric($curso)){
    return 1000;
}

switch($curso){

case "1ro Básica":
case "2do Básica":
case "3ro Básica":
case "4to Básica":
case "5to Básica":
case "6to Básica":
return 1000;

case "1ro Secundaria":
case "2do Secundaria":
case "3ro Secundaria":
return 1500;

case "4to Secundaria":
case "5to Secundaria":
case "6to Secundaria":
return 2000;

default:
return 1000;
}
}

/* =========================
VALIDAR DATOS
========================= */
if(empty($_POST['id_estudiante']) || empty($_POST['metodo_pago'])){
    die("Faltan datos obligatorios");
}

/* =========================
DATOS
========================= */
$id_estudiante = $_POST['id_estudiante'];
$metodo = $_POST['metodo_pago'];

/* =========================
BUSCAR ESTUDIANTE
========================= */
$consulta = mysqli_query($conn,"SELECT * FROM estudiantes WHERE id='$id_estudiante'");

if(mysqli_num_rows($consulta) == 0){
    die("Estudiante no encontrado");
}

$est = mysqli_fetch_assoc($consulta);

$curso = $est['curso'];
$precio = obtenerPrecioCurso($curso);

/* =========================
ULTIMO PAGO
========================= */
$ultimo_pago = mysqli_query($conn,"
SELECT fecha_pago 
FROM pagos 
WHERE id_estudiante='$id_estudiante'
ORDER BY fecha_pago DESC LIMIT 1
");

if(mysqli_num_rows($ultimo_pago) > 0){

$fila = mysqli_fetch_assoc($ultimo_pago);

$fecha_ultima = new DateTime($fila['fecha_pago']);
$fecha_actual = new DateTime();

$diferencia = $fecha_ultima->diff($fecha_actual);
$meses_atrasados = ($diferencia->y * 12) + $diferencia->m;

if($meses_atrasados == 0){
    $meses_atrasados = 1;
}

}else{
    $meses_atrasados = 1;
}

/* =========================
MORA
========================= */
$mora = 0;

if($meses_atrasados > 1){
    $mora = ($meses_atrasados - 1) * 200;
}

/* =========================
TOTAL
========================= */
$total = ($precio * $meses_atrasados) + $mora;

/* =========================
CONCEPTO
========================= */
$concepto = "Pago de $meses_atrasados mes(es) - $curso";

/* =========================
INSERT PAGO
========================= */
$result = mysqli_query($conn,"
INSERT INTO pagos(id_estudiante, concepto, monto, fecha_pago, metodo_pago)
VALUES('$id_estudiante','$concepto','$total',NOW(),'$metodo')
");

if(!$result){
    die("Error al guardar pago: " . mysqli_error($conn));
}

/* 🔥 ESTE ES EL ARREGLO IMPORTANTE */
$id_pago = mysqli_insert_id($conn);

/* =========================
HISTORIAL
========================= */
mysqli_query($conn,"
INSERT INTO historial_movimientos(tipo_movimiento, descripcion, monto)
VALUES('Pago','Pago estudiante ID $id_estudiante','$total')
");

/* =========================
REDIRECCIÓN
========================= */
header("Location: factura_pago.php?id=$id_pago");
exit();
?>
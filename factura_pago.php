<?php
include("conexion.php");

/* VALIDAR ID */
if(!isset($_GET['id']) || empty($_GET['id'])){
    die("Error: ID no recibido");
}

$id = intval($_GET['id']);

/* CONSULTA */
$query = mysqli_query($conn,"
SELECT p.*, e.nombre, e.apellido, e.curso
FROM pagos p
INNER JOIN estudiantes e ON p.id_estudiante = e.id
WHERE p.id = $id
");

/* VALIDAR */
if(!$query){
    die("Error en la consulta: " . mysqli_error($conn));
}

if(mysqli_num_rows($query) == 0){
    die("No se encontró el pago");
}

/* DATOS */
$pago = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Factura de Pago</title>

<style>

/* FONDO */
body{
font-family:'Segoe UI', sans-serif;
background:linear-gradient(135deg,#031926,#0b3c5d);
display:flex;
justify-content:center;
align-items:center;
min-height:100vh;
margin:0;
}

/* TARJETA */
.ticket{
width:380px;
background:white;
border-radius:15px;
overflow:hidden;
box-shadow:0 15px 35px rgba(0,0,0,0.3);
}

/* HEADER */
.header{
background:linear-gradient(135deg,#468189,#77ACA2);
color:white;
text-align:center;
padding:20px;
}

.header h2{
margin:0;
}

.header span{
font-size:13px;
opacity:0.8;
}

/* CONTENIDO */
.content{
padding:20px;
}

/* INFO */
.info p{
margin:6px 0;
font-size:14px;
}

/* LINEA */
.divider{
margin:15px 0;
border-top:1px dashed #ccc;
}

/* DETALLE */
.detalle div{
display:flex;
justify-content:space-between;
margin:8px 0;
font-size:14px;
}

/* TOTAL */
.total{
margin-top:15px;
padding:10px;
background:#f4f6f9;
border-radius:8px;
display:flex;
justify-content:space-between;
font-weight:bold;
font-size:16px;
}

/* FOOTER */
.footer{
text-align:center;
font-size:12px;
color:#777;
margin-top:15px;
}

/* BOTON */
.btn{
margin:20px;
width:calc(100% - 40px);
padding:12px;
border:none;
border-radius:25px;
background:linear-gradient(45deg,#468189,#77ACA2);
color:white;
cursor:pointer;
}

/* PRINT */
@media print{
body{
background:white;
}
.btn{
display:none;
}
}

</style>

</head>

<body>

<div class="ticket">

<div class="header">
<h2>Factura de Pago</h2>
<span>Centro Educativo</span>
</div>

<div class="content">

<div class="info">
<p><strong>Estudiante:</strong> <?= $pago['nombre']." ".$pago['apellido']; ?></p>
<p><strong>Curso:</strong> <?= $pago['curso']; ?></p>
<p><strong>Fecha:</strong> <?= $pago['fecha_pago']; ?></p>
</div>

<div class="divider"></div>

<div class="detalle">
<div><span>Concepto</span><span><?= $pago['concepto']; ?></span></div>
<div><span>Monto</span><span>$<?= $pago['monto']; ?></span></div>
</div>

<div class="divider"></div>

<div class="total">
<span>Total Pagado</span>
<span>$<?= $pago['monto']; ?></span>
</div>

<div class="footer">
<p>Pago realizado correctamente ✔</p>
</div>

</div>

<button class="btn" onclick="window.print()">🖨 Imprimir</button>

</div>

</body>
</html>
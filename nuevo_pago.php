<?php
include("conexion.php");
$estudiantes = mysqli_query($conn,"SELECT * FROM estudiantes WHERE estado='activo'");
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Nuevo Pago</title>
<link rel="stylesheet" href="css/Nnomina.css">
</head>

<body>

<div class="contenedor">

<div class="card">

<h2>💰 Registrar Pago</h2>

<form action="guardar_pago.php" method="POST">

<div class="input-box">
<select name="id_estudiante" required>
<option value="" disabled selected>Seleccionar estudiante</option>

<?php while($e = mysqli_fetch_assoc($estudiantes)){ ?>
<option value="<?= $e['id']; ?>">
<?= $e['nombre']." ".$e['apellido']." - ".$e['curso']; ?>
</option>
<?php } ?>

</select>
</div>

<div class="input-box">
<select name="metodo_pago" required>
<option value="" disabled selected>Método de pago</option>
<option value="Efectivo">💵 Efectivo</option>
<option value="Transferencia">🏦 Transferencia</option>
<option value="Tarjeta">💳 Tarjeta</option>
</select>
</div>

<button type="submit" class="btn">
Generar Pago
</button>

</form>

</div>

</div>

</body>
</html>
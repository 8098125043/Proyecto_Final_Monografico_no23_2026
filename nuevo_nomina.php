<?php
include("conexion.php");
$empleados = mysqli_query($conn,"SELECT * FROM empleados");
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Pagar Nómina</title>
<link rel="stylesheet" href="css/nomina_moderno.css">
</head>

<body>

<div class="contenedor">

<div class="card-grid">

<!-- FORMULARIO -->
<div class="card">

<h2>💼 Pago de Nómina</h2>

<form action="guardar_nomina.php" method="POST">

<div class="input-box">
<select name="id_empleado" id="empleado" required onchange="llenarSalario()">
<option value="" disabled selected>Seleccionar empleado</option>

<?php while($emp = mysqli_fetch_assoc($empleados)){ ?>
<option 
value="<?= $emp['id']; ?>" 
data-salario="<?= $emp['salario']; ?>">
<?= $emp['nombre']." ".$emp['apellido']; ?>
</option>
<?php } ?>

</select>
</div>

<div class="input-box">
<input type="number" step="0.01" name="salario" id="salario" readonly placeholder="Salario automático">
</div>

<div class="input-box">
<input type="number" step="0.01" name="bono" value="0" placeholder="Bono (opcional)">
</div>

<div class="input-box">
<input type="number" step="0.01" name="deduccion" value="0" placeholder="Deducción (opcional)">
</div>

<div class="input-box">
<input type="date" name="fecha_pago" required>
</div>

<button class="btn">Procesar Pago</button>

</form>

</div>

<!-- PANEL INFO -->
<div class="card info">

<h3>📊 Gestión de Nómina</h3>

<p>
Administra los pagos de empleados de forma automática y segura.
</p>

<ul>
<li>✔ Salario automático</li>
<li>✔ Control de bonos</li>
<li>✔ Registro de historial</li>
</ul>

</div>

</div>

</div>

<!-- SCRIPT -->
<script>
function llenarSalario(){
let select = document.getElementById("empleado");
let salario = select.options[select.selectedIndex].getAttribute("data-salario");
document.getElementById("salario").value = salario;
}
</script>

</body>
</html>
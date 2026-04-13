<?php
include("conexion.php");

if(!isset($_GET['id']) || empty($_GET['id'])){
    die("ID no válido");
}

$id = intval($_GET['id']);

$query = mysqli_query($conn, "SELECT * FROM empleados WHERE id='$id'");

if(mysqli_num_rows($query) == 0){
    die("Empleado no encontrado");
}

$emp = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
<title>Editar Empleado</title>
<link rel="stylesheet" href="css/nestudiante.css">
</head>

<body>

<div class="contenedor">

<div class="card-estudiante">

<h2>Editar Empleado</h2>

<form action="actualizar_empleado.php" method="POST">

<input type="hidden" name="id" value="<?= $emp['id']; ?>">

<!-- BLOQUEADOS -->
<div class="input-box">
<input type="text" value="<?= $emp['nombre']; ?>" readonly placeholder="Nombre">
</div>

<div class="input-box">
<input type="text" value="<?= $emp['apellido']; ?>" readonly placeholder="Apellido">
</div>

<div class="input-box">
<input type="text" value="<?= $emp['cedula']; ?>" readonly placeholder="Cédula">
</div>

<div class="input-box">
<input type="date" value="<?= $emp['fecha_nacimiento']; ?>" readonly>
</div>

<!-- EDITABLE -->
<div class="input-box">
<select name="cargo" id="cargo" onchange="asignarSalario()" required>
<option value="">Seleccionar cargo</option>

<option value="Director" <?= $emp['cargo']=="Director"?"selected":""; ?>>Director</option>
<option value="Secretaria" <?= $emp['cargo']=="Secretaria"?"selected":""; ?>>Secretaria</option>
<option value="Coordinador" <?= $emp['cargo']=="Coordinador"?"selected":""; ?>>Coordinador</option>
<option value="Profesor" <?= $emp['cargo']=="Profesor"?"selected":""; ?>>Profesor</option>
<option value="Conserje" <?= $emp['cargo']=="Conserje"?"selected":""; ?>>Conserje</option>
<option value="Asistente" <?= $emp['cargo']=="Asistente"?"selected":""; ?>>Asistente</option>

</select>
</div>

<!-- SALARIO -->
<div class="input-box">
<input type="number" name="salario" id="salario" value="<?= $emp['salario']; ?>" readonly placeholder="Salario">
</div>

<div class="input-box">
<input type="text" name="telefono" value="<?= $emp['telefono']; ?>" placeholder="Teléfono">
</div>

<div class="input-box">
<input type="email" name="correo" value="<?= $emp['correo']; ?>" placeholder="Correo">
</div>

<button type="submit" class="btn-guardar">
Actualizar Empleado
</button>

</form>

</div>

</div>

<!-- SCRIPT -->
<script>
function asignarSalario(){

let cargo = document.getElementById("cargo").value;
let salario = document.getElementById("salario");

switch(cargo){
case "Director":
salario.value = 80000;
break;
case "Coordinador":
salario.value = 45000;
break;
case "Profesor":
salario.value = 35000;
break;
case "Secretaria":
salario.value = 25000;
break;
case "Asistente":
salario.value = 20000;
break;
case "Conserje":
salario.value = 18000;
break;
default:
salario.value = "";
}
}
</script>

</body>
</html>
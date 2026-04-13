<?php if(isset($_GET['success'])){ ?>
<script>
alert("Empleado registrado correctamente");
</script>
<?php } ?>

<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
<title>Nuevo Empleado</title>
<link rel="stylesheet" href="./css/nempleado.css">
</head>

<body>

<div class="contenedor">

<div class="card-empleado">

<h2>Nuevo Empleado</h2>

<form action="guardar_empleado.php" method="POST">

<!-- IDENTIDAD -->
<div class="input-box">
<input type="text" name="nombre" required placeholder="Nombre">
</div>

<div class="input-box">
<input type="text" name="apellido" required placeholder="Apellido">
</div>

<div class="input-box">
<input type="text" name="cedula" required placeholder="Cédula (solo números)">
</div>

<!-- FECHA NACIMIENTO (OBLIGATORIA) -->
<div class="input-box">
<input type="date" name="fecha_nacimiento" required>
</div>

<!-- CARGO -->
<div class="input-box">
<select name="cargo" id="cargo" required onchange="asignarSalario()">
<option value="" disabled selected>Seleccionar cargo</option>
<option value="Director">Director</option>
<option value="Secretaria">Secretaria</option>
<option value="Coordinador">Coordinador</option>
<option value="Profesor">Profesor</option>
<option value="Conserje">Conserje</option>
<option value="Asistente">Asistente</option>
</select>
</div>

<!-- SALARIO -->
<div class="input-box">
<input type="number" name="salario" id="salario" readonly placeholder="Salario automático">
</div>

<!-- CONTACTO -->
<div class="input-box">
<input type="text" name="telefono" placeholder="Teléfono (opcional)">
</div>

<div class="input-box">
<input type="email" name="correo" placeholder="Correo (opcional)">
</div>

<!-- FECHA INGRESO -->
<div class="input-box">
<input type="date" name="fecha_ingreso" required>
</div>

<button type="submit" class="btn-guardar">
Guardar
</button>

</form>

</div>

</div>

<!-- SCRIPT SALARIO -->
<script>
function asignarSalario(){

let cargo = document.getElementById("cargo").value;
let salario = document.getElementById("salario");

switch(cargo){
case "Director": salario.value = 80000; break;
case "Coordinador": salario.value = 45000; break;
case "Profesor": salario.value = 35000; break;
case "Secretaria": salario.value = 25000; break;
case "Asistente": salario.value = 20000; break;
case "Conserje": salario.value = 18000; break;
default: salario.value = "";
}
}
</script>

</body>
</html>
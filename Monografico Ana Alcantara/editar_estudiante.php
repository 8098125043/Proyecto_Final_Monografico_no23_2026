<?php
include("conexion.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

/* VALIDAR ID */
if(!isset($_GET['id']) || empty($_GET['id'])){
    die("ID no válido");
}

$id = intval($_GET['id']);

/* CONSULTA */
$query = mysqli_query($conn, "SELECT * FROM estudiantes WHERE id='$id'");

if(!$query){
    die("Error en consulta: " . mysqli_error($conn));
}

if(mysqli_num_rows($query) == 0){
    die("Estudiante no encontrado");
}

$est = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Estudiante</title>
<link rel="stylesheet" href="css/editEstudiante.css">
</head>

<body>

<div class="layout">

<main class="contenido">

<div class="topbar">
    <h1>✏ Editar Estudiante</h1>
</div>

<div class="form-box">

<form action="actualizar_estudiante.php" method="POST">

<input type="hidden" name="id" value="<?= $est['id']; ?>">

<!-- SOLO VISUAL -->
<div class="input-group">
    <input type="text" value="<?= $est['id_institucional']; ?>" readonly placeholder="ID Institucional">
</div>

<div class="input-group">
    <input type="text" value="<?= $est['nombre']; ?>" readonly placeholder="Nombre">
</div>

<div class="input-group">
    <input type="text" value="<?= $est['apellido']; ?>" readonly placeholder="Apellido">
</div>

<div class="input-group">
    <input type="text" value="<?= $est['cedula']; ?>" readonly placeholder="Cédula">
</div>

<div class="input-group">
    <input type="date" value="<?= $est['fecha_nacimiento']; ?>" readonly>
</div>

<!-- EDITABLES -->
<div class="input-group">
    <input type="text" name="curso" value="<?= $est['curso']; ?>" placeholder="Curso">
</div>

<div class="input-group">
    <input type="text" name="telefono" value="<?= $est['telefono']; ?>" placeholder="Teléfono">
</div>

<div class="input-group">
    <input type="email" name="correo" value="<?= $est['correo']; ?>" placeholder="Correo">
</div>

<div class="btn-group">
    <button type="submit" class="btn-guardar">Actualizar</button>
    <a href="estudiantes.php" class="btn-volver">Volver</a>
</div>

</form>

</div>

</main>

</div>

</body>
</html>
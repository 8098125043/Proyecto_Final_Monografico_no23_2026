<?php
include("conexion.php");
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<title>Crear Usuario</title>

<link rel="stylesheet" href="css/styles.css">

</head>

<body>

<div class="login-container">

<div class="right-panel">

<div class="login-box">

<h2>Crear Usuario Administrador</h2>

<form action="guardar_usuario.php" method="POST">

<div class="form-group">
<label>Correo</label>
<input type="email" name="correo" required>
</div>

<div class="form-group">
<label>Contraseña</label>
<input type="password" name="password" required>
</div>

<button type="submit" class="login-btn">
Crear Usuario
</button>

</form>

</div>

</div>

</div>

</body>

</html>
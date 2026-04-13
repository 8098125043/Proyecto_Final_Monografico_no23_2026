<!DOCTYPE html>
<html lang="es">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - Sistema SICOLAR</title>

<link rel="stylesheet" href="css/index.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

</head>

<body>

<div class="login-container">

<!-- PANEL IZQUIERDO -->
<div class="left-panel">

<div class="overlay"></div>

<div class="left-content">

<h1>Sistema SICOLAR</h1>

<p>
Control de pagos estudiantiles,  
gestión de empleados y análisis financiero.
</p>

</div>

</div>

<!-- PANEL DERECHO -->
<div class="right-panel">

<div class="login-box">

<h2>Acceso Administrador</h2>

<form action="validar_login.php" method="POST">

<div class="form-group">
<input type="email" name="correo" required placeholder="Correo electrónico">
</div>

<div class="form-group">
<input type="password" name="password" required placeholder="Contraseña">
</div>

<button type="submit" class="login-btn">
Iniciar sesión
</button>

<p class="crear">
<a href="crear_usuario.php">Crear usuario administrador</a>
</p>

</form>

</div>

</div>

</div>

</body>
</html>
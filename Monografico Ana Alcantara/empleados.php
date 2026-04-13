<?php
include("conexion.php");

/* BUSCADOR */
$where = "WHERE estado='activo'";

if(isset($_GET['buscar']) && !empty($_GET['buscar'])){
    $buscar = $_GET['buscar'];
    $where .= " AND (cedula LIKE '%$buscar%' OR id LIKE '%$buscar%')";
}

/* CONSULTA */
$query = "SELECT * FROM empleados $where ORDER BY id DESC";
$resultado = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Gestión de Empleados</title>

<link rel="stylesheet" href="css/dashboard.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

</head>

<body>

<div class="layout">

<!-- SIDEBAR REUTILIZABLE -->
<?php include("menu.php"); ?>

<!-- CONTENIDO -->
<main class="contenido">

<!-- TOP -->
<div class="topbar">
<div>
<h1>Gestión de Empleados</h1>
<p class="sub">Administración del personal</p>
</div>

<a href="nuevo_empleado.php" class="btn-top verde">+ Nuevo Empleado</a>
</div>

<!-- ALERTAS -->
<?php if(isset($_GET['delete'])){ ?>
<script>alert("Empleado desactivado correctamente");</script>
<?php } ?>

<?php if(isset($_GET['edit'])){ ?>
<script>alert("Empleado actualizado correctamente");</script>
<?php } ?>

<!-- FILTROS -->
<form method="GET" class="filtros">

<input type="text" name="buscar" placeholder="Buscar por cédula o ID">

<button class="btn buscar">Buscar</button>

<a href="empleados.php" class="btn limpiar">Limpiar</a>

</form>

<!-- TABLA -->
<div class="tabla-box">

<table>

<thead>
<tr>
<th>ID</th>
<th>Nombre</th>
<th>Apellido</th>
<th>Cédula</th>
<th>Cargo</th>
<th>Salario</th>
<th>Teléfono</th>
<th>Correo</th>
<th>Ingreso</th>
<th>Estado</th>
<th>Acciones</th>
</tr>
</thead>

<tbody>

<?php if(mysqli_num_rows($resultado)>0){ ?>

<?php while($row = mysqli_fetch_assoc($resultado)){ ?>

<tr>

<td><?= $row['id']; ?></td>
<td><?= $row['nombre']; ?></td>
<td><?= $row['apellido']; ?></td>
<td><?= $row['cedula']; ?></td>
<td><?= $row['cargo']; ?></td>

<td class="monto">
$<?= number_format($row['salario']); ?>
</td>

<td><?= $row['telefono']; ?></td>
<td><?= $row['correo']; ?></td>
<td><?= $row['fecha_ingreso']; ?></td>

<td>
<?php if($row['estado']=='activo'){ ?>
<span class="badge activo">Activo</span>
<?php } else { ?>
<span class="badge inactivo">Inactivo</span>
<?php } ?>
</td>

<td class="acciones">

<a href="editar_empleado.php?id=<?= $row['id']; ?>" class="btn-editar">
✏
</a>

<a href="eliminar_empleado.php?id=<?= $row['id']; ?>"
class="btn-eliminar"
onclick="return confirm('¿Desactivar empleado?')">
🗑
</a>

</td>

</tr>

<?php } ?>

<?php } else { ?>

<tr>
<td colspan="11" style="text-align:center; padding:20px;">
No hay empleados registrados
</td>
</tr>

<?php } ?>

</tbody>

</table>

</div>

</main>

</div>

</body>
</html>
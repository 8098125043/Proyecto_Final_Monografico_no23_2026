<?php
include("conexion.php");

/* BUSCADOR */
$where = "WHERE estado='activo'";

if (isset($_GET['buscar']) && !empty($_GET['buscar'])) {
    $buscar = $_GET['buscar'];
    $where .= " AND (cedula LIKE '%$buscar%' OR id_institucional LIKE '%$buscar%')";
}

/* CONSULTA */
$query = "SELECT * FROM estudiantes $where ORDER BY id DESC";
$resultado = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Estudiantes</title>

    <link rel="stylesheet" href="css/dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

</head>

<body>

    <div class="layout">

        <!-- SIDEBAR GLOBAL -->
        <?php include("menu.php"); ?>

        <!-- CONTENIDO -->
        <main class="contenido">

            <!-- TOPBAR -->
            <div class="topbar">
                <div>
                    <h1>Gestión de Estudiantes</h1>
                    <p class="sub">Control y administración de estudiantes</p>
                </div>

                <a href="nuevo_estudiante.php" class="btn-top verde">
                    + Nuevo Estudiante
                </a>
            </div>

            <!-- ALERTAS -->
            <?php if (isset($_GET['edit'])) { ?>
                <div class="alert success">✔ Estudiante actualizado correctamente</div>
            <?php } ?>

            <?php if (isset($_GET['delete'])) { ?>
                <div class="alert warning">⚠ Estudiante desactivado correctamente</div>
            <?php } ?>

            <?php if (isset($_GET['buscar']) && mysqli_num_rows($resultado) == 0) { ?>
                <div class="alert error">❌ Estudiante no encontrado</div>
            <?php } ?>

            <!-- FILTROS -->
            <form method="GET" class="filtros">

                <input type="text" name="buscar" placeholder="Buscar por cédula o ID">

                <button class="btn buscar">Buscar</button>

                <a href="estudiantes.php" class="btn limpiar">Limpiar</a>

            </form>

            <!-- TABLA -->
            <div class="tabla-box">

                <table>

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>ID Inst.</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Cédula</th>
                            <th>Fecha</th>
                            <th>Curso</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (mysqli_num_rows($resultado) > 0) { ?>

                            <?php while ($fila = mysqli_fetch_assoc($resultado)) { ?>

                                <tr>

                                    <td><?= $fila['id']; ?></td>
                                    <td><?= $fila['id_institucional']; ?></td>
                                    <td><?= $fila['nombre']; ?></td>
                                    <td><?= $fila['apellido']; ?></td>
                                    <td><?= $fila['cedula']; ?></td>
                                    <td><?= $fila['fecha_nacimiento']; ?></td>
                                    <td><?= $fila['curso']; ?></td>

                                    <td>
                                        <?php if ($fila['estado'] == 'activo') { ?>
                                            <span class="badge activo">Activo</span>
                                        <?php } else { ?>
                                            <span class="badge inactivo">Inactivo</span>
                                        <?php } ?>
                                    </td>

                                    <td class="acciones">

                                        <a href="editar_estudiante.php?id=<?= $fila['id']; ?>" class="btn-editar">
                                            ✏
                                        </a>

                                        <a href="eliminar_estudiante.php?id=<?= $fila['id']; ?>"
                                            class="btn-eliminar"
                                            onclick="return confirm('¿Seguro que deseas desactivar este estudiante?')">
                                            🗑
                                        </a>

                                    </td>

                                </tr>

                            <?php } ?>

                        <?php } else { ?>

                            <tr>
                                <td colspan="9" class="no-data">
                                    No hay estudiantes registrados
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
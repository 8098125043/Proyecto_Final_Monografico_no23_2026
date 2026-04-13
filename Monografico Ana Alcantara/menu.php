<?php
$pagina = basename($_SERVER['PHP_SELF']);
?>

<head>
    <link rel="stylesheet" href="css/menu.css">
</head>


<aside class="sidebar">

    <!-- PERFIL -->
    <div class="perfil">

        <div class="avatar">
            <span>A</span>
        </div>

        <h3>Administrador</h3>
        <p>Sistema SICOLAR</p>

    </div>

    <!-- MENU -->
    <ul class="menu">

        <li class="<?= ($pagina == 'dashboard.php') ? 'active' : '' ?>">
            <a href="dashboard.php">📊 Dashboard</a>
        </li>

        <li class="<?= ($pagina == 'estudiantes.php') ? 'active' : '' ?>">
            <a href="estudiantes.php">👨‍🎓 Estudiantes</a>
        </li>

        <li class="<?= ($pagina == 'pagos.php') ? 'active' : '' ?>">
            <a href="pagos.php">💰 Pagos</a>
        </li>

        <li class="<?= ($pagina == 'empleados.php') ? 'active' : '' ?>">
            <a href="empleados.php">👨‍💼 Empleados</a>
        </li>

        <li class="<?= ($pagina == 'nomina.php') ? 'active' : '' ?>">
            <a href="nomina.php">📄 Nómina</a>
        </li>

        <li class="<?= ($pagina == 'historial.php') ? 'active' : '' ?>">
            <a href="historial.php">📁 Historial</a>
        </li>

        <li class="salir">
            <a href="logout.php">🚪 Salir</a>
        </li>

    </ul>

</aside>
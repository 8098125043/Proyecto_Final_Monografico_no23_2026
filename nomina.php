<?php
include("conexion.php");

/* DATOS */
$query = "
SELECT nomina.*, empleados.nombre, empleados.apellido
FROM nomina
INNER JOIN empleados ON nomina.id_empleado = empleados.id
";

$resultado = mysqli_query($conn, $query);

/* RESUMEN */
$totalQuery = mysqli_query($conn, "SELECT SUM(total_pagado) as total FROM nomina");
$total_pagado = mysqli_fetch_assoc($totalQuery)['total'] ?? 0;

$empQuery = mysqli_query($conn, "SELECT COUNT(*) as total FROM empleados");
$total_empleados = mysqli_fetch_assoc($empQuery)['total'];

$mesQuery = mysqli_query($conn, "
SELECT COUNT(*) as total FROM nomina 
WHERE MONTH(fecha_pago)=MONTH(CURRENT_DATE())
");
$pagos_mes = mysqli_fetch_assoc($mesQuery)['total'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Nómina</title>

    <link rel="stylesheet" href="css/dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

</head>

<body>

    <div class="layout">

        <!-- SIDEBAR GLOBAL -->
        <?php include("menu.php"); ?>

        <!-- CONTENIDO -->
        <main class="contenido">

            <!-- TOP -->
            <div class="topbar">
                <div>
                    <h1>Gestión de Nómina</h1>
                    <p class="sub">Control de pagos a empleados</p>
                </div>

                <a href="nuevo_nomina.php" class="btn-top verde">+ Pagar Nómina</a>
            </div>

            <!-- CARDS -->
            <div class="cards">

                <div class="card">
                    <h4>Total Pagado</h4>
                    <p>$<?= number_format($total_pagado); ?></p>
                </div>

                <div class="card">
                    <h4>Empleados</h4>
                    <p><?= number_format($total_empleados); ?></p>
                </div>

                <div class="card">
                    <h4>Pagos del Mes</h4>
                    <p><?= number_format($pagos_mes); ?></p>
                </div>

            </div>

            <!-- TABLA -->
            <div class="tabla-box">

                <table>

                    <thead>
                        <tr>
                            <th>Empleado</th>
                            <th>Fecha</th>
                            <th>Salario</th>
                            <th>Bono</th>
                            <th>Deducción</th>
                            <th>Total</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (mysqli_num_rows($resultado) > 0) { ?>

                            <?php while ($row = mysqli_fetch_assoc($resultado)) { ?>

                                <tr>

                                    <td><?= $row['nombre'] . " " . $row['apellido']; ?></td>
                                    <td><?= $row['fecha_pago']; ?></td>

                                    <td>$<?= number_format($row['salario']); ?></td>
                                    <td>$<?= number_format($row['bono']); ?></td>
                                    <td>$<?= number_format($row['deduccion']); ?></td>

                                    <td class="monto">
                                        $<?= number_format($row['total_pagado']); ?>
                                    </td>

                                </tr>

                            <?php } ?>

                        <?php } else { ?>

                            <tr>
                                <td colspan="6" style="text-align:center; padding:20px;">
                                    No hay registros de nómina
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
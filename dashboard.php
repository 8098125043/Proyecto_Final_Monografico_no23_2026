<?php
include("conexion.php");

/* FUNCION SEGURA */
function obtenerTotal($conn, $query)
{
    $res = mysqli_query($conn, $query);
    if (!$res) return 0;
    $data = mysqli_fetch_assoc($res);
    return $data['total'] ?? 0;
}

$total_estudiantes = obtenerTotal($conn, "SELECT COUNT(*) as total FROM estudiantes");
$total_empleados   = obtenerTotal($conn, "SELECT COUNT(*) as total FROM empleados");
$total_pagos       = obtenerTotal($conn, "SELECT SUM(monto) as total FROM pagos");
$total_nomina      = obtenerTotal($conn, "SELECT SUM(total_pagado) as total FROM nomina");

/* HISTORIAL */
$historial = mysqli_query($conn, "
SELECT * FROM historial_movimientos 
ORDER BY fecha DESC LIMIT 5
");

/* PAGOS */
$grafico = mysqli_query($conn, "
SELECT MONTH(fecha_pago) as mes, SUM(monto) as total
FROM pagos GROUP BY mes ORDER BY mes
");

/* NOMINA */
$graficoNomina = mysqli_query($conn, "
SELECT MONTH(fecha_pago) as mes, SUM(total_pagado) as total
FROM nomina GROUP BY mes ORDER BY mes
");

$meses = [];
$totales = [];
$totalesNomina = [];

$nombresMeses = [
    1 => 'Ene',
    2 => 'Feb',
    3 => 'Mar',
    4 => 'Abr',
    5 => 'May',
    6 => 'Jun',
    7 => 'Jul',
    8 => 'Ago',
    9 => 'Sep',
    10 => 'Oct',
    11 => 'Nov',
    12 => 'Dic'
];

while ($g = mysqli_fetch_assoc($grafico)) {
    $meses[] = $nombresMeses[$g['mes']];
    $totales[] = $g['total'];
}

/* CORREGIDO */
$totalesNomina = array_fill(0, count($meses), 0);

while ($n = mysqli_fetch_assoc($graficoNomina)) {
    $mesIndex = array_search($nombresMeses[$n['mes']], $meses);
    if ($mesIndex !== false) {
        $totalesNomina[$mesIndex] = $n['total'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>

    <link rel="stylesheet" href="css/dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

</head>

<body>

    <div class="dashboard">

        <!-- SIDEBAR -->
        <aside class="sidebar">

            <div class="perfil">
                <div class="avatar">A</div>
                <h3>Administrador</h3>
                <p>Sistema SICOLAR</p>
            </div>

            <ul class="menu">
                <li class="active"><a href="dashboard.php">📊 Dashboard</a></li>
                <li><a href="estudiantes.php">👨‍🎓 Estudiantes</a></li>
                <li><a href="pagos.php">💰 Pagos</a></li>
                <li><a href="empleados.php">👨‍💼 Empleados</a></li>
                <li><a href="nomina.php">📄 Nómina</a></li>
                <li><a href="historial.php">📁 Historial</a></li>
                <li class="salir"><a href="logout.php">🚪 Salir</a></li>
            </ul>

        </aside>

        <!-- MAIN -->
        <main class="main">

            <!-- HEADER -->
            <div class="topbar">

                <div class="left">
                    <h1>Panel de Control</h1>
                    <p class="sub">Resumen general del sistema</p>
                </div>

                <div class="toggle" onclick="toggleDark()">🌙</div>

            </div>

            <!-- CARDS -->
            <div class="cards">

                <div class="card">
                    <h4>Total Estudiantes</h4>
                    <p><?= number_format($total_estudiantes); ?></p>
                </div>

                <div class="card">
                    <h4>Pagos Recibidos</h4>
                    <p>$<?= number_format($total_pagos); ?></p>
                </div>

                <div class="card">
                    <h4>Total Empleados</h4>
                    <p><?= number_format($total_empleados); ?></p>
                </div>

                <div class="card">
                    <h4>Nómina Pagada</h4>
                    <p>$<?= number_format($total_nomina); ?></p>
                </div>

            </div>

            <!-- GRAFICOS -->
            <div class="graficos">

                <div class="grafico-card">
                    <h3>Ingresos Mensuales</h3>
                    <canvas id="graficoPagos"></canvas>
                </div>

                <div class="grafico-card">
                    <h3>Distribución General</h3>
                    <canvas id="graficoGeneral"></canvas>
                </div>

                <div class="grafico-card full">
                    <h3>Pagos vs Nómina</h3>
                    <canvas id="graficoComparativo"></canvas>
                </div>

            </div>

            <!-- HISTORIAL -->
            <div class="tabla-box">

                <h3>Últimos Movimientos</h3>

                <table>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Descripción</th>
                            <th>Monto</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php while ($row = mysqli_fetch_assoc($historial)) { ?>
                            <tr>
                                <td><?= $row['fecha']; ?></td>
                                <td><?= $row['tipo_movimiento']; ?></td>
                                <td><?= $row['descripcion']; ?></td>
                                <td>$<?= number_format($row['monto']); ?></td>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>

            </div>

        </main>
    </div>

    <!-- CHART -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        /* DARK MODE */
        function toggleDark() {
            document.body.classList.toggle("dark");
        }

        /* DATOS */
        const meses = <?= json_encode($meses); ?>;
        const pagos = <?= json_encode($totales); ?>;
        const nomina = <?= json_encode($totalesNomina); ?>;

        /* PAGOS */
        new Chart(graficoPagos, {
            type: 'bar',
            data: {
                labels: meses,
                datasets: [{
                    label: 'Ingresos',
                    data: pagos,
                    backgroundColor: 'rgba(70,129,137,0.9)',
                    borderRadius: 10,
                    barThickness: 50
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#031926',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        padding: 12,
                        cornerRadius: 8
                    }
                },

                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 12
                            }
                        }
                    },
                    y: {
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        },
                        ticks: {
                            callback: value => '$' + value,
                            font: {
                                size: 12
                            }
                        }
                    }
                }
            }
        });

        /* DONUT */
        new Chart(graficoGeneral, {
            type: 'doughnut',
            data: {
                labels: ['Estudiantes', 'Empleados'],
                datasets: [{
                    data: [<?= $total_estudiantes ?>, <?= $total_empleados ?>],
                    backgroundColor: ['#468189', '#77ACA2'],
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            font: {
                                size: 12
                            }
                        }
                    }
                }
            }
        });

        /* COMPARATIVO */
        new Chart(graficoComparativo, {
        type: 'line',
        data: {
            labels: meses,
            datasets: [{
                    label: 'Pagos',
                    data: pagos,
                    borderColor: '#468189',
                    backgroundColor: 'rgba(70,129,137,0.1)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4
                },
                {
                    label: 'Nómina',
                    data: nomina,
                    borderColor: '#77ACA2',
                    backgroundColor: 'rgba(119,172,162,0.1)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,

            plugins: {
                legend: {
                    position: 'top'
                }
            },

            scales: {
                y: {
                    ticks: {
                        callback: value => '$' + value
                    }
                }
            }
        }
        });
    
    </script>

</body>

</html>
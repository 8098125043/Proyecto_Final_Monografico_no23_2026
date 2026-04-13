<?php
require('./fpdf186/fpdf.php');
include("conexion.php");


$where = "WHERE 1=1";

if(!empty($_GET['tipo'])){
    $tipo = $_GET['tipo'];
    $where .= " AND tipo_movimiento = '$tipo'";
}

if(!empty($_GET['fecha'])){
    $fecha = $_GET['fecha'];
    $where .= " AND DATE(fecha) = '$fecha'";
}

$query = "SELECT * FROM historial_movimientos $where ORDER BY fecha DESC";
$resultado = mysqli_query($conn, $query);



$pdf = new FPDF();
$pdf->AddPage();


$pdf->SetFont('Arial','B',16);
$pdf->Cell(190,10,'Historial del Sistema',0,1,'C');

$pdf->Ln(5);


$pdf->SetFont('Arial','B',10);

$pdf->Cell(40,10,'Fecha',1);
$pdf->Cell(40,10,'Tipo',1);
$pdf->Cell(70,10,'Descripcion',1);
$pdf->Cell(40,10,'Monto',1);

$pdf->Ln();

$pdf->SetFont('Arial','',9);

while($row = mysqli_fetch_assoc($resultado)){

    $pdf->Cell(40,10,$row['fecha'],1);
    $pdf->Cell(40,10,$row['tipo_movimiento'],1);
    $pdf->Cell(70,10,substr($row['descripcion'],0,40),1);
    $pdf->Cell(40,10,'$'.$row['monto'],1);

    $pdf->Ln();
}


$pdf->Output("D", "historial.pdf");
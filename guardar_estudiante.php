<?php
include("conexion.php");

/* =========================
CAPTURAR DATOS
========================= */
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$cedula = $_POST['cedula'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$curso = $_POST['curso'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];

/* =========================
VALIDAR CÉDULA (SOLO NÚMEROS)
========================= */
if(!is_numeric($cedula)){
    die("Error: La cédula solo debe contener números");
}

/* =========================
VALIDAR DUPLICADO
========================= */
$check = mysqli_query($conn, "SELECT * FROM estudiantes WHERE cedula='$cedula'");
if(mysqli_num_rows($check) > 0){
    die("Error: Esta cédula ya está registrada");
}

/* =========================
GENERAR ID INSTITUCIONAL
(Ej: 26001)
========================= */
$year = date("y");

$query = mysqli_query($conn, "SELECT MAX(id_institucional) as max_id FROM estudiantes");
$row = mysqli_fetch_assoc($query);

if($row['max_id']){
    $num = substr($row['max_id'], 2);
    $nuevo = str_pad($num + 1, 3, "0", STR_PAD_LEFT);
}else{
    $nuevo = "001";
}

$id_institucional = $year . $nuevo;

/* =========================
INSERTAR ESTUDIANTE
========================= */
$sql = "INSERT INTO estudiantes(
    id_institucional,
    nombre,
    apellido,
    cedula,
    fecha_nacimiento,
    curso,
    telefono,
    correo
) VALUES(
    '$id_institucional',
    '$nombre',
    '$apellido',
    '$cedula',
    '$fecha_nacimiento',
    '$curso',
    '$telefono',
    '$correo'
)";

$result = mysqli_query($conn, $sql);

/* =========================
VERIFICAR
========================= */
if($result){

    // HISTORIAL
    mysqli_query($conn, "
        INSERT INTO historial_movimientos(tipo_movimiento, descripcion, monto)
        VALUES('Registro','Nuevo estudiante registrado: $nombre $apellido',0)
    ");

    header("Location: estudiantes.php?success=1");
    exit();

}else{
    echo "Error al guardar: " . mysqli_error($conn);
}
?>
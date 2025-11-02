<?php
require_once __DIR__ . '/../../config/database.php';
if (!isset($_SESSION['id_usuario'])) {
    redirigir('/mi_sistema/index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_consulta = $_POST['id_consulta'] ?? null;
    $dni = trim($_POST['dni']);
    $nombres = trim($_POST['nombres']);
    $ape_paterno = trim($_POST['ape_paterno']);
    $ape_materno = trim($_POST['ape_materno']);
    $direccion = trim($_POST['direccion']);
    $distrito = trim($_POST['distrito']);
    $provincia = trim($_POST['provincia']);
    $departamento = trim($_POST['departamento']);
    $ubigeo = trim($_POST['ubigeo']);
    $id_usuario = $_SESSION['id_usuario'];

    if (!empty($id_consulta)) { // Actualizar
        $stmt = $conexion->prepare("UPDATE consultas_dni SET dni = ?, nombres = ?, ape_paterno = ?, ape_materno = ?, direccion = ?, distrito = ?, provincia = ?, departamento = ?, ubigeo = ? WHERE id_consulta = ?");
        $stmt->bind_param("sssssssssi", $dni, $nombres, $ape_paterno, $ape_materno, $direccion, $distrito, $provincia, $departamento, $ubigeo, $id_consulta);
    } else { // Crear
        $stmt = $conexion->prepare("INSERT INTO consultas_dni (dni, nombres, ape_paterno, ape_materno, direccion, distrito, provincia, departamento, ubigeo, id_usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssssi", $dni, $nombres, $ape_paterno, $ape_materno, $direccion, $distrito, $provincia, $departamento, $ubigeo, $id_usuario);
    }
    $stmt->execute();
    $stmt->close();
}
redirigir('index.php');
?>

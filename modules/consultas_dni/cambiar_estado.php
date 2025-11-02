<?php
require_once __DIR__ . '/../../config/database.php';
if (!isset($_SESSION['id_usuario'])) {
    redirigir('/mi_sistema/index.php');
}

if (isset($_GET['id']) && isset($_GET['estado'])) {
    $id_consulta = $_GET['id'];
    $estado = $_GET['estado'];

    $stmt = $conexion->prepare("UPDATE consultas_dni SET activo = ? WHERE id_consulta = ?");
    $stmt->bind_param("ii", $estado, $id_consulta);
    $stmt->execute();
    $stmt->close();
}
redirigir('index.php');
?>

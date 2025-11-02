<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/header.php';
if (!isset($_SESSION['id_usuario'])) {
    echo "<div class='alert alert-danger'>No tienes permiso para acceder.</div>";
    require_once __DIR__ . '/../../includes/footer.php';
    exit;
}

// Ver inactivos
$ver_inactivos = isset($_GET['ver']) && $_GET['ver'] == 'inactivos';
$filtro_activo = $ver_inactivos ? 0 : 1;
$stmt = $conexion->prepare("SELECT * FROM consultas_dni WHERE activo = ? ORDER BY fecha_consulta DESC");
$stmt->bind_param("i", $filtro_activo);
$stmt->execute();
$resultado = $stmt->get_result();
?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="m-0"><i class="fas fa-id-card"></i> Consultas DNI</h2>
        <div>
            <?php if ($ver_inactivos): ?>
                <a href="index.php" class="btn btn-info">Ver Activos</a>
            <?php else: ?>
                <a href="index.php?ver=inactivos" class="btn btn-secondary">Ver Inactivos</a>
            <?php endif; ?>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#consultaModal">
                <i class="fas fa-plus"></i> Nueva Consulta
            </button>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>DNI</th>
                    <th>Nombres</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Dirección</th>
                    <th>Fecha Consulta</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while($consulta = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($consulta['dni']); ?></td>
                    <td><?php echo htmlspecialchars($consulta['nombres']); ?></td>
                    <td><?php echo htmlspecialchars($consulta['ape_paterno']); ?></td>
                    <td><?php echo htmlspecialchars($consulta['ape_materno']); ?></td>
                    <td><?php echo htmlspecialchars($consulta['direccion']); ?></td>
                    <td><?php echo htmlspecialchars($consulta['fecha_consulta']); ?></td>
                    <td>
                        <span class="badge bg-<?php echo $consulta['activo'] ? 'success' : 'danger'; ?>">
                            <?php echo $consulta['activo'] ? 'Activo' : 'Inactivo'; ?>
                        </span>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-warning edit-consulta-btn"
                                data-bs-toggle="modal" data-bs-target="#consultaModal"
                                data-id="<?php echo $consulta['id_consulta']; ?>"
                                data-dni="<?php echo htmlspecialchars($consulta['dni']); ?>"
                                data-nombres="<?php echo htmlspecialchars($consulta['nombres']); ?>"
                                data-ape_paterno="<?php echo htmlspecialchars($consulta['ape_paterno']); ?>"
                                data-ape_materno="<?php echo htmlspecialchars($consulta['ape_materno']); ?>"
                                data-direccion="<?php echo htmlspecialchars($consulta['direccion']); ?>">
                            <i class="fas fa-edit"></i>
                        </button>
                        <?php if ($consulta['activo']): ?>
                            <a href="cambiar_estado.php?id=<?php echo $consulta['id_consulta']; ?>&estado=0" class="btn btn-sm btn-danger" title="Desactivar"><i class="fas fa-ban"></i></a>
                        <?php else: ?>
                            <a href="cambiar_estado.php?id=<?php echo $consulta['id_consulta']; ?>&estado=1" class="btn btn-sm btn-success" title="Activar"><i class="fas fa-check"></i></a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="consultaModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="consultaModalLabel">Nueva Consulta DNI</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="guardar.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id_consulta" id="id_consulta">
                    <div class="mb-3">
                        <label for="dni" class="form-label">DNI</label>
                        <input type="text" class="form-control" name="dni" id="dni" required maxlength="8" pattern="[0-9]{8}">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombres" class="form-label">Nombres</label>
                            <input type="text" class="form-control" name="nombres" id="nombres" readonly>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="ape_paterno" class="form-label">Apellido Paterno</label>
                            <input type="text" class="form-control" name="ape_paterno" id="ape_paterno" readonly>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="ape_materno" class="form-label">Apellido Materno</label>
                            <input type="text" class="form-control" name="ape_materno" id="ape_materno" readonly>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <textarea class="form-control" name="direccion" id="direccion" rows="2" readonly></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="distrito" class="form-label">Distrito</label>
                            <input type="text" class="form-control" name="distrito" id="distrito" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="provincia" class="form-label">Provincia</label>
                            <input type="text" class="form-control" name="provincia" id="provincia" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="departamento" class="form-label">Departamento</label>
                            <input type="text" class="form-control" name="departamento" id="departamento" readonly>
                        </div>
                    </div>
                    <input type="hidden" name="ubigeo" id="ubigeo">
                    <button type="button" id="consultarBtn" class="btn btn-info">Consultar DNI</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
echo '<script src="/mi_sistema/assets/js/consultas_dni.js"></script>';
require_once __DIR__ . '/../../includes/footer.php';
?>

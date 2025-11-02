<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/header.php';
if (!isset($_SESSION['id_usuario'])) {
    echo "<div class='alert alert-danger'>No tienes permiso para acceder.</div>";
    require_once __DIR__ . '/../../includes/footer.php';
    exit;
}
?>
<div class="card">
    <div class="card-header">
        <h2 class="m-0"><i class="fas fa-headset"></i> Soporte Técnico con Gemini AI</h2>
    </div>
    <div class="card-body">
        <div id="chat-container" style="height: 400px; overflow-y: auto; border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
            <!-- Mensajes del chat aparecerán aquí -->
        </div>
        <div class="input-group">
            <input type="text" id="message-input" class="form-control" placeholder="Escribe tu mensaje...">
            <button class="btn btn-primary" id="send-button">Enviar</button>
        </div>
    </div>
</div>

<?php
echo '<script src="/mi_sistema/assets/js/soporte_tecnico.js"></script>';
require_once __DIR__ . '/../../includes/footer.php';
?>

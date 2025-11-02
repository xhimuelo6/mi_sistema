</main> <footer class="bg-dark text-white text-center p-3 mt-4">
    <p>&copy; <?php echo date('Y'); ?> - Sistema de Gestión - Todos los derechos reservados.</p>
</footer>

<!-- Botón flotante de Consultas DNI -->
<div id="dni-flotante" class="btn btn-primary position-fixed" style="bottom: 20px; right: 20px; z-index: 1050; border-radius: 50%; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;" data-bs-toggle="modal" data-bs-target="#dniModalFlotante">
    <i class="fas fa-id-card"></i>
</div>

<!-- Modal flotante para Consultas DNI -->
<div class="modal fade" id="dniModalFlotante" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Consulta DNI Rápida</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="/mi_sistema/modules/consultas_dni/guardar.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="dniFlotante" class="form-label">DNI</label>
                        <input type="text" class="form-control" name="dni" id="dniFlotante" required maxlength="8" pattern="[0-9]{8}">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombresFlotante" class="form-label">Nombres</label>
                            <input type="text" class="form-control" name="nombres" id="nombresFlotante" readonly>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="ape_paternoFlotante" class="form-label">Apellido Paterno</label>
                            <input type="text" class="form-control" name="ape_paterno" id="ape_paternoFlotante" readonly>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="ape_maternoFlotante" class="form-label">Apellido Materno</label>
                            <input type="text" class="form-control" name="ape_materno" id="ape_maternoFlotante" readonly>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="direccionFlotante" class="form-label">Dirección</label>
                        <textarea class="form-control" name="direccion" id="direccionFlotante" rows="2" readonly></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="distritoFlotante" class="form-label">Distrito</label>
                            <input type="text" class="form-control" name="distrito" id="distritoFlotante" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="provinciaFlotante" class="form-label">Provincia</label>
                            <input type="text" class="form-control" name="provincia" id="provinciaFlotante" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="departamentoFlotante" class="form-label">Departamento</label>
                            <input type="text" class="form-control" name="departamento" id="departamentoFlotante" readonly>
                        </div>
                    </div>
                    <input type="hidden" name="ubigeo" id="ubigeoFlotante">
                    <button type="button" id="consultarBtnFlotante" class="btn btn-info">Consultar DNI</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Botón flotante de Soporte Técnico -->
<div id="soporte-flotante" class="btn btn-success position-fixed" style="bottom: 90px; right: 20px; z-index: 1050; border-radius: 50%; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;" data-bs-toggle="modal" data-bs-target="#soporteModalFlotante">
    <i class="fas fa-headset"></i>
</div>

<!-- Modal flotante para Soporte Técnico -->
<div class="modal fade" id="soporteModalFlotante" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Soporte Técnico con Gemini AI</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="chat-container-flotante" style="height: 300px; overflow-y: auto; border: 1px solid #070606ff; padding: 10px; margin-bottom: 10px;">
                    <!-- Mensajes del chat aparecerán aquí -->
                </div>
                <div class="input-group">
                    <input type="text" id="message-input-flotante" class="form-control" placeholder="Escribe tu mensaje...">
                    <button class="btn btn-primary" id="send-button-flotante">Enviar</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<script src="/mi_sistema/assets/js/scripts.js"></script>

<!-- Scripts para flotantes -->
<script src="/mi_sistema/assets/js/consultas_dni_flotante.js"></script>
<script src="/mi_sistema/assets/js/soporte_tecnico_flotante.js"></script>
</body>
</html>

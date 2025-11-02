document.addEventListener('DOMContentLoaded', function() {
    const consultaModal = document.getElementById('consultaModal');
    if (consultaModal) {
        consultaModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const modalTitle = consultaModal.querySelector('.modal-title');
            const form = consultaModal.querySelector('form');
            form.reset();

            document.getElementById('id_consulta').value = '';
            modalTitle.textContent = 'Nueva Consulta DNI';

            if (button.classList.contains('edit-consulta-btn')) {
                modalTitle.textContent = 'Editar Consulta DNI';
                document.getElementById('id_consulta').value = button.dataset.id;
                document.getElementById('dni').value = button.dataset.dni;
                document.getElementById('nombres').value = button.dataset.nombres;
                document.getElementById('ape_paterno').value = button.dataset.ape_paterno;
                document.getElementById('ape_materno').value = button.dataset.ape_materno;
                document.getElementById('direccion').value = button.dataset.direccion;
            }
        });
    }

    // Consultar DNI
    const consultarBtn = document.getElementById('consultarBtn');
    if (consultarBtn) {
        consultarBtn.addEventListener('click', function() {
            const dni = document.getElementById('dni').value;
            if (dni.length !== 8 || !/^\d+$/.test(dni)) {
                alert('Ingrese un DNI válido de 8 dígitos.');
                return;
            }

            consultarBtn.disabled = true;
            consultarBtn.textContent = 'Consultando...';

            fetch('https://miapi.cloud/v1/dni/' + dni, {
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyX2lkIjo0MDIsImV4cCI6MTc2MTU0NDc5M30.jsb9sIOxngRU3q9WtaGpQd893VAvyQmYGoh7aWBtfiQ'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('nombres').value = data.datos.nombres;
                    document.getElementById('ape_paterno').value = data.datos.ape_paterno;
                    document.getElementById('ape_materno').value = data.datos.ape_materno;
                    document.getElementById('direccion').value = data.datos.domiciliado.direccion;
                    document.getElementById('distrito').value = data.datos.domiciliado.distrito;
                    document.getElementById('provincia').value = data.datos.domiciliado.provincia;
                    document.getElementById('departamento').value = data.datos.domiciliado.departamento;
                    document.getElementById('ubigeo').value = data.datos.domiciliado.ubigeo;
                } else {
                    alert('Error al consultar DNI: ' + (data.message || 'Desconocido'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error de conexión al consultar DNI.');
            })
            .finally(() => {
                consultarBtn.disabled = false;
                consultarBtn.textContent = 'Consultar DNI';
            });
        });
    }
});

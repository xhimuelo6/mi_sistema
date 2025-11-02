document.addEventListener('DOMContentLoaded', function() {
    const consultarBtnFlotante = document.getElementById('consultarBtnFlotante');
    if (consultarBtnFlotante) {
        consultarBtnFlotante.addEventListener('click', function() {
            const dni = document.getElementById('dniFlotante').value;
            if (dni.length !== 8 || !/^\d+$/.test(dni)) {
                alert('Ingrese un DNI válido de 8 dígitos.');
                return;
            }

            consultarBtnFlotante.disabled = true;
            consultarBtnFlotante.textContent = 'Consultando...';

            fetch('https://miapi.cloud/v1/dni/' + dni, {
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyX2lkIjo0MDIsImV4cCI6MTc2MTU0NDc5M30.jsb9sIOxngRU3q9WtaGpQd893VAvyQmYGoh7aWBtfiQ'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('nombresFlotante').value = data.datos.nombres;
                    document.getElementById('ape_paternoFlotante').value = data.datos.ape_paterno;
                    document.getElementById('ape_maternoFlotante').value = data.datos.ape_materno;
                    document.getElementById('direccionFlotante').value = data.datos.domiciliado.direccion;
                    document.getElementById('distritoFlotante').value = data.datos.domiciliado.distrito;
                    document.getElementById('provinciaFlotante').value = data.datos.domiciliado.provincia;
                    document.getElementById('departamentoFlotante').value = data.datos.domiciliado.departamento;
                } else {
                    alert('Error al consultar DNI: ' + (data.message || 'Desconocido'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error de conexión al consultar DNI.');
            })
            .finally(() => {
                consultarBtnFlotante.disabled = false;
                consultarBtnFlotante.textContent = 'Consultar DNI';
            });
        });
    }
});

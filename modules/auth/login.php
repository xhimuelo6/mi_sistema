<?php
require_once __DIR__ . '/../../config/database.php';

if (isset($_SESSION['id_usuario'])) {
    redirigir('/mi_sistema/index.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = 'Por favor, completa ambos campos.';
    } else {
        // MODIFICADO: Se añade 'moneda' a la consulta SQL
        $stmt = $conexion->prepare("SELECT id_usuario, nombre_completo, password, id_rol, moneda FROM usuarios WHERE username = ? AND activo = 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc();
            
            if (password_verify($password, $usuario['password'])) {
                // Iniciar sesión
                $_SESSION['id_usuario'] = $usuario['id_usuario'];
                $_SESSION['nombre_usuario'] = $usuario['nombre_completo'];
                $_SESSION['id_rol'] = $usuario['id_rol'];
                
                // NUEVO: Guardar la moneda del usuario en la sesión
                $_SESSION['moneda_usuario'] = $usuario['moneda'];

                // Cargar los permisos del rol en la sesión
                $stmt_permisos = $conexion->prepare("SELECT p.nombre_permiso FROM rol_permiso rp JOIN permisos p ON rp.id_permiso = p.id_permiso WHERE rp.id_rol = ?");
                $stmt_permisos->bind_param("i", $usuario['id_rol']);
                $stmt_permisos->execute();
                $resultado_permisos = $stmt_permisos->get_result();
                $permisos = [];
                while ($fila = $resultado_permisos->fetch_assoc()) {
                    $permisos[] = $fila['nombre_permiso'];
                }
                $_SESSION['permisos'] = $permisos;
                $stmt_permisos->close();
                
                redirigir('/mi_sistema/index.php');

            } else {
                $error = 'Usuario o contraseña incorrectos.';
            }
        } else {
            $error = 'Usuario o contraseña incorrectos.';
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { display: flex; align-items: center; justify-content: center; height: 100vh; background-color: #f8f9fa; }
        .login-card { width: 100%; max-width: 400px; }
    </style>
</head>
<body>
    <div class="card login-card shadow">
        <div class="card-body">
            <h2 class="text-center mb-4">Iniciar Sesión</h2>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <form action="login.php" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Usuario</label>
                    <input type="text" class="form-control" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Ingresar</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
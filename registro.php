<?php
session_start();
include 'db.php';

$error_msg = "";

if (isset($_POST['registrar'])) {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $pass = $_POST['password'];
    $confirm_pass = $_POST['confirm_password'];

    // 1. Validar que las contraseñas coincidan
    if ($pass !== $confirm_pass) {
        $error_msg = "Las contraseñas no coinciden.";
    } else {
        // 2. Comprobar si el email ya existe
        $checkEmail = mysqli_query($conexion, "SELECT id FROM usuarios WHERE email = '$email'");
        
        if (mysqli_num_rows($checkEmail) > 0) {
            $error_msg = "Este correo ya está registrado.";
        } else {
            // 3. Encriptar contraseña y guardar
            $pass_encriptada = password_hash($pass, PASSWORD_BCRYPT);
            
            // Por defecto, los nuevos registros son rol 'cliente'
            $sql = "INSERT INTO usuarios (nombre, email, password, rol) 
                    VALUES ('$nombre', '$email', '$pass_encriptada', 'cliente')";

            if (mysqli_query($conexion, $sql)) {
                // Redirigir al login con mensaje de éxito
                header("Location: index.php?registrado=1");
                exit();
            } else {
                $error_msg = "Error al registrar: " . mysqli_error($conexion);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - La Lupe</title>
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <div class="auth-pantalla">
        
        <div class="auth-caja">
            <div class="login-logo" style="font-size: 2.5rem; margin-bottom: 10px;">
                <i class="fas fa-user-plus" style="color: #00bcd4;"></i>
                <h1 style="display: inline; font-size: 2rem;">Crear <span>Cuenta</span></h1>
            </div>

            <?php if ($error_msg): ?>
                <div style="background: #ffebee; color: #c62828; padding: 10px; border-radius: 8px; margin-bottom: 15px;">
                    <i class="fas fa-exclamation-triangle"></i> <?php echo $error_msg; ?>
                </div>
            <?php endif; ?>

            <form action="registro.php" method="POST">
                <div style="margin-bottom: 10px;">
                    <input type="text" name="nombre" placeholder="Nombre completo" required>
                </div>

                <div style="margin-bottom: 10px;">
                    <input type="email" name="email" placeholder="Correo electrónico" required>
                </div>

                <div style="margin-bottom: 10px;">
                    <input type="password" name="password" placeholder="Contraseña" required>
                </div>

                <div style="margin-bottom: 20px;">
                    <input type="password" name="confirm_password" placeholder="Repite contraseña" required>
                </div>

                <button type="submit" name="registrar" class="btn-colorido">Registrarme</button>
            </form>

            <div style="margin-top: 25px; border-top: 1px solid #eee; padding-top: 20px;">
                <p>¿Ya tienes cuenta? <a href="index.php" class="link-cambio">Inicia sesión</a></p>
            </div>
        </div>
    </div>

</body>
</html>
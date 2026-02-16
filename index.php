<?php
session_start();
include 'db.php';

// Si el usuario ya está logueado, lo mandamos al menú directamente
if (isset($_SESSION['usuario_id'])) {
    header("Location: menu.php");
    exit();
}

$error_msg = "";

// Lógica de inicio de sesión
if (isset($_POST['entrar'])) {
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $res = mysqli_query($conexion, $sql);

    if ($res && mysqli_num_rows($res) > 0) {
        $usuario = mysqli_fetch_assoc($res);
        
        // Verificamos la contraseña (asumiendo que usaste password_hash en el registro)
        if (password_verify($password, $usuario['password'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['rol'] = $usuario['rol']; // 'admin' o 'cliente'

            header("Location: menu.php?login=success");
            exit();
        } else {
            $error_msg = "Contraseña incorrecta.";
        }
    } else {
        $error_msg = "El correo electrónico no está registrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - La Lupe</title>
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

   <div class="auth-pantalla">
    <div class="auth-caja">
        <div class="login-logo">
            <i class="fas fa-pepper-hot"></i>
            <h1>La <span>Lupe</span></h1>
        </div>

        <?php if ($error_msg): ?>
            <div class="alerta alerta-error">
                <i class="fas fa-times-circle"></i> <?php echo $error_msg; ?>
            </div>
        <?php endif; ?>

        <form action="index.php" method="POST">
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit" name="entrar" class="btn-colorido">Entrar</button>
        </form>

        <div class="auth-links">
            <p>¿No tienes cuenta? <a href="registro.php" class="link-cambio">Regístrate</a></p>
            <span class="separador">o</span>
            <a href="menu.php" class="link-invitado">Ver el menú como invitado</a>
        </div>
    </div>
</div>

</body>
</html>
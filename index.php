<?php
// 1. Incluimos la conexión que creamos antes
include 'db.php';
session_start(); // Iniciamos sesión para recordar al usuario

$error = ""; // Variable para mensajes de error

// 2. Lógica al pulsar el botón de "Entrar"
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $password = $_POST['password'];

    // Buscamos al usuario en la tabla que creaste
    $sql = "SELECT id, nombre, password, rol FROM usuarios WHERE email = '$email'";
    $resultado = mysqli_query($conexion, $sql);
    
    if ($usuario = mysqli_fetch_assoc($resultado)) {
        // Verificamos la contraseña (asumiendo que usas password_hash en el futuro)
        // Por ahora, para probar, compararemos texto plano, pero cámbialo a password_verify después
        if (password_verify($password, $usuario['password'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['rol'] = $usuario['rol'];

            // Si es admin, va a la gestión de platos, si no, al menú
            header("Location: menu.php"); 
            exit();
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "El correo no está registrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - La Lupe</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body class="login-body"> <div class="login-card">
        <img src="img/logo.png" alt="La Lupe" style="width: 80px; margin-bottom: 10px;">
        <h2>Iniciar Sesión</h2>
        
        <form action="index.php" method="POST">
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Entrar</button>
        </form>

        <div class="links">
            <p>¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
            <hr style="border: 0; border-top: 1px solid #eee; margin: 15px 0;">
            <p><a href="menu.php" class="invitado">Entrar como invitado</a></p>
        </div>
    </div>

</body>
</html>
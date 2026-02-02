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
    $sql = "SELECT id_usuario, nombre, password, rol FROM usuarios WHERE email = '$email'";
    $resultado = mysqli_query($conexion, $sql);
    
    if ($usuario = mysqli_fetch_assoc($resultado)) {
        // Verificamos la contraseña (asumiendo que usas password_hash en el futuro)
        // Por ahora, para probar, compararemos texto plano, pero cámbialo a password_verify después
        if (password_verify($password, $usuario['password'])) {
            $_SESSION['usuario_id'] = $usuario['id_usuario'];
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
    <title>Login - Web La Lupe</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="login-container">
        <h1>Bienvenido a La Lupe</h1>
        
        <?php if($error != ""): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="index.php" method="POST">
            <label>Email:</label>
            <input type="email" name="email" required>
            
            <label>Contraseña:</label>
            <input type="password" name="password" required>
            
            <button type="submit">Entrar</button>
        </form>
        
        <p>¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
    </div>
</body>
</html>
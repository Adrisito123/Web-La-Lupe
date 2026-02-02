<?php
include 'db.php';
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $password = $_POST['password'];
    
    // Encriptamos la contraseña para cumplir con los estándares de seguridad de DAW
    $password_encriptada = password_hash($password, PASSWORD_BCRYPT);

    // Verificamos si el email ya existe
    $checkEmail = "SELECT * FROM usuarios WHERE email = '$email'";
    $resultadoCheck = mysqli_query($conexion, $checkEmail);

    if (mysqli_num_rows($resultadoCheck) > 0) {
        $mensaje = "El correo ya está registrado.";
    } else {
        // Insertamos el nuevo usuario (por defecto rol 'cliente')
        $sql = "INSERT INTO usuarios (nombre, email, password, rol) VALUES ('$nombre', '$email', '$password_encriptada', 'cliente')";
        
        if (mysqli_query($conexion, $sql)) {
            $mensaje = "¡Registro con éxito! Ya puedes <a href='index.php'>iniciar sesión</a>.";
        } else {
            $mensaje = "Error al registrar: " . mysqli_error($conexion);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - La Lupe</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body class="register-body">

    <div class="register-card">
        <h2>Crea tu cuenta</h2>
        <p>Únete a la familia de La Lupe</p>
        
        <form action="registro.php" method="POST">
            <input type="text" name="nombre" placeholder="Nombre completo" required>
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <input type="password" name="confirm_password" placeholder="Repite la contraseña" required>
            
            <p class="terminos">Al registrarte, aceptas nuestros términos y condiciones.</p>
            
            <button type="submit">Registrarme ahora</button>
        </form>

        <div class="links">
            <p>¿Ya tienes cuenta? <a href="index.php">Inicia sesión</a></p>
        </div>
    </div>

</body>
</html>
<?php 
session_start(); 
include 'db.php'; 

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_SESSION['usuario_id'];
$query = mysqli_query($conexion, "SELECT * FROM usuarios WHERE id = '$id'");
$user = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Perfil | La Lupe</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <main class="contenedor-perfil">
        
        <div class="barra-superior">
            <a href="index.php" class="btn-regresar">← Volver a la web</a>
        </div>

        <h1 class="titulo">Mi <span>Perfil</span></h1>

        <div class="grid-perfil">
            <section class="tarjeta-datos">
                <h3>Datos Personales</h3>
                <p><strong>Nombre:</strong> <?php echo $user['nombre']; ?></p>
                <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
            </section>

            <section class="tarjeta-puntos">
                <h3>Mis Puntos Lupe</h3>
                <div class="puntos-actuales">
                    <span class="numero"><?php echo $user['puntos'] ?? 0; ?></span>
                    <span class="texto">puntos acumulados</span>
                </div>

                <div class="aviso-mantenimiento">
                    <p>Sistema de canje en mantenimiento</p>
                    <small>Próximamente podrás canjear tus puntos por premios.</small>
                </div>
            </section>
        </div>

        <div class="acciones-finales">
            <a href="logout.php" class="btn-salir">Cerrar Sesión</a>
        </div>
    </main>
</body>
</html>
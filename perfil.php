<?php 
session_start(); 
include 'db.php'; 
$nombreUsuario = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : "Invitado";


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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <header class="cabecera-principal">
        <nav class="barra-navegacion contenedor">
            <div class="bloque-izquierdo">
                <a href="menu.php" class="logotipo">LA<span>LUPE</span></a>
                <ul class="lista-enlaces">
                    <li><a href="menu.php">Inicio</a></li>
                    <li><a href="carta.php">Ver Carta</a></li>
                </ul>
            </div>
            <div class="bloque-derecho">
                <a href="perfil.php" class="enlace-cuenta">
                    <i class="fas fa-user-circle"></i>
                    <span><?php echo $nombreUsuario; ?></span>
                </a>
                <a href="carrito.php" class="boton-carrito">
                    <i class="fas fa-shopping-basket"></i>
                </a>
                <a href="logout.php" class="boton-salir">Cerrar Sesión</a>
            </div>
        </nav>
    </header>
    <main class="contenedor-perfil">
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
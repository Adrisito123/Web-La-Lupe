<?php
session_start();
include 'db.php'; 

$nombreUsuario = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : "Invitado";
$esAdmin = (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin');

// Obtener todas las categorías distintas que tienen platos disponibles
$consulta_cats = "SELECT DISTINCT categoria FROM platos WHERE disponible = 1";
$res_cats = mysqli_query($conexion, $consulta_cats);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Lupe | Carta por Secciones</title>
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <header class="cabecera-principal">
        <nav class="barra-navegacion contenedor">
            <div class="bloque-izquierdo">
                <a href="menu.php" class="logotipo">LA<span>LUPE</span></a>
                <ul class="lista-enlaces">
                    <li><a href="carta.php">Ver Carta</a></li>
                    <?php if ($esAdmin): ?>
                        <li><a href="admin/panel.php" class="enlace-admin">Panel Control</a></li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="bloque-derecho">
                <a href="mi_cuenta.php" class="enlace-cuenta">
                    <i class="fas fa-user-circle"></i>
                    <span><?php echo $nombreUsuario; ?></span>
                </a>
                <a href="carrito.php" class="boton-carrito">
                    <i class="fas fa-shopping-basket"></i>
                    <span class="numero-carrito">0</span>
                </a>
                <a href="logout.php" class="boton-salir">Cerrar Sesión</a>
            </div>
        </nav>
    </header>

    <main class="seccion-platos">
        <div class="contenedor">
            <h2 class="titulo-seccion">Nuestra <span>Carta</span></h2>

            <?php 
            // Bucle para cada categoría
            while($cat = mysqli_fetch_assoc($res_cats)): 
                $nombre_cat = $cat['categoria'];
            ?>
                <h3 class="titulo-categoria"><?php echo strtoupper($nombre_cat); ?></h3>
                
                <div class="cuadricula-platos">
                    <?php
                    // Consultar platos solo de esta categoría
                    $consulta_platos = "SELECT * FROM platos WHERE disponible = 1 AND categoria = '$nombre_cat'";
                    $res_platos = mysqli_query($conexion, $consulta_platos);
                    while($plato = mysqli_fetch_assoc($res_platos)):
                    ?>
                    <div class="tarjeta-plato">
                        <div class="imagen-contenedor">
                            <img src="img/platos/<?php echo $plato['imagen']; ?>" onerror="this.src='img/default.jpg'">
                        </div>
                        <div class="texto-plato">
                            <h3><?php echo $plato['nombre']; ?></h3>
                            <p><?php echo substr($plato['descripcion'], 0, 60); ?>...</p>
                            <div class="pie-tarjeta">
                                <span class="precio"><?php echo $plato['precio']; ?>€</span>
                                <button class="boton-añadir">+</button>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
                <hr class="separador">
            <?php endwhile; ?>
        </div>
    </main>

    <footer class="pie-principal">
        <div class="contenedor pie-contenido">
            <div class="columna">
                <h2 class="logotipo">LA<span>LUPE</span></h2>
                <p>Tu restaurante de confianza.</p>
            </div>
            <div class="columna">
                <h3>Contacto</h3>
                <p>Calle Falsa 123</p>
                <p>Tel: 600 000 000</p>
            </div>
        </div>
        <div class="pie-final">
            <p>&copy; 2026 La Lupe - Todos los derechos reservados</p>
        </div>
    </footer>

</body>
</html>
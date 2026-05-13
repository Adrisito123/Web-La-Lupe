<?php
session_start();
include 'db.php'; 

$nombreUsuario = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : "Invitado";
$esAdmin = (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Lupe | Inicio</title>
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header class="cabecera-principal">
        <nav class="barra-navegacion contenedor">
            <div class="bloque-izquierdo">
                <a href="menu.php" class="logotipo">LA<span>LUPE</span></a>
                <ul class="lista-enlaces">
                    <li><a href="menu.php">Inicio</a></li>
                    <li><a href="carta.php">Ver Carta</a></li>
                    <?php if ($esAdmin): ?>
                        <li><a href="admin/panel.php" class="enlace-admin">Panel Control</a></li>
                    <?php endif; ?>
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

   <section class="seccion-gris">
        <div class="contenedor">
            <h2 class="titulo-seccion">Los más <span>Pedidos</span></h2>
            <div class="cuadricula-tendencias">
                <?php
                $consulta_top = "SELECT * FROM platos WHERE disponible = 1 LIMIT 4";
                $res_top = mysqli_query($conexion, $consulta_top);
                
                while($item = mysqli_fetch_assoc($res_top)):
                ?>
                <article class="tarjeta-pequeña">
                    <img src="<?php echo $item['imagen']; ?>" alt="<?php echo $item['nombre']; ?>">
                    <h4><?php echo $item['nombre']; ?></h4>
                </article>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <main class="seccion-platos">
        <div class="contenedor">
            <h2 class="titulo-seccion">Nuestra <span>Selección</span></h2>
            <div class="cuadricula-platos">
                <?php
                $consulta_platos = "SELECT * FROM platos WHERE disponible = 1 LIMIT 5";
                $res_platos = mysqli_query($conexion, $consulta_platos);
                while($plato = mysqli_fetch_assoc($res_platos)):
                ?>
                <div class="tarjeta-plato">
                    <div class="imagen-contenedor">
                        <img src="<?php echo $plato['imagen']; ?>">
                    </div>
                    <div class="texto-plato">
                        <h3><?php echo $plato['nombre']; ?></h3>
                        <p><?php echo substr($plato['descripcion'], 0, 60); ?>...</p>
                        <div class="pie-tarjeta">
                            <span class="precio"><?php echo $plato['precio']; ?>€</span>
                            <form action="agregar_al_carrito.php" method="POST">
                                <input type="hidden" name="id_plato" value="<?php echo $plato['id']; ?>">
                                <button type="submit" class="boton-añadir">+</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>

            <div class="centro">
                <a href="carta.php" class="boton-ver-todo">Ver toda la carta</a>
            </div>
        </div>
    </main>

    <footer class="pie-principal">
        <div class="contenedor pie-contenido">
            <div class="columna">
                <h2 class="logotipo">LA<span>LUPE</span></h2>
            </div>
            <div class="columna">
                <h3>Contacto</h3>
                <p>C. Fernando Gavilán, 12, 11600 Ubrique, Cádiz</p>
                <p>Tel: +34956464410</p>
            </div>
        </div>
        <div class="pie-final">
            <p>&copy; 2026 La Lupe - Todos los derechos reservados</p>
            <nav class="links-legales">
                <a href="licencias_privacidad/PolticaPrivacidad.html">Política de Privacidad</a>
                <a href="licencias_privacidad/AvisoLegal.html">Aviso Legal</a>
                <a href="licencias_privacidad/formulariosuscripcin.html">Formulario suscripción</a>
                <a href="licencias_privacidad/PolticadeCookies.html">Politica de Cookies</a>
                <a href="licencias_privacidad/Trminosycondiciones.html">Terminos y condiciones</a>
            </nav>
        </div>
    </footer>

</body>
</html>
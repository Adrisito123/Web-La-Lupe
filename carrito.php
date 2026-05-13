<?php 
session_start(); 

include 'db.php'; 
$nombreUsuario = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : "Invitado";

$mostrarModal = false;

if (isset($_POST['btn_pagar'])) {
    $mostrarModal = true; 
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tu Carrito | La Lupe</title>
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
    <div class="contenedor">
        <h1>Tu Pedido</h1>
        
        <?php if(empty($_SESSION['carrito'])): ?>
            <div class="carrito-vacio">
                <p>Tu carrito está vacío.</p>
                <a href="carta.php" class="boton-accion">Ver la carta</a>
            </div>
        <?php else: ?>
            <table class="tabla-carrito">
                <thead>
                    <tr>
                        <th>Plato</th>
                        <th>Precio</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total = 0;
                    foreach ($_SESSION['carrito'] as $index => $id_plato):
                        $query = mysqli_query($conexion, "SELECT * FROM platos WHERE id = '$id_plato'");
                        $p = mysqli_fetch_assoc($query);
                        if ($p):
                            $total += $p['precio'];
                    ?>
                    <tr>
                        <td><?php echo $p['nombre']; ?></td>
                        <td><?php echo number_format($p['precio'], 2); ?>€</td>
                        <td>
                            <form action="eliminar_item.php" method="POST">
                                <input type="hidden" name="index" value="<?php echo $index; ?>">
                                <button type="submit" class="btn-eliminar">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    <?php 
                        endif;
                    endforeach; 
                    ?>
                </tbody>
            </table>

            <div class="resumen-pedido">
                <h3>Total: <span><?php echo number_format($total, 2); ?>€</span></h3>
                <div class="acciones-carrito">
                    <form method="POST">
                        <button type="submit" name="btn_pagar" class="btn-accion">Pagar ahora</button>
                    </form>
                    <?php if ($mostrarModal): ?>
                        <div class="modal-estatico">
                            <div class="modal-contenido">
                                <h2>Finalizar Pedido en <span>La Lupe</span></h2>
                                
                                <div class="opciones-simuladas">
                                    <div class="grupo">
                                        <h3>¿Cómo lo quieres?</h3>
                                        <p><input type="radio" disabled> A domicilio</p>
                                        <p><input type="radio" disabled> Servicio en mesa</p>
                                    </div>

                                    <div class="grupo">
                                        <h3>¿Cuándo pagas?</h3>
                                        <p><input type="radio" disabled> Pagar ahora</p>
                                        <p><input type="radio" disabled> Al recibir el pedido</p>
                                    </div>
                                </div>

                                <p class="nota">Esta es una vista previa del sistema de pagos.</p>
                                <a href="carrito.php" class="btn-volver">Volver al carrito</a>
                            </div>
                        </div>
                    <?php endif; ?>
                    <a href="vaciar_carrito.php" class="btn-gris">Vaciar todo</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
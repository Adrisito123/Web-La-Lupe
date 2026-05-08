<?php 
session_start(); 
include 'db.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tu Carrito | La Lupe</title>
    <link rel="stylesheet" href="css/estilos.css"> 
</head>
<body>
    
    <div class="contenedor">
        <div class="navegacion-superior">
            <a href="carta.php" class="link-volver">← Volver a la carta</a>
        </div>

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
                    <button class="boton-accion">Pagar Ahora</button>
                    <a href="vaciar_carrito.php" class="btn-gris">Vaciar todo</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
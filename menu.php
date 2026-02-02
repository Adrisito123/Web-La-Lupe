<?php
session_start();
include 'db.php';

// Verificamos si hay sesión iniciada
$esInvitado = !isset($_SESSION['usuario_id']);
$nombreUsuario = $esInvitado ? "Invitado" : $_SESSION['nombre'];
$esAdmin = (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú - La Lupe</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

    <header class="main-header">
        <div class="header-container">
            <h1 class="logo">La Lupe </h1>
            <nav class="nav-menu">
                <span>Hola, <strong><?php echo htmlspecialchars($nombreUsuario); ?></strong></span>
                <?php if ($esInvitado): ?>
                    <a href="index.php" class="btn-nav">Iniciar Sesión</a>
                <?php else: ?>
                    <a href="logout.php" class="btn-nav btn-logout">Cerrar Sesión</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main class="menu-section">
        <h2 class="section-title">Nuestra Carta</h2>
        
        <div class="platos-grid">
            <?php
            $query = "SELECT * FROM platos WHERE disponible = 1";
            $resultado = mysqli_query($conexion, $query);

            if (mysqli_num_rows($resultado) > 0):
                while ($plato = mysqli_fetch_assoc($resultado)):
            ?>
                <div class="plato-card">
                    <div class="plato-img">
                        <img src="img/platos/<?php echo $plato['imagen']; ?>" alt="<?php echo $plato['nombre']; ?>">
                    </div>
                    <div class="plato-info">
                        <h3><?php echo htmlspecialchars($plato['nombre']); ?></h3>
                        <p><?php echo htmlspecialchars($plato['descripcion']); ?></p>
                        <div class="plato-footer">
                            <span class="precio"><?php echo number_format($plato['precio'], 2); ?>€</span>
                            
                            <?php if (!$esInvitado): ?>
                                <button class="btn-pedido">Añadir al pedido</button>
                            <?php else: ?>
                                <span class="msg-invitado">Regístrate para pedir</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php 
                endwhile; 
            else:
                echo "<p>No hay platos disponibles en este momento.</p>";
            endif;
            ?>
        </div>
    </main>

</body>
</html>
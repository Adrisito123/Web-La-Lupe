<?php
session_start();
include 'db.php';

// Verificación de rol y nombre por defecto
$esAdmin = (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin');
$nombreUsuario = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : "Invitado";

// Lógica de filtrado por categoría
$categoriaSeleccionada = isset($_GET['cat']) ? mysqli_real_escape_string($conexion, $_GET['cat']) : 'todos';

$sql = "SELECT * FROM platos WHERE disponible = 1";
if ($categoriaSeleccionada !== 'todos') {
    $sql .= " AND categoria = '$categoriaSeleccionada'";
}
$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Lupe | Nuestra Carta</title>
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <header class="main-header">
        <nav class="navbar">
            <div class="nav-brand">
                <a href="menu.php" class="logo">LA<span>LUPE</span></a>
            </div>

            <ul class="nav-links">
                <li><a href="menu.php">Inicio</a></li>
                <li><a href="carta.php" class="active">Carta</a></li>
                <?php if ($esAdmin): ?>
                    <li><a href="admin/nuevo_producto.php" class="admin-link">Panel Admin</a></li>
                <?php endif; ?>
            </ul>

            <div class="nav-actions">
                <a href="mi_cuenta.php" class="user-pill">
                    <i class="fas fa-user-circle"></i>
                    <span><?php echo $nombreUsuario; ?></span>
                </a>
                
                <a href="carrito.php" class="cart-pill">
                    <i class="fas fa-shopping-bag"></i>
                    <span class="cart-badge">0</span>
                </a>

                <a href="logout.php" class="logout-pill" title="Cerrar Sesión">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </nav>
    </header>

    <section class="filtros-seccion">
        <div class="container" style="padding: 20px; text-align: center;">
            <h1 style="margin-bottom: 20px;">Explora nuestra <span>Carta</span></h1>
            <div class="filtros-categorias" style="display: flex; justify-content: center; gap: 10px; flex-wrap: wrap;">
                <a href="carta.php?cat=todos" class="btn-filtro <?php echo $categoriaSeleccionada == 'todos' ? 'activo' : ''; ?>">Todos</a>
                <a href="carta.php?cat=baguettes" class="btn-filtro <?php echo $categoriaSeleccionada == 'baguettes' ? 'activo' : ''; ?>">Baguettes</a>
                <a href="carta.php?cat=burgers" class="btn-filtro <?php echo $categoriaSeleccionada == 'burgers' ? 'activo' : ''; ?>">Burgers</a>
                <a href="carta.php?cat=perritos" class="btn-filtro <?php echo $categoriaSeleccionada == 'perritos' ? 'activo' : ''; ?>">Perritos</a>
            </div>
        </div>
    </section>

    <main class="contenedor-platos">
        <div class="grid-platos">
            <?php
            if ($resultado && mysqli_num_rows($resultado) > 0):
                while($row = mysqli_fetch_assoc($resultado)):
            ?>
                <div class="tarjeta-plato">
                    <div class="card-img">
                        <img src="img/platos/<?php echo $row['imagen']; ?>" onerror="this.src='img/default.jpg'">
                        <span class="category-label"><?php echo strtoupper($row['categoria']); ?></span>
                    </div>
                    <div class="info-plato">
                        <h3><?php echo $row['nombre']; ?></h3>
                        <div class="card-footer" style="display: flex; justify-content: space-between; align-items: center;">
                            <span class="precio-tag"><?php echo $row['precio']; ?>€</span>
                            <button class="btn-colorido" style="width: 35px; height: 35px; border-radius: 50%; padding: 0;">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <?php 
                endwhile;
            else:
                echo "<p class='no-datos'>No hay platos disponibles en esta categoría.</p>";
            endif; 
            ?>
        </div>
    </main>

    <footer style="text-align: center; padding: 40px; background: #212121; color: white; margin-top: 40px;">
        <p>&copy; 2026 La Lupe - Sabores Modernos</p>
    </footer>

</body>
</html>
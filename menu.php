<?php
session_start();
include 'db.php';
$esAdmin = (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin');
$nombreUsuario = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : "Invitado";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Lupe | Menú Principal</title>
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <header class="main-header">
        <nav class="navbar">
            <a href="menu.php" class="logo">LA LUPE</a>

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

                <?php if ($esAdmin): ?>
                    <a href="admin/nuevo_producto.php" class="user-pill" style="border-color: #00bcd4;">
                        <i class="fas fa-tools" style="color: #00bcd4;"></i>
                    </a>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <section class="hero-fancy">
        <h1>¿Qué te apetece <span>hoy?</span></h1>
        <p>Los favoritos de la semana te están esperando.</p>
    </section>

    <section class="tendencias-semana">
        <h2>Tendencias de la <span>Semana</span></h2>
        
        <div class="grid-tendencias">
            <div class="item-tendencia">
                <div class="img-wrapper">
                    <img src="img/tendencias/baguette.jpg" onerror="this.src='https://via.placeholder.com/300x150?text=Baguettes'">
                </div>
                <span class="badge-top">Top #1</span>
                <h4>Baguette Suprema</h4>
            </div>

            <div class="item-tendencia">
                <div class="img-wrapper">
                    <img src="img/tendencias/burger.jpg" onerror="this.src='https://via.placeholder.com/300x150?text=Burgers'">
                </div>
                <span class="badge-top">Top #2</span>
                <h4>Monster Cheese</h4>
            </div>

            <div class="item-tendencia">
                <div class="img-wrapper">
                    <img src="img/tendencias/tacos.jpg" onerror="this.src='https://via.placeholder.com/300x150?text=Tacos'">
                </div>
                <span class="badge-top">Top #3</span>
                <h4>Tacos al Pastor</h4>
            </div>

            <div class="item-tendencia">
                <div class="img-wrapper">
                    <img src="img/tendencias/hotdog.jpg" onerror="this.src='https://via.placeholder.com/300x150?text=Perritos'">
                </div>
                <span class="badge-top">Top #4</span>
                <h4>Perrito XL</h4>
            </div>
        </div>
    </section>

    <main class="contenedor-platos">
        <div class="section-title">
            <h2 style="border-left: 5px solid #ff5722; padding-left: 15px;">Nuestros Platos</h2>
            <a href="carta.php" class="ver-todo" style="color: #00bcd4; text-decoration: none; font-weight: bold;">Ver carta completa</a>
        </div>
        
        <div class="grid-platos">
            <?php
            $query = "SELECT * FROM platos WHERE disponible = 1 LIMIT 4";
            $resultado = mysqli_query($conexion, $query);
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
            <?php endwhile; ?>
        </div>
    </main>

    <footer style="text-align: center; padding: 40px; background: #212121; color: white; margin-top: 40px;">
        <p>&copy; 2026 La Lupe - Sabores Modernos</p>
    </footer>

</body>
</html>
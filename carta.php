<?php
session_start();
include 'db.php';
$esInvitado = !isset($_SESSION['usuario_id']);

// Función para obtener platos por categoría
function obtenerPorCategoria($con, $cat) {
    $sql = "SELECT * FROM platos WHERE categoria = '$cat' AND disponible = 1";
    return mysqli_query($con, $sql);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>La Lupe - Carta Completa</title>
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <header class="main-header">
        <div class="header-container">
            <a href="menu.php" class="logo">LA LUPE<span>.</span></a>
            <nav class="nav-menu">
                <a href="menu.php">Inicio</a>
                <a href="carta.php" class="active">Carta</a>
                <a href="carrito.php"><i class="fas fa-shopping-basket"></i></a>
                <a href="mi_cuenta.php"><i class="fas fa-user"></i></a>
            </nav>
        </div>
    </header>

    <main class="container">
        <h1 class="main-title">Nuestra Carta Oficial</h1>
        <p class="subtitle text-center">Selecciona tus favoritos y añádelos al carrito</p>

        <section class="menu-section">
            <h2 class="category-header"><i class="fas fa-bread-slice"></i> Barras Anticrisis (42cm)</h2>
            <div class="menu-list">
                <?php 
                $res = obtenerPorCategoria($conexion, 'baguettes');
                while($item = mysqli_fetch_assoc($res)): 
                ?>
                <div class="menu-item">
                    <div class="item-info">
                        <h4><?php echo $item['nombre']; ?></h4>
                        <p><?php echo $item['descripcion']; ?></p>
                    </div>
                    <div class="item-actions">
                        <span class="price"><?php echo $item['precio']; ?>€</span>
                        <button class="add-btn" onclick="agregarAlCarrito(<?php echo $item['id']; ?>)">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </section>

        <section class="menu-section">
            <h2 class="category-header"><i class="fas fa-hamburger"></i> Hamburguesas</h2>
            <div class="menu-list">
                <?php 
                $res = obtenerPorCategoria($conexion, 'hamburguesas');
                while($item = mysqli_fetch_assoc($res)): 
                ?>
                <div class="menu-item">
                    <div class="item-info">
                        <h4><?php echo $item['nombre']; ?></h4>
                        <p><?php echo $item['descripcion']; ?></p>
                    </div>
                    <div class="item-actions">
                        <span class="price"><?php echo $item['precio']; ?>€</span>
                        <button class="add-btn">+</button>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </section>

        <section class="menu-section">
            <h2 class="category-header"><i class="fas fa-hotdog"></i> Perritos Calientes</h2>
            <div class="menu-list">
                <?php 
                $res = obtenerPorCategoria($conexion, 'perritos');
                while($item = mysqli_fetch_assoc($res)): 
                ?>
                <div class="menu-item">
                    <div class="item-info">
                        <h4><?php echo $item['nombre']; ?></h4>
                    </div>
                    <div class="item-actions">
                        <span class="price"><?php echo $item['precio']; ?>€</span>
                        <button class="add-btn">+</button>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </section>

    </main>

    <script>
        function agregarAlCarrito(id) {
            // Aquí irá tu lógica de AJAX para el carrito
            alert("Producto " + id + " añadido. ¡A cenar!");
        }
    </script>
</body>
</html>
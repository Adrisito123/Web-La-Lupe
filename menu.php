<?php
session_start();
include 'db.php';

// SEGURIDAD: Si no hay sesión iniciada, mandamos al usuario de vuelta al login
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

// Consultamos los platos de la base de datos
$query = "SELECT * FROM platos";
$resultado = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Menú - La Lupe</title>
    <link rel="stylesheet" href="css/estilos.css"> </head>
<body>
    <header>
        <h1>Bienvenido, <?php echo $_SESSION['nombre']; ?></h1>
        <p>Rol: <?php echo $_SESSION['rol']; ?></p>
        <a href="logout.php">Cerrar Sesión</a>
    </header>

    <main>
        <h2>Nuestro Menú Dinámico</h2>
        <div class="contenedor-platos">
            <?php 
            // Recorremos los platos que hay en la base de datos de AWS
            if (mysqli_num_rows($resultado) > 0) {
                while($plato = mysqli_fetch_assoc($resultado)) {
                    echo "<div class='tarjeta-plato'>";
                        echo "<h3>" . htmlspecialchars($plato['nombre']) . "</h3>";
                        echo "<p>" . htmlspecialchars($plato['descripcion']) . "</p>";
                        echo "<span>Precio: " . $plato['precio'] . "€</span>";
                    echo "</div>";
                }
            } else {
                echo "<p>No hay platos disponibles en este momento.</p>";
            }
            ?>
        </div>
    </main>
</body>
</html>
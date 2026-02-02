<?php
session_start();
include '../db.php'; // Subimos un nivel para encontrar el archivo de conexión

// SEGURIDAD: Solo permitimos entrar si es 'admin'
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    echo "Acceso denegado. Solo para administradores.";
    exit();
}

$mensaje = "";

// LÓGICA PARA AÑADIR PLATO
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['añadir'])) {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']);
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];

    $sql = "INSERT INTO platos (nombre, descripcion, precio, categoria) VALUES ('$nombre', '$descripcion', '$precio', '$categoria')";
    
    if (mysqli_query($conexion, $sql)) {
        $mensaje = "Plato añadido correctamente.";
    } else {
        $mensaje = "Error: " . mysqli_error($conexion);
    }
}

// LÓGICA PARA BORRAR PLATO
if (isset($_GET['borrar'])) {
    $id = $_GET['borrar'];
    mysqli_query($conexion, "DELETE FROM platos WHERE id_plato = $id");
    header("Location: gestionar_platos.php");
}

$platos = mysqli_query($conexion, "SELECT * FROM platos");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin - La Lupe</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <h1>Panel de Administración - La Lupe</h1>
    <p><a href="../menu.php"> Ver Menú Público</a> | <a href="../logout.php">Cerrar Sesión</a></p>
    
    <p style="color: green;"><?php echo $mensaje; ?></p>

    <section>
        <h2>Añadir Nuevo Plato</h2>
        <form method="POST">
            <input type="text" name="nombre" placeholder="Nombre del plato" required>
            <input type="text" name="descripcion" placeholder="Descripción">
            <input type="number" step="0.01" name="precio" placeholder="Precio (Ej: 12.50)" required>
            <select name="categoria">
                <option value="Entrantes">Entrantes</option>
                <option value="Principales">Principales</option>
                <option value="Postres">Postres</option>
                <option value="Bebidas">Bebidas</option>
            </select>
            <button type="submit" name="añadir">Guardar Plato</button>
        </form>
    </section>

    <hr>

    <section>
        <h2>Listado de Platos</h2>
        <table border="1">
            <tr>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Categoría</th>
                <th>Acciones</th>
            </tr>
            <?php while($p = mysqli_fetch_assoc($platos)): ?>
            <tr>
                <td><?php echo $p['nombre']; ?></td>
                <td><?php echo $p['precio']; ?>€</td>
                <td><?php echo $p['categoria']; ?></td>
                <td>
                    <a href="gestionar_platos.php?borrar=<?php echo $p['id_plato']; ?>" onclick="return confirm('¿Seguro?')">Borrar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </section>
</body>
</html>
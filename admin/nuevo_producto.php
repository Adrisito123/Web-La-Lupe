<?php
session_start();
include '../db.php'; // Subimos un nivel para encontrar la conexión

// SEGURIDAD: Si no es admin, patada hacia afuera
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

$mensaje = "";

if (isset($_POST['guardar'])) {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $precio = mysqli_real_escape_string($conexion, $_POST['precio']);
    $categoria = mysqli_real_escape_string($conexion, $_POST['categoria']);
    $descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']);
    
    // Gestión de la Imagen
    $nombre_img = $_FILES['imagen']['name'];
    $ruta_temporal = $_FILES['imagen']['tmp_name'];
    $ruta_destino = "../img/platos/" . $nombre_img;

    if (move_uploaded_file($ruta_temporal, $ruta_destino)) {
        $sql = "INSERT INTO platos (nombre, precio, categoria, imagen, descripcion, disponible) 
                VALUES ('$nombre', '$precio', '$categoria', '$nombre_img', '$descripcion', 1)";
        
        if (mysqli_query($conexion, $sql)) {
            $mensaje = "<div class='alerta exito'>¡Producto añadido con éxito!</div>";
        } else {
            $mensaje = "<div class='alerta error'>Error en SQL: " . mysqli_error($conexion) . "</div>";
        }
    } else {
        $mensaje = "<div class='alerta error'>Error al subir la imagen. Revisa permisos de carpeta.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Admin - Añadir Producto</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="admin-page">

    <div class="form-container">
        <div class="form-header">
            <a href="../menu.php" class="btn-back"><i class="fas fa-arrow-left"></i> Volver</a>
            <h1><i class="fas fa-plus-circle"></i> Nuevo Producto</h1>
        </div>

        <?php echo $mensaje; ?>

        <form action="nuevo_producto.php" method="POST" enctype="multipart/form-data" class="admin-form">
            <div class="input-group">
                <label>Nombre del Plato</label>
                <input type="text" name="nombre" placeholder="Ej: Baguette La Lupe" required>
            </div>

            <div class="row">
                <div class="input-group">
                    <label>Precio (€)</label>
                    <input type="number" step="0.01" name="precio" placeholder="0.00" required>
                </div>
                <div class="input-group">
                    <label>Categoría</label>
                    <select name="categoria" required>
                        <option value="baguettes">Baguettes</option>
                        <option value="hamburguesas">Hamburguesas</option>
                        <option value="perritos">Perritos Calientes</option>
                        <option value="tarrinas">Tarrinas / Combinados</option>
                        <option value="sandwiches">Super Sandwichs</option>
                    </select>
                </div>
            </div>

            <div class="input-group">
                <label>Descripción</label>
                <textarea name="descripcion" rows="3" placeholder="Ingredientes..."></textarea>
            </div>

            <div class="input-group">
                <label>Imagen del Producto</label>
                <input type="file" name="imagen" accept="image/*" required>
            </div>

            <button type="submit" name="guardar" class="btn-admin-submit">Guardar Producto</button>
        </form>
    </div>

</body>
</html>
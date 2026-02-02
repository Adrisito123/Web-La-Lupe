<?php
include '../db.php';
// Aquí podrías añadir un check de sesión para que solo entre el admin

// Lógica para INSERTAR
if (isset($_POST['añadir'])) {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $desc   = mysqli_real_escape_string($conexion, $_POST['descripcion']);
    $precio = $_POST['precio'];

    // --- LÓGICA DE LA IMAGEN ---
    $nombre_imagen = $_FILES['imagen']['name'];
    $archivo_temp  = $_FILES['imagen']['tmp_name'];
    
    // Generar un nombre único para la imagen para que no se sobrescriban
    $extension = pathinfo($nombre_imagen, PATHINFO_EXTENSION);
    $nuevo_nombre_img = time() . "_" . $nombre . "." . $extension;
    $ruta_destino = "../img/platos/" . $nuevo_nombre_img;

    if (move_uploaded_file($archivo_temp, $ruta_destino)) {
        // Si la imagen se subió bien, guardamos en la BD
        $sql = "INSERT INTO platos (nombre, descripcion, precio, imagen) 
                VALUES ('$nombre', '$desc', '$precio', '$nuevo_nombre_img')";
        
        if (mysqli_query($conexion, $sql)) {
            header("Location: gestionar_platos.php?success=1");
        } else {
            echo "Error en BD: " . mysqli_error($conexion);
        }
    } else {
        echo "Error al subir la imagen. Revisa los permisos de la carpeta.";
    }
}

// Lógica para BORRAR
if (isset($_GET['borrar'])) {
    $id = $_GET['borrar'];
    mysqli_query($conexion, "DELETE FROM platos WHERE id = $id");
    header("Location: gestionar_platos.php");
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión - La Lupe</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <div class="admin-wrapper">
        <div class="admin-header">
            <h1><i class="fas fa-utensils"></i> Gestión del Menú</h1>
            <a href="../menu.php" class="btn-volver">Volver al Menú Público</a>
        </div>

        <section class="admin-card">
            <div class="card-header">
                <h3><i class="fas fa-plus-circle"></i> Añadir Nuevo Producto</h3>
            </div>
            <form method="POST" enctype="multipart/form-data" class="admin-form">
                <div class="form-row">
                    <div class="form-group">
                        <label>Nombre del Plato</label>
                        <input type="text" name="nombre" placeholder="Ej: Tacos al Pastor" required>
                    </div>
                    <div class="form-group">
                        <label>Precio (€)</label>
                        <input type="number" step="0.01" name="precio" placeholder="0.00" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Descripción</label>
                    <textarea name="descripcion" rows="3" placeholder="Ingredientes, alérgenos..."></textarea>
                </div>

                <div class="form-group">
                    <label>Imagen del Producto</label>
                    <div class="file-upload">
                        <input type="file" name="imagen" accept="image/*" id="foto" required>
                        <label for="foto"><i class="fas fa-camera"></i> Seleccionar Foto</label>
                    </div>
                </div>

                <button type="submit" name="añadir" class="btn-primary">
                    <i class="fas fa-save"></i> Guardar en el Menú
                </button>
            </form>
        </section>

        <section class="admin-card">
            <div class="card-header">
                <h3><i class="fas fa-list"></i> Productos Actuales</h3>
            </div>
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        </tbody>
                </table>
            </div>
        </section>
    </div>

</body>
</html>
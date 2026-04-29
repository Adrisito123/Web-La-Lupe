<?php
session_start();
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $categoria = $_POST['categoria'];
    $precio = $_POST['precio'];
    $descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']);

    // Gestión de la Imagen
    $nombre_imagen = $_FILES['imagen']['name'];
    $ruta_temporal = $_FILES['imagen']['tmp_name'];
    $carpeta_destino = "../img/platos/";

    // Mover archivo a la carpeta del servidor
    if (move_uploaded_file($ruta_temporal, $carpeta_destino . $nombre_imagen)) {
        $sql = "INSERT INTO platos (nombre, categoria, precio, imagen, descripcion, disponible) 
                VALUES ('$nombre', '$categoria', '$precio', '$nombre_imagen', '$descripcion', 1)";
        
        if (mysqli_query($conexion, $sql)) {
            header("Location: panel.php?status=success&msg=Plato creado");
            exit();
        }
    }
}
if (mysqli_query($conexion, $sql)) {
    header("Location: panel.php?status=success&msg=Plato creado correctamente");
} else {
    header("Location: panel.php?status=error&msg=Error al guardar en la base de datos");
}
exit();
?>
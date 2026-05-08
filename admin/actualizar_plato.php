<?php
session_start();
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $categoria = $_POST['categoria'];
    $precio = $_POST['precio'];
    $imagen_nombre = $_POST['imagen_actual']; 

    // Si el usuario subió una nueva foto
    if (!empty($_FILES['nueva_imagen']['name'])) {
        $ruta_carpeta = "../img/platos/";
        
        // Borrar la imagen vieja 
        if (file_exists($ruta_carpeta . $imagen_nombre)) {
            unlink($ruta_carpeta . $imagen_nombre);
        }

        // Subir la nueva
        $imagen_nombre = $_FILES['nueva_imagen']['name'];
        move_uploaded_file($_FILES['nueva_imagen']['tmp_name'], $ruta_carpeta . $imagen_nombre);
    }

    $sql = "UPDATE platos SET 
            nombre = '$nombre', 
            categoria = '$categoria', 
            precio = '$precio', 
            imagen = '$imagen_nombre' 
            WHERE id = '$id'";

    if (mysqli_query($conexion, $sql)) {
        header("Location: panel.php?status=success&msg=Plato actualizado");
    } else {
        header("Location: panel.php?status=error&msg=Error al actualizar");
    }
    exit();
}
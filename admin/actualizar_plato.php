<?php
session_start();
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $categoria = $_POST['categoria'];
    $precio = $_POST['precio'];
    
    $imagen_nombre = $_POST['imagen_actual']; 

    if (!empty($_FILES['nueva_imagen']['name'])) {
        $ruta_carpeta = "../img/platos/";
        
        $extension = pathinfo($_FILES['nueva_imagen']['name'], PATHINFO_EXTENSION);
        $nuevo_nombre = "plato_" . $id . "_" . time() . "." . $extension;
        $ruta_destino = $ruta_carpeta . $nuevo_nombre;

        if (move_uploaded_file($_FILES['nueva_imagen']['tmp_name'], $ruta_destino)) {
            
            if (!empty($imagen_nombre) && file_exists("../" . $imagen_nombre)) {
                unlink("../" . $imagen_nombre);
            }

            $imagen_nombre = "img/platos/" . $nuevo_nombre;
        }
    }

    $sql = "UPDATE platos SET 
            nombre = '$nombre', 
            categoria = '$categoria', 
            precio = '$precio', 
            imagen = '$imagen_nombre' 
            WHERE id = '$id'";

    if (mysqli_query($conexion, $sql)) {
        header("Location: panel.php?status=success&msg=Plato actualizado correctamente");
    } else {
        header("Location: panel.php?status=error&msg=Error al actualizar la base de datos");
    }
    exit();
}
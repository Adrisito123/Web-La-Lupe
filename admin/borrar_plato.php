<?php
session_start();
include '../db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Buscamos el nombre de la imagen para borrar el archivo físico
    $res = mysqli_query($conexion, "SELECT imagen FROM platos WHERE id = '$id'");
    $plato = mysqli_fetch_assoc($res);
    $ruta_imagen = "../img/platos/" . $plato['imagen'];

    if (file_exists($ruta_imagen)) {
        unlink($ruta_imagen); // Borra el archivo
    }

    // Borramos de la base de datos
    mysqli_query($conexion, "DELETE FROM platos WHERE id = '$id'");
    header("Location: panel.php?status=success&msg=Plato eliminado");
    exit();
}
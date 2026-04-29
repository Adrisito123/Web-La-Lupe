<?php
session_start();
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_usuario'])) {
    $id = $_POST['id_usuario'];
    $rol = $_POST['nuevo_rol'];

    // Evitar que el admin se quite permisos a sí mismo por error
    if ($id == $_SESSION['usuario_id'] && $rol === 'user') {
        header("Location: panel.php?error=No puedes quitarte el rango de admin");
        exit();
    }

    mysqli_query($conexion, "UPDATE usuarios SET rol = '$rol' WHERE id = '$id'");
    header("Location: panel.php#usuarios");
}
?>
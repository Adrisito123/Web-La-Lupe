<?php
session_start();
include '../db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Evitar que el admin se borre a sí mismo
    if ($id == $_SESSION['usuario_id']) {
        header("Location: panel.php?error=No puedes borrarte a ti mismo");
        exit();
    }

    mysqli_query($conexion, "DELETE FROM usuarios WHERE id = '$id'");
    header("Location: panel.php#usuarios");
}
?>
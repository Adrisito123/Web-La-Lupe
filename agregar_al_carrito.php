<?php
session_start();

if (isset($_POST['id_plato'])) {
    // Si el carrito no existe, lo creamos
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }
    
    // Añadimos el ID del plato al carrito
    $_SESSION['carrito'][] = $_POST['id_plato'];
    
    header("Location: carta.php?added=1");
    exit();
    }
?>
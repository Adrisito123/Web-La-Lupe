<?php
session_start();

if (isset($_POST['index'])) {
    $index = $_POST['index'];

    unset($_SESSION['carrito'][$index]);

    $_SESSION['carrito'] = array_values($_SESSION['carrito']);
}

header("Location: carrito.php");
exit();
?>
<?php
// Detectar si estamos en local o en el servidor
if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['HTTP_HOST'] == 'localhost') {
    // CONFIGURACIÓN LOCAL 
    $servidor = "localhost";
    $usuario  = "root";
    $password = ""; 
    $base_datos = "web_la_lupe";
} else {
    // CONFIGURACIÓN AWS
    $servidor = "localhost";
    $usuario  = "admin_lalupe";
    $password = "admin_lalupe123"; 
    $base_datos = "web_la_lupe";
}

$conexion = mysqli_connect($servidor, $usuario, $password, $base_datos);
if (!$conexion) {
    die("Fallo total de conexión: " . mysqli_connect_error());
}

// Asegurar que las tildes y ñ se lean correctamente
mysqli_set_charset($conexion, "utf8mb4");
?>
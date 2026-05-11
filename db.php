<?php
// Detectar si estamos en local o en el servidor
if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['HTTP_HOST'] == 'localhost') {
    // CONFIGURACIÓN LOCAL 
    $servidor = "localhost";
    $usuario  = "root";
    $password = ""; 
    $base_datos = "web_la_lupe";
} else {
    // CONFIGURACIÓN InfinityFree
    $host = "sql210.infinityfree.com"; 
    $user = "if0_41863854";
    $pass = "8goITPHZs5tJS6";
    $db   = "if0_41863854_lalupe_db";

    $conexion = mysqli_connect($host, $user, $pass, $db);

    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }
    }


mysqli_set_charset($conexion, "utf8mb4");
?>
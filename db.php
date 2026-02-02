<?php
// Configuración de la base de datos de La Lupe
$host = "localhost";
$user = "admin_lalupe"; // El usuario que creamos antes
$pass = "TuPasswordSegura123!"; // La contraseña que pusiste
$db   = "web_la_lupe"; // El nombre que le diste a la base de datos

$conexion = mysqli_connect($host, $user, $pass, $db);

// Ajustar caracteres a UTF-8 para que funcionen las tildes y la 'ñ'
mysqli_set_charset($conexion, "utf8");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>
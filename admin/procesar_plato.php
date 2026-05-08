<?php
include '../db.php';

$nombre = $_POST['nombre'];
$categoria = $_POST['categoria'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];

if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
    $nombre_foto = $_FILES['imagen']['name'];
    $ruta_temporal = $_FILES['imagen']['tmp_name'];
    
    $carpeta_destino = "../img/platos/";
    move_uploaded_file($ruta_temporal, $carpeta_destino . $nombre_foto);

    $ruta_db = "img/platos/" . $nombre_foto; 
} else {
    $ruta_db = "img/platos/default.webp";
}

$sql = "INSERT INTO platos (nombre, categoria, descripcion, precio, imagen, disponible) 
        VALUES ('$nombre', '$categoria', '$descripcion', '$precio', '$ruta_db', 1)";

if (mysqli_query($conexion, $sql)) {
    header("Location: panel.php?status=success&msg=Plato creado correctamente");
} else {
    header("Location: panel.php?status=error&msg=Error al guardar en la base de datos");
}
exit();
?>
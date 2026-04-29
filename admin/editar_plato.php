<?php
session_start();
include '../db.php';

// Seguridad
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') { header("Location: ../index.php"); exit(); }

$id = $_GET['id'];
$res = mysqli_query($conexion, "SELECT * FROM platos WHERE id = '$id'");
$p = mysqli_fetch_assoc($res);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Plato | La Lupe</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body class="body-admin">
    <div class="contenedor" style="margin-top: 50px; max-width: 600px;">
        <div class="bloque-panel">
            <h3><i class="fas fa-edit"></i> Editar Plato: <?php echo $p['nombre']; ?></h3>
            
            <form action="actualizar_plato.php" method="POST" class="formulario-admin" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                <input type="hidden" name="imagen_actual" value="<?php echo $p['imagen']; ?>">

                <div class="grupo-input">
                    <label>Nombre del Plato</label>
                    <input type="text" name="nombre" value="<?php echo $p['nombre']; ?>" required>
                </div>

                <div class="grupo-input">
                    <label>Categoría</label>
                    <select name="categoria">
                        <option value="entrantes" <?php if($p['categoria']=='entrantes') echo 'selected'; ?>>Entrantes</option>
                        <option value="hamburguesas" <?php if($p['categoria']=='hamburguesas') echo 'selected'; ?>>Hamburguesas</option>
                        <option value="bebidas" <?php if($p['categoria']=='bebidas') echo 'selected'; ?>>Bebidas</option>
                    </select>
                </div>

                <div class="grupo-input">
                    <label>Precio (€)</label>
                    <input type="number" step="0.01" name="precio" value="<?php echo $p['precio']; ?>" required>
                </div>

                <div class="grupo-input">
                    <label>Imagen Actual</label>
                    <img src="../img/platos/<?php echo $p['imagen']; ?>" width="100" style="display:block; margin-bottom:10px; border-radius:5px;">
                    <label>Cambiar Foto (dejar vacío para mantener la actual)</label>
                    <input type="file" name="nueva_imagen" accept="image/*">
                </div>

                <div style="display:flex; gap:10px;">
                    <button type="submit" class="boton-accion">Guardar Cambios</button>
                    <a href="panel.php" class="btn-deshabilitado" style="text-decoration:none; text-align:center;">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
<?php
session_start();
include '../db.php'; 

// Verificación de seguridad: solo admin
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

$nombreUsuario = $_SESSION['nombre'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Control | La Lupe</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body class="body-admin">
    <?php if (isset($_GET['status'])): ?>
        <div class="alerta-admin <?php echo $_GET['status']; ?>">
            <i class="fas <?php echo ($_GET['status'] == 'success') ? 'fa-check-circle' : 'fa-exclamation-circle'; ?>"></i>
            <?php echo $_GET['msg']; ?>
        </div>
    <?php endif; ?>
    <header class="cabecera-principal">
        <nav class="barra-navegacion contenedor">
            <div class="bloque-izquierdo">
                <a href="../menu.php" class="logotipo">LA<span>LUPE</span> Admin</a>
            </div>
            <div class="bloque-derecho">
                <a href="../menu.php" class="boton-salir">Volver a la Web</a>
            </div>
        </nav>
    </header>

    <div class="contenedor-admin contenedor">
        
        <aside class="menu-lateral">
            <ul>
                <li><a href="#pedidos" class="activo"><i class="fas fa-shopping-cart"></i> Pedidos Recientes</a></li>
                <li><a href="#usuarios"><i class="fas fa-users"></i> Gestionar Usuarios</a></li>
                <li><a href="#platos"><i class="fas fa-hamburger"></i> Añadir/Editar Platos</a></li>
            </ul>
        </aside>

        <main class="contenido-panel">
            
            <section id="pedidos" class="bloque-panel">
                <h3><i class="fas fa-clipboard-list"></i> Últimos Pedidos</h3>
                <table class="tabla-admin">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Consulta uniendo tablas para saber el nombre del cliente
                        $consulta_pedidos = "SELECT p.*, u.nombre FROM pedidos p 
                                            INNER JOIN usuarios u ON p.usuario_id = u.id 
                                            ORDER BY p.fecha DESC LIMIT 10";
                        
                        $res_pedidos = mysqli_query($conexion, $consulta_pedidos);

                        if(mysqli_num_rows($res_pedidos) > 0) {
                            while($p = mysqli_fetch_assoc($res_pedidos)):
                        ?>
                            <tr>
                                <td>#<?php echo $p['id']; ?></td>
                                <td><?php echo $p['nombre']; ?></td>
                                <td><?php echo $p['total']; ?>€</td>
                                <td>
                                    <span class="badge <?php echo strtolower($p['estado']); ?>">
                                        <?php echo $p['estado']; ?>
                                    </span>
                                </td>
                                <td><?php echo date('d/m/H:i', strtotime($p['fecha'])); ?></td>
                                <td>
                                    <span class="btn-deshabilitado">
                                        Ver detalle
                                    </span>
                                </td>
                            </tr>
                        <?php 
                            endwhile; 
                        } else {
                            echo "<tr><td colspan='6'>No hay pedidos aún.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </section>

            <section id="usuarios" class="bloque-panel">
                <h3><i class="fas fa-users-cog"></i> Usuarios Registrados</h3>
                <table class="tabla-admin">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $res_users = mysqli_query($conexion, "SELECT * FROM usuarios ORDER BY rol ASC");
                        while($u = mysqli_fetch_assoc($res_users)):
                        ?>
                        <tr>
                            <td><?php echo $u['nombre']; ?></td>
                            <td><?php echo $u['email']; ?></td>
                            <td>
                                <form action="cambiar_rol.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="id_usuario" value="<?php echo $u['id']; ?>">
                                    <select name="nuevo_rol" onchange="this.form.submit()" class="selector-rol">
                                        <option value="user" <?php echo ($u['rol'] === 'user') ? 'selected' : ''; ?>>Cliente</option>
                                        <option value="admin" <?php echo ($u['rol'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                                    </select>
                                </form>
                                    </td>
                                    <td>
                                        <a href="borrar_usuario.php?id=<?php echo $u['id']; ?>" 
                                        class="btn-accion rojo" 
                                        onclick="return confirm('¿Seguro que quieres eliminar este usuario?')" 
                                        title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </section>

                    <section id="platos" class="bloque-panel">
                        <h3><i class="fas fa-plus-circle"></i> Nuevo Plato</h3>
                        <form action="procesar_plato.php" method="POST" class="formulario-admin" enctype="multipart/form-data">
            <div class="grupo-input">
                <label>Nombre del Plato</label>
                <input type="text" name="nombre" required>
            </div>
            
            <div class="grupo-input">
                <label>Categoría</label>
                <select name="categoria" required>
                    <?php
                    $res_cats = mysqli_query($conexion, "SELECT DISTINCT categoria FROM platos");
                    while($cat = mysqli_fetch_assoc($res_cats)):
                    ?>
                        <option value="<?php echo $cat['categoria']; ?>">
                            <?php echo ucfirst($cat['categoria']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="grupo-input">
                <label>Descripción Corta</label>
                <textarea name="descripcion" rows="2" required></textarea>
            </div>

            <div class="grupo-input">
                <label>Precio (€)</label>
                <input type="number" step="0.01" name="precio" required>
            </div>

            <div class="grupo-input">
                <label>Imagen del Plato</label>
                <input type="file" name="imagen" accept="image/*" required>
            </div>

            <button type="submit" class="boton-accion">Guardar Plato</button>
        </form>
            </section>

            <section id="gestion-platos" class="bloque-panel">
                <h3><i class="fas fa-utensils"></i> Platos en la Carta</h3>
                <table class="tabla-admin">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $res_platos = mysqli_query($conexion, "SELECT * FROM platos ORDER BY categoria, nombre");
                        while($p = mysqli_fetch_assoc($res_platos)):
                        ?>
                        <tr>
                            <td><?php echo $p['nombre']; ?></td>
                            <td><?php echo ucfirst($p['categoria']); ?></td>
                            <td><?php echo $p['precio']; ?>€</td>
                            <td>
                                <a href="editar_plato.php?id=<?php echo $p['id']; ?>" class="btn-accion azul">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="borrar_plato.php?id=<?php echo $p['id']; ?>" 
                                class="btn-accion rojo" 
                                onclick="return confirm('¿Seguro que quieres borrar este plato?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </section>

        </main>
    </div>

</body>
</html>

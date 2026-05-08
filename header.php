<?php if (isset($_SESSION['mensaje'])): ?>
    <div class="notificacion-universal <?php echo $_SESSION['tipo_mensaje']; ?>">
        <div class="contenido-noti">
            <span><?php echo $_SESSION['mensaje']; ?></span>
        </div>
        <button onclick="this.parentElement.remove()" class="btn-cerrar-noti">&times;</button>
    </div>
    <?php unset($_SESSION['mensaje'], $_SESSION['tipo_mensaje']); ?>
<?php endif; ?>
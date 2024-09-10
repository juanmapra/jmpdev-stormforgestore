<?php
include '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<main>
    <div class="login-box">
        <h1>Cambiar Contraseña</h1>
        <form action="update_password.php" method="post">
            <input type="password" name="current_password" placeholder="Contraseña Actual" required>
            <input type="password" name="new_password" placeholder="Nueva Contraseña" required>
            <input type="password" name="confirm_password" placeholder="Confirmar Contraseña" required>
            <button type="submit" class="logout-btn mode-dark">Cambiar Contraseña</button>
        </form>
    </div>
</main>

<?php include $root_path . 'includes/footer.php'; ?>
<?php include '../includes/header.php'; ?>

<main>
    <div class="login-box">
        <h1>Iniciar sesión</h1>
        <form action="login_process.php" method="POST">
            <input type="text" name="email" id="" placeholder="Email" required>
            <input type="password" name="password" id="" placeholder="Contraseña" required>
            <a href="<?php echo $root_path; ?>users/register.php"><u>Registrarme</u></a>
            <button type="submit">Ingresar</button>
        </form>
    </div>
</main>

<?php include $root_path . 'includes/footer.php'; ?>
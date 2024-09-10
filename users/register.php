<?php include '../includes/header.php'; ?>

<main>
    <div class="login-box">
        <h1>Registrarme</h1>
        <form action="register_process.php" method="POST">
            <input type="text" name="email" id="" placeholder="Email" required>
            <input type="password" name="password" id="" placeholder="Contraseña" required>
            <input type="password" name="repeatPassword" id="" placeholder="Repetir contraseña" required>
            <input type="text" name="firstName" id="" placeholder="Nombre" required>
            <input type="text" name="lastName" id="" placeholder="Apellido" required>
            <select name="state" id="" required>
                <option value="" disabled selected>Seleccione su provincia</option>
                <option value="Buenos Aires">Buenos Aires</option>
                <option value="Catamarca">Catamarca</option>
                <option value="Chaco">Chaco</option>
                <option value="Chubut">Chubut</option>
                <option value="Córdoba">Córdoba</option>
                <option value="Corrientes">Corrientes</option>
                <option value="Entre Ríos">Entre Ríos</option>
                <option value="Formosa">Formosa</option>
                <option value="Jujuy">Jujuy</option>
                <option value="La Pampa">La Pampa</option>
                <option value="La Rioja">La Rioja</option>
                <option value="Mendoza">Mendoza</option>
                <option value="Misiones">Misiones</option>
                <option value="Neuquén">Neuquén</option>
                <option value="Río Negro">Río Negro</option>
                <option value="Salta">Salta</option>
                <option value="San Juan">San Juan</option>
                <option value="San Luis">San Luis</option>
                <option value="Santa Cruz">Santa Cruz</option>
                <option value="Santa Fe">Santa Fe</option>
                <option value="Santiago del Estero">Santiago del Estero</option>
                <option value="Tierra del Fuego">Tierra del Fuego</option>
                <option value="Tucumán">Tucumán</option>
            </select>
            <input type="text" name="city" id="" placeholder="Ciudad" required>
            <input type="text" name="street1" id="" placeholder="Dirección" required>
            <input type="text" name="postalCode" id="" placeholder="Codigo Postal" required>
            <input type="text" name="phoneNumber" id="" placeholder="Telefono" required>
            <a href="<?php echo $root_path; ?>users/login.php"><u>Iniciar sesión</u></a>
            <button type="submit">Registrarme</button>
        </form>
    </div>
</main>

<?php include $root_path . 'includes/footer.php'; ?>
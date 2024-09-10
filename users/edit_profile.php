<?php
include '../includes/header.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

require '../includes/db.php';

try{
    $pdo = getDbConnection();

    $sqlUser = "SELECT u.username, u.email, p.nombre, p.apellido, p.telefono, d.direccion_1, d.direccion_2, d.ciudad, d.provincia, d.codigo_postal FROM users u INNER JOIN user_perfiles p ON u.id = p.user_id LEFT JOIN direcciones d ON u.id = d.user_id WHERE u.id = :userId";
    $stmtUser = $pdo->prepare($sqlUser);
    $stmtUser->bindParam(':userId', $_SESSION['user_id']);
    $stmtUser->execute();
    $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

    if(!$user){
        exit("Usuario no encontrado.");
    }
} catch (PDOException $e){
    echo "Error: " . $e->getMessage();
}

?>

<main>
    <div class="login-box">
        <h1>Editar Perfil</h1>
        <form action="update_profile.php" method="post">
        <input type="text" name="nombre" value="<?php echo htmlspecialchars($user['nombre']); ?>" required>
            <input type="text" name="apellido" value="<?php echo htmlspecialchars($user['apellido']); ?>" required>
            <input type="text" name="telefono" value="<?php echo htmlspecialchars($user['telefono']); ?>">
            <input type="text" name="direccion_1" value="<?php echo htmlspecialchars($user['direccion_1']); ?>" required>
            <input type="text" name="direccion_2" value="<?php echo htmlspecialchars($user['direccion_2']); ?>">
            <input type="text" name="ciudad" value="<?php echo htmlspecialchars($user['ciudad']); ?>" required>
            <input type="text" name="provincia" value="<?php echo htmlspecialchars($user['provincia']); ?>" required>
            <input type="text" name="codigo_postal" value="<?php echo htmlspecialchars($user['codigo_postal']); ?>" required>
            <button type="submit">Actualizar Perfil</button>
        </form>
        <form action="change_password.php" method="post">
            <button type="submit" class="logout-btn mode-dark">Cambiar contraseña</button>
        </form>
    </div>
</main>

<?php include $root_path . 'includes/footer.php'; ?>
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
        <h1><?php echo htmlspecialchars($user['username']); ?></h1>
        <!-- <p><strong>Nombre de Usuario:</strong> <?php echo htmlspecialchars($user['username']); ?></p> -->
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Nombre:</strong> <?php echo htmlspecialchars($user['nombre']); ?></p>
        <p><strong>Apellido:</strong> <?php echo htmlspecialchars($user['apellido']); ?></p>
        <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($user['telefono']); ?></p>
        <p><strong>Dirección 1:</strong> <?php echo htmlspecialchars($user['direccion_1']); ?></p>
        <p><strong>Dirección 2:</strong> <?php echo htmlspecialchars($user['direccion_2']); ?></p>
        <p><strong>Ciudad:</strong> <?php echo htmlspecialchars($user['ciudad']); ?></p>
        <p><strong>Provincia:</strong> <?php echo htmlspecialchars($user['provincia']); ?></p>
        <p><strong>Código Postal:</strong> <?php echo htmlspecialchars($user['codigo_postal']); ?></p>
        <button class="logout-btn mode-dark" onclick="window.location.href='<?php echo $root_path; ?>users/edit_profile.php'">Editar Perfil</button>
        <button class="logout-btn mode-dark" onclick="window.location.href='<?php echo $root_path; ?>users/change_password.php'">Cambiar Contraseña</button>
    </div>
</main>


<?php include $root_path . 'includes/footer.php'; ?>
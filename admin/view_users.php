<?php
session_start();

if (!(isset($_SESSION['user_id']) && isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1)) {
    header("HTTP/1.1 403 Forbidden");
    include('../errors/403.php');
    exit();
}

include '../includes/header.php';
include '../includes/db.php';

try {
    $pdo = getDbConnection();
    $sql = "SELECT u.username, u.email, p.nombre, p.apellido, p.telefono, d.direccion_1, d.direccion_2, d.ciudad, d.provincia, d.codigo_postal FROM users u INNER JOIN user_perfiles p ON u.id = p.user_id LEFT JOIN direcciones d ON u.id = d.user_id";
    $stmt = $pdo->query($sql);
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<main>
    <h1>Lista de Usuarios</h1>
    <div class="table-container">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Nombre de Usuario</th>
                    <th>Email</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Teléfono</th>
                    <th>Dirección 1</th>
                    <th>Dirección 2</th>
                    <th>Ciudad</th>
                    <th>Provincia</th>
                    <th>Código Postal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($usuario['username']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['apellido']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['telefono']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['direccion_1']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['direccion_2']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['ciudad']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['provincia']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['codigo_postal']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<?php include $root_path . 'includes/footer.php'; ?>
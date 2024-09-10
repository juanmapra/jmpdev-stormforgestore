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
    $sql = "SELECT p.*, o.precio_oferta FROM productos p LEFT JOIN ofertas o ON p.id = o.producto_id";
    $stmt = $pdo->query($sql);
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<main>
    <h1>Lista de Productos</h1>
    <button type="submit" class="logout-btn mode-dark" onclick="window.location.href='<?php echo $root_path; ?>admin/add_product.php'">Añadir Producto <i class="bi bi-plus-square"></i></button>
    <div class="admin-view">
        <?php foreach ($productos as $producto) : ?>
            <div class="admin-view-item">
                <img src="../images/<?php echo htmlspecialchars($producto['imagen']) ?>" alt="">
                <div class="admin-view-item-info">
                    <h4><?php echo htmlspecialchars($producto['nombre']); ?></h4>
                    <?php if (isset($producto['precio_oferta'])) : ?>
                            <h4><u>Producto en oferta</u></h4>
                            <h4 class="precio-regular"><s>$<?php echo htmlspecialchars($producto['precio']); ?></s></h4>
                            <h4 class="precio-oferta">$<?php echo htmlspecialchars($producto['precio_oferta']); ?></h4>
                        <?php else : ?>
                            <h4>$<?php echo htmlspecialchars($producto['precio']); ?></h4>
                        <?php endif; ?>
                    <button type="submit" class="logout-btn mode-dark" onclick="window.location.href='<?php echo $root_path; ?>admin/edit_product.php?id=<?php echo htmlspecialchars($producto['id']); ?>'">Editar Producto<i class="bi bi-pencil-square"></i></button>
                    <button type="submit" class="logout-btn mode-dark delete-product-btn" data-product-id="<?php echo htmlspecialchars($producto['id']); ?>">Eliminar Producto<i class="bi bi-trash"></i></button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<div id="deleteModal" class="modal">
    <div class="modal-content">
        <p><b>Seguro que desea eliminar el producto?</b></p>
        <div class="modal-buttons">
            <button id="cancelDelete" class="modal-btn cancel-btn">Cancelar</button>
            <button id="confirmDelete" class="modal-btn confirm-btn">Confirmar</button>
        </div>
    </div>
</div>

<?php include $root_path . 'includes/footer.php'; ?>
<?php
session_start();

if (!(isset($_SESSION['user_id']) && isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1)) {
    header("HTTP/1.1 403 Forbidden");
    include('../errors/403.php');
    exit();
}


include '../includes/header.php';
require '../includes/db.php';

if (isset($_GET['id'])) {
    $productoId = $_GET['id'];

    function isProductOnSale($productoId) {
        try {
            $pdo = getDbConnection();
            $sql = "SELECT COUNT(*) FROM ofertas WHERE producto_id = :producto_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':producto_id', $productoId, PDO::PARAM_INT);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            return $count > 0;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    try {
        $pdo = getDbConnection();
        $sql = "SELECT p.*, o.precio_oferta 
        FROM productos p 
        LEFT JOIN ofertas o ON p.id = o.producto_id 
        WHERE p.id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $productoId);
        $stmt->execute();
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$producto) {
            exit("Producto no encontrado.");
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    header("Location: view_products.php");
    exit();
}
?>

<main>
    <div class="login-box">
        <h1>Editar Producto</h1>
        <form action="process_edit_product.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($producto['id']); ?>">
            <input type="text" name="name" placeholder="Nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
            <input type="number" name="price" placeholder="Precio" value="<?php echo htmlspecialchars($producto['precio']); ?>" required>
            <label for="on_sale">En Oferta:
            <input type="checkbox" name="on_sale" <?php if (isProductOnSale($productoId)) echo "checked"; ?>></label>
            <input type="number" name="sale_price" placeholder="Precio en Oferta" value="<?php echo htmlspecialchars($producto['precio_oferta']); ?>">
            <input type="file" name="image">
            <select name="category" id="" required>
                <option value="" disabled selected>Categoria</option>
                <option value="1">Notebook</option>
                <option value="2">Tablet</option>
                <option value="3">Smartphone</option>
                <option value="4">Display</option>
                <option value="5">Periferico</option>
                <option value="6">Otro</option>
            </select>
            <textarea name="description" placeholder="Descripción" required><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>
            <button type="submit">Guardar Cambios</button>
        </form>
    </div>
</main>

<?php include $root_path . 'includes/footer.php'; ?>
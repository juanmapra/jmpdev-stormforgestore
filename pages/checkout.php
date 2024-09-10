<?php
include '../includes/header.php';
include '../includes/db.php';

$cart_items = $_SESSION['cart'] ?? [];
$user_id = $_SESSION['user_id'] ?? null;


if (isset($_GET['id'])) {
    $producto_id = $_GET['id'];

    try {
        $stmt = getDbConnection()->prepare("SELECT p.*, o.precio_oferta FROM productos p LEFT JOIN ofertas o ON p.id = o.producto_id WHERE p.id = :id");
        $stmt->bindParam(':id', $producto_id);
        $stmt->execute();
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$producto) {
            header("Location: ../errors/404.php");
            exit();
        }

        if (isset($cart_items[$producto_id])) {
            $cart_items[$producto_id] += 1;
        } else {
            $cart_items[$producto_id] = 1;
        }

        $_SESSION['cart'] = $cart_items;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

if ($user_id) {
    $query = "SELECT p.nombre, p.apellido, d.direccion_1, d.direccion_2, d.ciudad, d.provincia, d.codigo_postal FROM user_perfiles p LEFT JOIN direcciones d ON p.user_id = d.user_id WHERE p.user_id = :user_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $user_address = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (!empty($cart_items)) {
    $placeholders = implode(',', array_fill(0, count($cart_items), '?'));
    $query = "SELECT id, nombre, precio, imagen FROM productos WHERE id IN ($placeholders)";
    $stmt = $pdo->prepare($query);
    $stmt->execute(array_keys($cart_items));
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<main>
    <div class="cart notEmpty">
        <h2>Resumen de la compra</h2>
        <div class="cart-items">
            <?php foreach ($productos as $producto) : ?>
                <div class="cart-item">
                    <img src="<?php echo htmlspecialchars($root_path) ?>images/<?php echo htmlspecialchars($producto['imagen']); ?>">
                    <div class='cart-item-info'>
                        <p><?php echo $producto['nombre']; ?></p>
                        <p>$<?php echo $producto['precio']; ?></p>
                        <p>Cantidad: <?php echo htmlspecialchars($cart_items[$producto['id']]); ?> </p>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php $total = 0;
            foreach ($productos as $producto) {
                $productId = $producto['id'];
                $quantity = $cart_items[$productId];
                $total += $producto['precio'] * $quantity;
            }
            ?>
            <h2>Total: $ <?php echo htmlspecialchars($total); ?> </h2>

        </div>
        <div class="cart-user">
            <h2>Dirección de envío:</h2>
            <div class="cart-item-info">
                <?php if ($user_address) : ?>
                    <p><b>Calle:</b> <?php echo htmlspecialchars($user_address['direccion_1']); ?></p>
                    <p><?php echo htmlspecialchars($user_address['direccion_2']); ?></p>
                    <p><b>Ciudad:</b> <?php echo htmlspecialchars($user_address['ciudad']); ?></p>
                    <p><b>Provincia:</b> <?php echo htmlspecialchars($user_address['provincia']); ?></p>
                    <p><b>Codigo postal:</b> <?php echo htmlspecialchars($user_address['codigo_postal']); ?></p>
                <?php else : ?>
                    <p>No se encontró dirección de envío.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="checkout-actions">
            <button onclick="window.location.href='<?php echo $root_path; ?>cart/view_cart.php'">Seguir viendo</button>
            <button onclick="finalizePurchase()">Finalizar compra</button>
        </div>
    </div>
</main>

<?php include $root_path . 'includes/footer.php'; ?>

<script>
    function finalizePurchase() {
        window.location.href = '<?php echo $root_path; ?>pages/purchase_complete.php';
    }
</script>
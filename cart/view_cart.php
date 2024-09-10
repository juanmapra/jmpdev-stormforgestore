<?php
include '../includes/header.php';
require '../includes/db.php';

$db = getDbConnection();
$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
echo "<main>";
if (empty($cartItems)) {
    echo "<div class='cart empty'>";
    echo "<h1>Carrito</h1>";
    echo "<p>Tu carrito esta vacio.</p>";
    echo "</div>";
} else {
    $productIds = array_keys($cartItems);
    $placeholders = implode(',', array_fill(0, count($productIds), '?'));
    $sql = "SELECT * FROM productos WHERE id IN ($placeholders)";
    $stmt = $db->prepare($sql);
    $i = 1;
    foreach ($productIds as $productId) {
        $stmt->bindValue($i++, $productId, PDO::PARAM_INT);
    }
    $stmt->execute();
    $products = $stmt->fetchAll();
    echo "<div class='cart notEmpty'>";
    echo "<h1>Carrito</h1>";
    foreach ($products as $product) {
        $productId = $product['id'];
        $quantity = $cartItems[$productId];
        echo "<div class='cart-item'>";
        echo "<img src='../images/" . htmlspecialchars($product['imagen']) . "'>";
        echo "<div class='cart-item-info'>";
        echo "<h2>" . htmlspecialchars($product['nombre']) . "</h2>";
        echo "<p>Price: $" . htmlspecialchars($product['precio']) . "</p>";
        echo "<p>Quantity: " . htmlspecialchars($quantity) . "</p>";
        echo "<form action='remove_from_cart.php' method='POST'>";
        echo "<input type='hidden' name='product_id' value=" . htmlspecialchars($productId) . ">";
        echo "<button type='submit'>Remover</button>";
        echo "</form>";
        echo "</div>";
        echo "</div>";
    }
    $total = 0;
    foreach ($products as $product) {
        $productId = $product['id'];
        $quantity = $cartItems[$productId];
        $total += $product['precio'] * $quantity;
    }
    echo "<h2>Total: $" . htmlspecialchars($total) . "</h2>";
    
    if(!empty($cartItems)){
        echo "<button class='finish-purchase-btn' onclick=\"window.location.href='" . $root_path . "pages/checkout.php'\"> Finalizar compra </button>";
    }
    
    echo "</div>";
}
echo "</main>";
include $root_path . 'includes/footer.php';
?>
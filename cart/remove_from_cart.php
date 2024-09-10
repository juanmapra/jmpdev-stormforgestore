<?php
session_start();

$productId = isset($_POST['product_id']) ? $_POST['product_id'] : null;

if ($productId !== null && isset($_SESSION['cart'][$productId])) {
    unset($_SESSION['cart'][$productId]);
}

header("Location: view_cart.php");
exit();
?>
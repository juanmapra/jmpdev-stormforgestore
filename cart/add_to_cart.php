<?php
session_start();

$productId = $_GET['id'];
$quantity = $_GET['quantity'];

if (!isset($_SESSION['cart'])){
    $_SESSION['cart'] = array();
}

if (isset($_SESSION['cart'][$productId])){
    $_SESSION['cart'][$productId] += $quantity;
}else{
    $_SESSION['cart'][$productId] = $quantity;
}

header("Location: view_cart.php");
exit();
?>
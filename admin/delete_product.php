<?php
session_start();

if (!(isset($_SESSION['user_id']) && isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1)) {
    header("HTTP/1.1 403 Forbidden");
    include('../errors/403.php');
    exit();
}

include '../includes/db.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $productId = $_GET['id'];

    try {
        $pdo = getDbConnection();
        $pdo->beginTransaction();

        $sqlDeleteOfertas = "DELETE FROM ofertas WHERE producto_id = :producto_id";
        $stmtDeleteOfertas = $pdo->prepare($sqlDeleteOfertas);
        $stmtDeleteOfertas->bindParam(':producto_id', $productId, PDO::PARAM_INT);
        $stmtDeleteOfertas->execute();

        $sqlDeleteProducto = "DELETE FROM productos WHERE id = :id";
        $stmtDeleteProducto = $pdo->prepare($sqlDeleteProducto);
        $stmtDeleteProducto->bindParam(':id', $productId, PDO::PARAM_INT);
        $stmtDeleteProducto->execute();

        $pdo->commit();
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    } catch (PDOException $e) {

        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
} else {
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}

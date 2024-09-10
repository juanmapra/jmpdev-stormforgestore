<?php
require '../includes/db.php';
include '../includes/header.php';



if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $searchQuery = $_POST['search_query'];

    try {
        $pdo = getDbConnection();
        $sql = "SELECT * FROM productos WHERE nombre LIKE :searchTerm1 OR descripcion LIKE :searchTerm2";
        $stmt = $pdo->prepare($sql);
        $searchTerm = '%' . $searchQuery . '%';
        $stmt->bindParam(':searchTerm1', $searchTerm, PDO::PARAM_STR);
        $stmt->bindParam(':searchTerm2', $searchTerm, PDO::PARAM_STR);
        $stmt->execute();
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e){
        echo "Error: " . $e->getMessage();
    }
} else {
    $productos = [];
}

include $root_path . 'pages/search.php';

include $root_path . 'includes/footer.php' ?>
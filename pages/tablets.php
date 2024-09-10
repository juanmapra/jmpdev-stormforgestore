<?php 

$root_path = '../';
include $root_path . 'includes/header.php';

require $root_path . 'includes/db.php';

try {
    $db = getDbConnection();

    $stmt = $db->prepare("SELECT p.*, o.precio_oferta FROM productos p LEFT JOIN ofertas o ON p.id = o.producto_id WHERE categoria_id = 2");
    $stmt->execute();
    $productos = $stmt->fetchAll();

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

include $root_path . 'pages/search.php';

include $root_path . 'includes/footer.php'; ?>
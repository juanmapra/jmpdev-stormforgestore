<?php
require '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    
    $onSale = isset($_POST['on_sale']) && $_POST['on_sale'] == 'on';
    $salePrice = $onSale ? $_POST['sale_price'] : null;

    $image = $_FILES['image']['name'];
    $target = "../images/" . basename($image);

    try {
        $pdo = getDbConnection();
        $pdo->beginTransaction();

        if (empty($image)) {
            $sqlGetCurrentImage = "SELECT imagen FROM productos WHERE id = :id";
            $stmtGetCurrentImage = $pdo->prepare($sqlGetCurrentImage);
            $stmtGetCurrentImage->bindParam(':id', $productId, PDO::PARAM_INT);
            $stmtGetCurrentImage->execute();
            $currentImage = $stmtGetCurrentImage->fetchColumn();
            $image = $currentImage;
        }

        // Update the productos table
        $sqlUpdateProducto = "UPDATE productos SET nombre = :nombre, precio = :precio, descripcion = :descripcion, categoria_id = :categoria_id, imagen = :imagen WHERE id = :id";
        $stmtUpdateProducto = $pdo->prepare($sqlUpdateProducto);
        $stmtUpdateProducto->bindParam(':nombre', $name, PDO::PARAM_STR);
        $stmtUpdateProducto->bindParam(':precio', $price, PDO::PARAM_STR);
        $stmtUpdateProducto->bindParam(':descripcion', $description, PDO::PARAM_STR);
        $stmtUpdateProducto->bindParam(':categoria_id', $category, PDO::PARAM_INT);
        $stmtUpdateProducto->bindParam(':imagen', $image, PDO::PARAM_STR);
        $stmtUpdateProducto->bindParam(':id', $productId, PDO::PARAM_INT);
        $stmtUpdateProducto->execute();

        // Handle the 'ofertas' table
        if ($onSale) {
            // Check if there is already an entry for this product in 'ofertas'
            $sqlCheckOferta = "SELECT COUNT(*) FROM ofertas WHERE producto_id = :producto_id";
            $stmtCheckOferta = $pdo->prepare($sqlCheckOferta);
            $stmtCheckOferta->bindParam(':producto_id', $productId, PDO::PARAM_INT);
            $stmtCheckOferta->execute();
            $count = $stmtCheckOferta->fetchColumn();

            if ($count > 0) {
                // Update existing 'ofertas' entry
                $sqlUpdateOferta = "UPDATE ofertas SET precio_oferta = :precio_oferta WHERE producto_id = :producto_id";
                $stmtUpdateOferta = $pdo->prepare($sqlUpdateOferta);
                $stmtUpdateOferta->bindParam(':precio_oferta', $salePrice, PDO::PARAM_STR);
                $stmtUpdateOferta->bindParam(':producto_id', $productId, PDO::PARAM_INT);
                $stmtUpdateOferta->execute();
            } else {
                // Insert new 'ofertas' entry
                $sqlInsertOferta = "INSERT INTO ofertas (producto_id, precio_oferta) VALUES (:producto_id, :precio_oferta)";
                $stmtInsertOferta = $pdo->prepare($sqlInsertOferta);
                $stmtInsertOferta->bindParam(':producto_id', $productId, PDO::PARAM_INT);
                $stmtInsertOferta->bindParam(':precio_oferta', $salePrice, PDO::PARAM_STR);
                $stmtInsertOferta->execute();
            }
        } else {
            // Remove any existing 'ofertas' entry if the product is not on sale
            $sqlDeleteOferta = "DELETE FROM ofertas WHERE producto_id = :producto_id";
            $stmtDeleteOferta = $pdo->prepare($sqlDeleteOferta);
            $stmtDeleteOferta->bindParam(':producto_id', $productId, PDO::PARAM_INT);
            $stmtDeleteOferta->execute();
        }

        $pdo->commit();

        if ($image && !empty($_FILES['image']['tmp_name']) && !move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            echo "Falló al subir imagen.";
        } else {
            header("Location: view_products.php");
            exit();
        }
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
}    else {
    header("Location: view_products.php");
    exit();
}
?>
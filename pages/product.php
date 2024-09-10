<?php
require '../includes/db.php';

if (isset($_GET['id'])) {
    $producto_id = $_GET['id'];

    try {
        $stmt = getDbConnection()->prepare("SELECT p.*, o.precio_oferta FROM productos p LEFT JOIN ofertas o ON p.id = o.producto_id WHERE p.id = :id");
        $stmt->bindParam(':id', $producto_id);
        $stmt->execute();
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$producto){
            header("Location: ../errors/404.php");
            exit();
        }
    } catch (PDOException $e){
        echo "Error: " . $e->getMessage();
    }
} else {
    header("Location: ../index.php");
    exit();
}
?>

<?php include '../includes/header.php'; ?>

<main>
        <div class="product">
            <div class="product-top">
                <div class="product-display">
                    <img src="<?php echo $root_path; ?>images/<?php echo htmlspecialchars($producto['imagen']); ?>" alt="">
                </div>
                <div class="product-main">
                    <h1 class="product-name"><?php echo htmlspecialchars($producto['nombre']); ?></h1>
                    <?php if (isset($producto['precio_oferta'])) : ?>
                                <div>
                                    <h1><u>Producto en oferta</u></h1>
                                    <h1 class="precio-regular"><s>$<?php echo htmlspecialchars($producto['precio']); ?></s></h1>
                                    <h1 class="precio-oferta">$<?php echo htmlspecialchars($producto['precio_oferta']); ?></h1>
                                </div>
                            <?php else : ?>
                                <h1>$<?php echo htmlspecialchars($producto['precio']); ?></h1>
                            <?php endif; ?>
                    <h3 class="product-stock">Stock disponible</h3>
                    <div class="product-btns">
                        <button class="btn-buynow" onclick="window.location.href='<?php echo $root_path; ?>pages/checkout.php?id=<?php echo $producto_id; ?>&quantity=1'">Comprar ahora</button>
                        <button class="btn-addtocart" onclick="window.location.href='<?php echo $root_path; ?>cart/add_to_cart.php?id=<?php echo $producto_id; ?>&quantity=1'">Agregar al carrito</button>
                    </div>
                </div>
            </div>
            <div class="product-description">
                <p>
                <?php echo htmlspecialchars($producto['descripcion']); ?>
                </p>
            </div>
        </div>
    </main>

<?php include '../includes/footer.php'; ?>
<?php
require $root_path . 'includes/db.php';

try {
    $db = getDbConnection();

    $stmt = $db->prepare("SELECT p.*, o.precio_oferta FROM productos p LEFT JOIN ofertas o ON p.id = o.producto_id WHERE o.precio_oferta IS NOT NULL LIMIT 4");
    $stmt->execute();
    $productos_en_oferta = $stmt->fetchAll();

    $stmt = $db->prepare("SELECT p.*, o.precio_oferta FROM productos p LEFT JOIN ofertas o ON p.id = o.producto_id WHERE categoria_id = 4 LIMIT 4 OFFSET 2");
    $stmt->execute();
    $populares1 = $stmt->fetchAll();

    $stmt = $db->prepare("SELECT p.*, o.precio_oferta FROM productos p LEFT JOIN ofertas o ON p.id = o.producto_id WHERE categoria_id = 5 LIMIT 4");
    $stmt->execute();
    $populares2 = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>


<div class="carousel">
    <div class="carousel-track">
        <div class="carousel-slide">
            <a href="<?php echo $root_path; ?>pages/laptops.php"><img src="<?php echo $root_path; ?>images/banner-slide1.png" alt="Slide 1"></a>
        </div>
        <div class="carousel-slide">
            <a href="<?php echo $root_path; ?>pages/phones.php"><img src="<?php echo $root_path; ?>images/banner-slide2.png" alt="Slide 2"></a>
        </div>
        <div class="carousel-slide">
            <a href="<?php echo $root_path; ?>pages/peripherals.php"><img src="<?php echo $root_path; ?>images/banner-slide3.png" alt="Slide 3"></a>
        </div>
    </div>
</div>


<div class="sales">
    <a href="pages/sales.php">
        <p>Ver todas las ofertas</p>
    </a>
    <div class="sales-card">
        <?php foreach ($productos_en_oferta as $producto) : ?>
            <a href="pages/product.php?id=<?php echo htmlspecialchars($producto['id']); ?>" class="card-link">
                <div class="card">
                    <div class="card-img"><img src="<?php echo $root_path; ?>images/<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>"></div>
                    <div class="card-info">
                        <h4><b><?php echo htmlspecialchars($producto['nombre']); ?></b></h4>
                        <?php if (isset($producto['precio_oferta'])) : ?>
                            <p class="precio-regular"><s>$<?php echo htmlspecialchars($producto['precio']); ?></s></p>
                            <p class="precio-oferta">$<?php echo htmlspecialchars($producto['precio_oferta']); ?></p>
                        <?php else : ?>
                            <p>$<?php echo htmlspecialchars($producto['precio']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<main>
    <section>
        <p>Productos mas vistos</p>
        <div class="sales-card">
            <?php foreach ($populares1 as $popular1) : ?>
                <a href="pages/product.php?id=<?php echo htmlspecialchars($popular1['id']); ?>" class="card-link">
                    <div class="card">
                        <div class="card-img"><img src="<?php echo $root_path; ?>images/<?php echo htmlspecialchars($popular1['imagen']); ?>" alt="<?php echo htmlspecialchars($popular1['nombre']); ?>"></div>
                        <div class="card-info">
                            <h4><b><?php echo htmlspecialchars($popular1['nombre']); ?></b></h4>
                            <?php if (isset($popular1['precio_oferta'])) : ?>
                                <p class="precio-regular"><s>$<?php echo htmlspecialchars($popular1['precio']); ?></s></p>
                                <p class="precio-oferta">$<?php echo htmlspecialchars($popular1['precio_oferta']); ?></p>
                            <?php else : ?>
                                <p>$<?php echo htmlspecialchars($popular1['precio']); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </section>

    <div class="categories-explore">

        <a href="<?php echo $root_path; ?>pages/laptops.php"><img src="<?php echo $root_path; ?>images/banner-laptop.png" alt=""></a>
        <a href="<?php echo $root_path; ?>pages/tablets.php"><img src="<?php echo $root_path; ?>images/banner-tablet.png" alt=""></a>
        <a href="<?php echo $root_path; ?>pages/phones.php"><img src="<?php echo $root_path; ?>images/banner-phone.png" alt=""></a>
        <a href="<?php echo $root_path; ?>pages/screens.php"><img src="<?php echo $root_path; ?>images/banner-display.png" alt=""></a>
        <a href="<?php echo $root_path; ?>pages/peripherals.php"><img src="<?php echo $root_path; ?>images/banner-periph.png" alt=""></a>
        <a href="<?php echo $root_path; ?>pages/other.php"><img src="<?php echo $root_path; ?>images/banner-other.png" alt=""></a>

    </div>

    <section>
        <p>Productos mas vistos</p>
        <div class="sales-card">
            <?php foreach ($populares2 as $popular2) : ?>
                <a href="pages/product.php?id=<?php echo htmlspecialchars($popular2['id']); ?>" class="card-link">
                    <div class="card">
                        <div class="card-img"><img src="<?php echo $root_path; ?>images/<?php echo htmlspecialchars($popular2['imagen']); ?>" alt="<?php echo htmlspecialchars($popular2['nombre']); ?>"></div>
                        <div class="card-info">
                            <h4><b><?php echo htmlspecialchars($popular2['nombre']); ?></b></h4>
                            <?php if (isset($popular2['precio_oferta'])) : ?>
                                <p class="precio-regular"><s>$<?php echo htmlspecialchars($popular2['precio']); ?></s></p>
                                <p class="precio-oferta">$<?php echo htmlspecialchars($popular2['precio_oferta']); ?></p>
                            <?php else : ?>
                                <p>$<?php echo htmlspecialchars($popular2['precio']); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </section>
</main>
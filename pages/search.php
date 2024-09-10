<main>
    <div class="product-search">
        <div class="product-search-result">
            <div class="search-card">
                <?php if (!empty($productos)) : ?>
                    <?php foreach ($productos as $producto) : ?>
                        <a href="product.php?id=<?php echo htmlspecialchars($producto['id']); ?>" class="card-link">
                            <div class="card">
                                <div class="card-img">
                                    <img src="../images/<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                                </div>
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
                <?php else : ?>
                    <h1>No se encontraron productos.</h1>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>
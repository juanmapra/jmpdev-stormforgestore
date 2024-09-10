<?php
// Include necessary files and start session
include '../includes/header.php';
include '../includes/db.php';

// Clear the cart
unset($_SESSION['cart']);

?>
<main>
    <div class="cart empty">
        <h1>¡Gracias por tu compra!</h1>
        <button onclick="window.location.href='<?php echo $root_path; ?>index.php'">Volver al inicio</button>
    </div>
</main>

<?php include $root_path . '/includes/footer.php' ?>
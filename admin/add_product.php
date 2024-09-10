<?php
session_start();

if (!(isset($_SESSION['user_id']) && isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1)) {
    header("HTTP/1.1 403 Forbidden");
    include('../errors/403.php');
    exit();
}


include '../includes/header.php';
?>

<main>
    <div class="login-box">
        <h1>Añadir Producto</h1>
        <form action="process_add_product.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="productName" placeholder="Nombre" required>
            <input type="number" name="productPrice" placeholder="Precio" required>
            <input type="file" name="productImage" accept="image/*">
            <select name="categoryId" id="" required>
                <option value="" disabled selected>Categoria</option>
                <option value="1">Notebook</option>
                <option value="2">Tablet</option>
                <option value="3">Smartphone</option>
                <option value="4">Display</option>
                <option value="5">Periferico</option>
                <option value="6">Otro</option>
            </select>
            <textarea name="productDescription" placeholder="Descripción" required></textarea>
            <button type="submit">Añadir Producto</button>
        </form>
    </div>
</main>

<?php include $root_path . 'includes/footer.php'; ?>
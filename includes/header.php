<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$root_path = '';
if (basename($_SERVER['SCRIPT_NAME']) == 'index.php') {
    $root_path = '';
} else {
    $root_path = '../';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StormForge</title>
    <link rel="stylesheet" href="<?php echo $root_path; ?>css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $root_path; ?>images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $root_path; ?>images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $root_path; ?>images/favicon-16x16.png">
    <link rel="manifest" href="<?php echo $root_path; ?>images/site.webmanifest">
</head>

<body>
    <div class="wrapper">
        <header>
            <div class="navbar">
                <div class="navbar-top">
                    <a href="<?php echo $root_path; ?>index.php">
                        <div class="logo">
                            <img src="<?php echo $root_path; ?>images/logo.png" alt="Logo" class="logo-img">
                            <img src="<?php echo $root_path; ?>images/logo-name.png" alt="" id="logo-name">
                        </div>
                    </a>
                    <form action="<?php echo $root_path; ?>pages/search_results.php" method="POST" class="search-bar">
                        <input type="text" name="search_query" placeholder="Buscar entre productos...">
                        <button type="submit"><i class="bi bi-search"></i></button>
                    </form>
                    <div class="login-cart">
                        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 2) : ?>
                            <button class="profile-btn" onclick="window.location.href='<?php echo $root_path ?>users/profile.php'">Perfil<i class="bi bi-person"></i></button>
                            <button class="logout-btn" onclick="window.location.href='<?php echo $root_path; ?>users/logout.php'">Salir<i class="bi bi-box-arrow-right"></i></button>
                        <?php elseif (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1) : ?>
                            <button class="profile-btn" onclick="window.location.href='<?php echo $root_path; ?>admin/view_products.php'">Ver Productos<i class="bi bi-card-list"></i></button>
                            <button class="logout-btn" onclick="window.location.href='<?php echo $root_path; ?>admin/view_users.php'">Ver Usuarios<i class="bi bi-person"></i></button>
                            <button class="logout-btn" onclick="window.location.href='<?php echo $root_path; ?>users/logout.php'">Salir<i class="bi bi-box-arrow-right"></i></button>
                        <?php else : ?>
                            <button class="login-btn" onclick="window.location.href='<?php echo $root_path; ?>users/profile.php'">Iniciar Sesión<i class="bi bi-box-arrow-in-left"></i></button>
                        <?php endif; ?>
                        <button class="cart-btn" onclick="window.location.href='<?php echo $root_path ?>cart/view_cart.php'"><i class="bi bi-cart2"></i></button>
                    </div>
                </div>
                <div class="navbar-links">
                    <ul>
                        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 2) : ?>
                            <a href="<?php echo $root_path ?>users/profile.php" class="user-links">
                                <li>Perfil<i class="bi bi-person"></i></li>
                            </a>
                            <a href="<?php echo $root_path ?>users/logout.php" class="user-links">
                                <li>Salir<i class="bi bi-box-arrow-right"></i></li>
                            </a>
                            <?php elseif (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1) : ?>
                                <a href="<?php echo $root_path ?>users/view_products.php" class="user-links">
                                <li>Ver Productos<i class="bi bi-card-list"></i></li>
                            </a>
                            <a href="<?php echo $root_path ?>users/view_users.php" class="user-links">
                                <li>Ver Usuarios<i class="bi bi-person"></i></li>
                            </a>
                            <a href="<?php echo $root_path ?>users/logout.php" class="user-links">
                                <li>Salir<i class="bi bi-box-arrow-right"></i></li>
                            </a>
                            <?php else : ?>
                                <a href="<?php echo $root_path; ?>users/profile.php" class="user-links">
                                <li>Iniciar Sesión<i class="bi bi-box-arrow-in-left"></i></li>
                                </a>
                                <?php endif; ?>
                                <a href="<?php echo $root_path ?>cart/view_cart.php" class="user-links">
                                    <li>Carrito<i class="bi bi-cart2"></i></li>
                                </a>
                        <a href="<?php echo $root_path; ?>pages/laptops.php">
                            <li>Notebooks</li>
                        </a>
                        <a href="<?php echo $root_path; ?>pages/tablets.php">
                            <li>Tablets</li>
                        </a>
                        <a href="<?php echo $root_path; ?>pages/phones.php">
                            <li>Smartphones</li>
                        </a>
                        <a href="<?php echo $root_path; ?>pages/screens.php">
                            <li>Displays</li>
                        </a>
                        <a href="<?php echo $root_path; ?>pages/peripherals.php">
                            <li>Periféricos</li>
                        </a>
                        <a href="<?php echo $root_path; ?>pages/other.php">
                            <li>Otro</li>
                        </a>
                    </ul>
                </div>
            </div>
            <button class="menu-toggle" id="menu-toggle">☰</button>
        </header>
<?php
require '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['productName'];
    $price = $_POST['productPrice'];
    $description = $_POST['productDescription'];
    $category = $_POST['categoryId'];

    $image = $_FILES['productImage']['name'];
    $target = "../images/" . basename($image);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["productImage"]["tmp_name"]);

    if($check !== false){
        echo "El archivo es una imagen - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "El archivo no es una imagen.";
        $uploadOk = 0;
    }
    
    if(file_exists($target)){
        echo "El archivo ya existe.";
        $uploadOk = 0;
    }

    if($_FILES["productImage"]["size"] > 500000){
        echo "El archivo es demasiado grande.";
        $uploadOk = 0;
    }

    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "webp"){
        echo "Tipo de archivo no soportado.";
        $uploadOk = 0;
    }

    if($uploadOk == 0){
        echo "Error subiendo el archivo.";
    } else {
        if(move_uploaded_file($_FILES["productImage"]["tmp_name"], $target)){
            echo "Imagen " . htmlspecialchars( basename( $_FILES["productImage"]["name"])). " subida.";
        } else {
            echo "Error subiendo el archivo.";
        }
    }

    if($uploadOk == 0 || empty($_FILES["productImage"]["name"])){
        $image = "default.png";
    } else {
        $image = basename($_FILES["productImage"]["name"]);
    }

    try {
        $pdo = getDbConnection();
        $sql = "INSERT INTO productos (nombre, precio, imagen, descripcion, categoria_id) VALUES (:name, :price, :image, :description, :category)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':category', $category);
        $stmt->execute();

        header("Location: view_products.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} ?>
<?php
session_start();
require '../includes/db.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    try{
        $pdo = getDbConnection();

        $sqlUpdate = "UPDATE user_perfiles p INNER JOIN direcciones d ON p.user_id = d.user_id SET p.nombre = :nombre, p.apellido = :apellido, p.telefono = :telefono, d.direccion_1 = :direccion_1, d.direccion_2 = :direccion_2, d.ciudad = :ciudad, d.provincia = :provincia, d.codigo_postal = :codigo_postal WHERE p.user_id = :userId";

        $stmtUpdate = $pdo->prepare($sqlUpdate);

        $stmtUpdate->bindParam(':nombre', $_POST['nombre']);
        $stmtUpdate->bindParam(':apellido', $_POST['apellido']);
        $stmtUpdate->bindParam(':telefono', $_POST['telefono']);
        $stmtUpdate->bindParam(':direccion_1', $_POST['direccion_1']);
        $stmtUpdate->bindParam(':direccion_2', $_POST['direccion_2']);
        $stmtUpdate->bindParam(':ciudad', $_POST['ciudad']);
        $stmtUpdate->bindParam(':provincia', $_POST['provincia']);
        $stmtUpdate->bindParam(':codigo_postal', $_POST['codigo_postal']);
        $stmtUpdate->bindParam(':userId', $_SESSION['user_id']);

        $stmtUpdate->execute();

        header("Location: profile.php");
        exit();
    } catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }
}
?>
<?php
session_start();
require '../includes/db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    try{
        $pdo = getDbConnection();
        $sqlCheck = "SELECT password FROM users WHERE id = :userId";

        $stmtCheck = $pdo->prepare($sqlCheck);
        $stmtCheck->bindParam(':userId', $_SESSION['user_id']);
        $stmtCheck->execute();
        $user = $stmtCheck->fetch(PDO::FETCH_ASSOC);
        if(!$user || !password_verify($_POST['current_password'], $user['password'])) {
            exit("Contraseña actual incorrecta.");
        }

        if($_POST['new_password'] !== $_POST['confirm_password']){
            exit("Las contraseñas no coinciden.");
        }

        $newPasswordHash = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        $sqlUpdate = "UPDATE users SET password = :newPassword WHERE id = :userId";
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->bindParam(':newPassword', $newPasswordHash);
        $stmtUpdate->bindParam(':userId', $_SESSION['user_id']);
        $stmtUpdate->execute();

        $_SESSION = array();
        session_destroy();

        header("Location: login.php");
        exit();
    } catch (PDOException $e){
        echo "Error: " . $e->getMessage();
    }
}
?>
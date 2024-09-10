<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    require '../includes/db.php';

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT id, username, password, rol_id FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user){
        if(password_verify($password, $user['password'])){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_role'] = $user['rol_id'];

            header("Location: ../index.php");
            exit();
        }else{
            echo "Email o contraseña incorrecto.";
        }
    }else{
        echo "Usuario no encontrado.";
    }
}
?>
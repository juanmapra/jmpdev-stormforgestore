<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    require '../includes/db.php';

    $email = $_POST['email'];
    $password = $_POST['password'];
    $repeatPassword = $_POST['repeatPassword'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $phoneNumber = $_POST['phoneNumber'];
    $street1 = $_POST['street1'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $postalCode = $_POST['postalCode'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        exit("Formato de email incorrecto.");
    }

    if($password !== $repeatPassword){
        exit("Las contraseñas no son iguales.");
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try{
        $pdo->beginTransaction();

        $usernameBase = str_replace(' ', '', $firstName);
        $username = $usernameBase . mt_rand(1000, 9999);

        $sqlUsers = "INSERT INTO users (username, email, password, rol_id) VALUES (:username, :email, :password, 2)";
        $stmtUsers = $pdo->prepare($sqlUsers);
        $stmtUsers->bindParam(':username', $username);
        $stmtUsers->bindParam(':email', $email);
        $stmtUsers->bindParam(':password', $hashedPassword);
        $stmtUsers->execute();
        $userId = $pdo->lastInsertId();

        $sqlProfiles = "INSERT INTO user_perfiles (user_id, nombre, apellido, telefono) VALUES (:userId, :firstName, :lastName, :phoneNumber)";
        $stmtProfiles = $pdo->prepare($sqlProfiles);
        $stmtProfiles->bindParam(':userId', $userId);
        $stmtProfiles->bindParam(':firstName', $firstName);
        $stmtProfiles->bindParam(':lastName', $lastName);
        $stmtProfiles->bindParam(':phoneNumber', $phoneNumber);
        $stmtProfiles->execute();

        $sqlLocations = "INSERT INTO direcciones (user_id, direccion_1, ciudad, provincia, codigo_postal, pais) VALUES (:userId, :street1, :city, :state, :postalCode)";
        $stmtLocations = $pdo->prepare($sqlLocations);
        $stmtLocations->bindParam(':userId', $userId);
        $stmtLocations->bindParam(':street1', $street1);
        $stmtLocations->bindParam(':city', $city);
        $stmtLocations->bindParam(':state', $state);
        $stmtLocations->bindParam(':postalCode', $postalCode);
        $stmtLocations->execute();

        $pdo->commit();
        
        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['username'] = $username;
        $_SESSION['rol_id'] = 2;

        header("Location: profile.php");
        exit();
    } catch (PDOException $e){
        $pdo->rollback();
        echo "Error: " . $e->getMessage();
    }
}
?>
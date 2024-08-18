<?php
session_start();
require_once 'Database.php';
require_once '../Models/Tenants.php';
require_once '../Models/Landlords.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $errors['login'] = "Please fill in all fields.";
    } else {
        $database = new Database();
        $db = $database->getConnection();
        $tenants = new Tenants($db);

        $foundUser = $tenants->findByEmail($email);

        if ($foundUser && $tenants->verifyPassword($password, $foundUser['password'])) {
            // Successful login
            $_SESSION['user_id'] = $foundUser['id'];
            $_SESSION['success'] = "Logged in successfully!";
            header("Location: ../tenants/index");
            exit();
        } else {
            $errors['login'] = "Invalid email or password.";
        }
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: login.php");
        exit();
    }
}

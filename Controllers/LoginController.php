<?php
session_start();
require_once 'Database.php';
require_once '../Models/Tenants.php';
require_once '../Models/Landlords.php'; // Include Landlords model

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $errors['login'] = "Please fill in all fields.";
    } else {
        $database = new Database();
        $db = $database->getConnection();

        // Check if the user is a tenant
        $tenants = new Tenants($db);
        $foundTenant = $tenants->findByEmail($email);

        if ($foundTenant) {
            if ($tenants->verifyPassword($password, $foundTenant['password'])) {
                // Successful tenant login
                $_SESSION['user_id'] = $foundTenant['id'];
                $_SESSION['user_role'] = 'tenant';
                $_SESSION['success'] = "Logged in successfully as a tenant!";
                header("Location: ../tenants/index");
                exit();
            } else {
                // Password is incorrect
                $errors['login'] = "Invalid email or password.";
            }
        }

        // If not a tenant, check if the user is a landlord
        $landlords = new Landlords($db);
        $foundLandlord = $landlords->findByEmail($email);

        if ($foundLandlord) {
            if ($landlords->verifyPassword($password, $foundLandlord['password'])) {
                // Successful landlord login
                $_SESSION['user_id'] = $foundLandlord['id'];
                $_SESSION['user_role'] = 'landlord';
                $_SESSION['success'] = "Logged in successfully as a landlord!";
                header("Location: ../landlords/index");
                exit();
            } else {
                // Password is incorrect
                $errors['login'] = "Invalid email or password.";
            }
        }

        // If neither a tenant nor a landlord is found with the provided email
        if (!$foundTenant && !$foundLandlord) {
            $errors['login'] = "Invalid email or password.";
        }
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['form_data'] = $_POST;
        header("Location: ../login.php");
        exit();
    }
}

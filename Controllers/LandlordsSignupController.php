<?php
session_start();
require_once 'Database.php';
require_once '../Models/Landlords.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $database = new Database();
    $db = $database->getConnection();
    $landlords = new Landlords($db);

    // Retrieve form data and trim whitespace
    $landlords->fname = trim($_POST['fname']);
    $landlords->mname = trim($_POST['mname']);
    $landlords->lname = trim($_POST['lname']);
    $landlords->email = trim($_POST['email']);
    $landlords->address = trim($_POST['address']);
    $landlords->phone = trim($_POST['phone']);
    $password = trim($_POST['password']);
    $confirm = trim($_POST['confirm']);

    // Validate input fields
    if (empty($landlords->fname)) {
        $errors['fname'] = "First name is required";
    }

    if (empty($landlords->lname)) {
        $errors['lname'] = "Last name is required";
    }

    if (empty($landlords->email)) {
        $errors['email'] = "Email is required";
    }

    if (empty($landlords->address)) {
        $errors['address'] = "Address is required";
    }

    if (empty($landlords->phone)) {
        $errors['phone'] = "Phone number is required";
    }

    if (empty($password)) {
        $errors['password'] = "Password is required";
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
        $errors['password'] = "Password must have at least 8 characters, including an uppercase letter, a number, and a special character.";
    }

    if (empty($confirm)) {
        $errors['confirm'] = "Confirm password is required";
    } elseif ($password !== $confirm) {
        $errors['confirm'] = "Passwords do not match";
    }

    // Only hash the password and create the user if no errors
    if (empty($errors)) {
        $landlords->password = password_hash($password, PASSWORD_BCRYPT); // Hash the password

        if ($landlords->create()) {
            $_SESSION['success'] = "User created successfully!";
            header("Location: ../landlords/index"); // Redirect to a success page or another page
            exit();
        } else {
            $_SESSION['errors']['database'] = "Failed to create user.";
            header("Location: ../landlords/signup");
            exit();
        }
    } else {
        // Store errors and form data in session
        $_SESSION['errors'] = $errors;
        $_SESSION['form_data'] = $_POST;
        header("Location: ../landlords/signup");
        exit();
    }
}

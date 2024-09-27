<?php
session_start();
require_once 'Database.php';
require_once '../Models/Admins.php';

$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database();
    $db = $database->getConnection();
    $admins = new Admins($db);

    // Retrieve form data and trim whitespace
    $admins->fname = trim($_POST['fname']);
    $admins->mname = trim($_POST['mname']);
    $admins->lname = trim($_POST['lname']);
    $admins->email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm = trim($_POST['confirm']);

    // Validate input fields
    if (empty($admins->fname)) {
        $errors['fname'] = "First name is required";
    }
    if (empty($admins->lname)) {
        $errors['lname'] = "Last name is required";
    }
    if (empty($admins->email)) {
        $errors['email'] = "Email is required";
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

    if (empty($errors)) {
        $admins->password = password_hash($password, PASSWORD_DEFAULT); // Hash the password

        if ($admins->create()) {
            // After successful creation, fetch the admin data
            $foundAdmin = $admins->findByEmail($admins->email);
            if ($foundAdmin) {
                $_SESSION['user_id'] = $foundAdmin['id'];
                $_SESSION['user_role'] = 'admin';
                $_SESSION['success'] = "User created successfully!";
                header("Location: ../admin/index"); // Redirect to admin index page
                exit();
            } else {
                $_SESSION['errors']['database'] = "Failed to fetch the newly created user.";
                header("Location: ../admin-signup");
                exit();
            }
        } else {
            // If creation fails, store errors
            $_SESSION['errors'] = ['database' => "Failed to create user. Please try again."];
            $_SESSION['form_data'] = $_POST;
            header("Location: ../admin-signup");
            exit();
        }
    } else {
        // If there are validation errors, store them and redirect
        $_SESSION['errors'] = $errors;
        $_SESSION['form_data'] = $_POST;
        header("Location: ../admin-signup");
        exit();
    }
}

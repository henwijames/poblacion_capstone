<?php
session_start();
require_once 'Database.php';
require_once '../Models/Tenants.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $database = new Database();
    $db = $database->getConnection();
    $tenants = new Tenants($db);

    // Retrieve form data and trim whitespace
    $tenants->fname = trim($_POST['fname']);
    $tenants->mname = trim($_POST['mname']);
    $tenants->lname = trim($_POST['lname']);
    $tenants->email = trim($_POST['email']);
    $tenants->address = trim($_POST['address']);
    $tenants->phone = trim($_POST['phone']);
    $tenants->validid = trim($_POST['validid']);
    $password = trim($_POST['password']);
    $confirm = trim($_POST['confirm']);

    // Validate input fields
    if (empty($tenants->fname)) {
        $errors['fname'] = "First name is required";
    }

    if (empty($tenants->lname)) {
        $errors['lname'] = "Last name is required";
    }

    if (empty($tenants->email)) {
        $errors['email'] = "Email is required";
    }

    if (empty($tenants->address)) {
        $errors['address'] = "Address is required";
    }

    if (empty($tenants->phone)) {
        $errors['phone'] = "Phone number is required";
    }

    if (empty($tenants->validid)) {
        $errors['validid'] = "Valid ID is required";
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
        $tenants->password = password_hash($password, PASSWORD_BCRYPT); // Hash the password

        if ($tenants->create()) {
            // Auto-login after successful signup
            $foundUser = $tenants->findByEmail($tenants->email);
            if ($foundUser && $tenants->verifyPassword($password, $foundUser['password'])) {
                // Successful login
                $_SESSION['user_id'] = $foundUser['id'];
                $_SESSION['success'] = "User created and logged in successfully!";
                header("Location: ../tenants/index"); // Redirect to the tenant's dashboard or homepage
                exit();
            } else {
                $_SESSION['errors']['login'] = "Login failed after signup.";
            }
        } else {
            $_SESSION['errors']['database'] = "Failed to create user.";
        }
    }

    // If there are errors, or if login failed after signup
    $_SESSION['errors'] = $errors;
    $_SESSION['form_data'] = $_POST;
    header("Location: ../tenants/signup.php");
    exit();
}

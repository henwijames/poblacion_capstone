<?php
session_start();
require_once 'Database.php';
require_once '../Models/Tenants.php';
require_once '../Models/Semaphore.php';

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

    if ($tenants->checkEmailExists($tenants->email)) {
        $_SESSION['same_email'] = "Email is already used. Please try another email.";
        header("Location: ../signupTenants");
        exit();
    }

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

        // Generate a 6-digit verification code
        $verificationCode = mt_rand(100000, 999999);

        // Set the expiration time for the code (5 minutes from now)
        $expiresAt = date('Y-m-d H:i:s', strtotime('+5 minutes'));

        // Assign the verification code and expiration to the tenant model
        $tenants->verification_code = $verificationCode;
        $tenants->verification_expires_at = $expiresAt;

        if ($tenants->create()) {
            sendVerificationSMS($tenants->phone, $verificationCode); // Send the verification code via SMS

            // Successful login
            $_SESSION['user_id'] = $tenants->id;
            $_SESSION['email'] = $tenants->email;
            $_SESSION['success'] = "User created successfully! Please verify your phone number.";
            header("Location: ../account_verify"); // Redirect to the tenant's dashboard or homepage
            exit();
        } else {
            $_SESSION['errors']['database'] = "Failed to create user.";
            header("Location: ../signupTenants");
        }
    }

    // If there are errors, or if login failed after signup
    $_SESSION['errors'] = $errors;
    $_SESSION['form_data'] = $_POST;
    header("Location: ../signupTenants");
    exit();
}

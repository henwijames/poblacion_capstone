<?php
session_start();
require_once 'Database.php';
require_once '../Models/Landlords.php';
require_once '../Models/Semaphore.php';

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
    $landlords->property_name = trim($_POST['property_name']);
    $landlords->phone = trim($_POST['phone']);
    $password = trim($_POST['password']);
    $confirm = trim($_POST['confirm']);

    if ($landlords->checkEmailExists($landlords->email) &&  $landlords->checkNumberExist($landlords->phone)) {
        $_SESSION['same'] = "Email and Number is already used. Please try another email and mobile number.";
        header("Location: ../landlordSignup");
        exit();
    }

    if ($landlords->checkEmailExists($landlords->email)) {
        $_SESSION['same_email'] = "Email is already used. Please try another email.";
        header("Location: ../landlordSignup");
        exit();
    }
    if ($landlords->checkNumberExist($landlords->phone)) {
        $_SESSION['same_number'] = "Number is already used. Please try another email.";
        header("Location: ../landlordSignup");
        exit();
    }



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
    if (empty($landlords->property_name)) {
        $errors['address'] = "Business Property Name is required";
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

        $verificationCode = mt_rand(100000, 999999);
        date_default_timezone_set('Asia/Manila');

        // Set the expiration time for the code (5 minutes from now)
        $expiresAt = date('Y-m-d H:i:s', strtotime('+10 minutes'));
        $landlords->verification_code = $verificationCode;
        $landlords->verification_expires_at = $expiresAt;

        if ($landlords->create()) {
            sendVerificationSMS($landlords->phone, $verificationCode);

            $_SESSION['user_id']  = $landlords->id;
            $_SESSION['email']  =  $landlords->email;
            $_SESSION['user_role'] = 'landlord';
            $_SESSION['mobile_verified']  = false;
            $_SESSION['success'] = "User created successfully! Please verify your phone number.";
            header("Location:  ../account_verify");
            exit();
        } else {
            $_SESSION['errors']['database'] = "Failed to create user.";
            header("Location: ../landlordsSignup");
        }
    }

    $_SESSION['errors'] = $errors;
    $_SESSION['form_data'] = $_POST;
    header("Location: ../landlordSignup");
    exit();
}

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
    $password = trim($_POST['password']);
    $confirm = trim($_POST['confirm']);

    if ($tenants->checkEmailExists($tenants->email) &&  $tenants->checkNumberExist($tenants->phone)) {
        $_SESSION['same'] = "Email and Number is already used. Please try another email and mobile number.";
        header("Location: ../signupTenants");
        exit();
    }

    if ($tenants->checkEmailExists($tenants->email)) {
        $_SESSION['same_email'] = "Email is already used. Please try another email.";
        header("Location: ../signupTenants");
        exit();
    }
    if ($tenants->checkNumberExist($tenants->phone)) {
        $_SESSION['same_number'] = "Number is already used. Please try another email.";
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

    // Check if a file was uploaded and process it
    if (isset($_FILES['validid']) && $_FILES['validid']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['validid']['tmp_name'];
        $fileName = $_FILES['validid']['name'];
        $fileSize = $_FILES['validid']['size'];
        $fileType = $_FILES['validid']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedfileExtensions = array('jpg', 'jpeg', 'png', 'pdf');
        if (in_array($fileExtension, $allowedfileExtensions)) {
            // Create a unique name for the image and save it
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $uploadFileDir = '../tenants/Controller/uploads/';
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $tenants->validid = $newFileName; // Save the filename in the database
            } else {
                $errors['validid'] = 'File could not be uploaded. Try again.';
            }
        } else {
            $errors['validid'] = 'Invalid file type. Only JPG, JPEG, PNG, and PDF are allowed.';
        }
    } else {
        $errors['validid'] = 'Please upload a valid ID image.';
    }

    // Only hash the password and create the user if no errors
    if (empty($errors)) {
        $tenants->password = password_hash($password, PASSWORD_BCRYPT); // Hash the password

        // Generate a 6-digit verification code
        $verificationCode = mt_rand(100000, 999999);
        date_default_timezone_set('Asia/Manila');

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
            $_SESSION['user_role'] = 'tenant';
            $_SESSION['mobile_verified'] = false;
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

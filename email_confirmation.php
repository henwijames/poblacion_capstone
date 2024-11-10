<?php
session_start();
require 'Controllers/Database.php';
require 'Models/Tenants.php';
require 'Models/Landlords.php';

$database = new Database();
$db = $database->getConnection();
$tenants = new Tenants($db);
$landlords = new Landlords($db);

// Fetch user role from session
$user_role = $_SESSION['user_role'] ?? null;
$email = $_SESSION['email'] ?? null;

if (!$email || !$user_role) {
    die("User is not logged in.");
}

if ($user_role === 'tenant') {
    $tenant = new Tenants($db);
    $tenantDetails = $tenant->getVerificationStatusByEmail($email);
    $email_verified = $tenantDetails['email_verified'] ?? 0;
    $mobile_verified = $tenantDetails['mobile_verified'] ?? 0;
} elseif ($user_role === 'landlord') {
    $landlord = new Landlords($db);
    $landlordDetails = $landlord->getVerificationStatusByEmail($email);
    $email_verified = $landlordDetails['email_verified'] ?? 0;
    $mobile_verified = $landlordDetails['mobile_verified'] ?? 0;
} else {
    die("Invalid user role.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($email_verified == 1 && $mobile_verified == 1) {
        // Redirect based on user role
        if ($user_role == 'tenant') {
            header("Location: tenants/");
            exit();
        } elseif ($user_role == 'landlord') {
            header("Location: landlords/");
            exit();
        } else {
            $_SESSION['errors']['role'] = "Invalid user role.";
            header("Location: email_verification.php");
            exit();
        }
    } else {
        $_SESSION['errors']['verification'] = "Your email or mobile is not verified.";
        header("Location: email_verification.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Confirmation</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/aos.css">

    <!-- FontAwesome CDN -->
    <script src="https://kit.fontawesome.com/f284e8c7c2.js" crossorigin="anonymous"></script>

    <!-- JQuery File -->
    <script src="./assets/js/jquery-3.7.1.min.js"></script>
</head>

<body class="flex items-center justify-center" style="background-image: url('assets/img/volcano.jpg'); background-repeat: no-repeat; background-size: cover; background-position: center;  height: 100vh;">
    <div class="bg-white p-8 rounded shadow-md max-w-sm w-[300px] md:w-[800px] text-center">
        <img src="assets/img/email.svg" alt="email illustration">
        <h1 class="text-2xl font-semibold mt-4 text-gray-800 mb-4">Email Verification Status</h1>

        <?php if (isset($_SESSION['success'])): ?>
            <p class="text-green-600 font-medium">
                <?php echo $_SESSION['success'];
                unset($_SESSION['success']); ?>
            </p>
        <?php elseif (isset($_SESSION['errors']['token'])): ?>
            <p class="text-red-600 font-medium">
                <?php echo $_SESSION['errors']['token'];
                unset($_SESSION['errors']['token']); ?>
            </p>
        <?php endif; ?>

        <form method="POST">
            <button type="submit" class="btn bg-primary w-full">Proceed</button>
        </form>
    </div>
</body>

</html>
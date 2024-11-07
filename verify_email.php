<?php
session_start();
require_once 'Controllers/Database.php';
require_once 'Models/Tenants.php';
require 'vendor/autoload.php'; // Load PHPMailer if using Composer

// Check if the token is passed in the URL
if (isset($_GET['token'])) {
    $database = new Database();
    $db = $database->getConnection();
    $tenants = new Tenants($db);

    $token = $_GET['token'];

    // Check if the token exists in the database
    $stmt = $db->prepare("SELECT email FROM email_verification WHERE token = :token LIMIT 1");
    $stmt->execute([':token' => $token]);
    $user = $stmt->fetch();

    if ($user) {
        // Token is valid, proceed to verify the email
        $email = $user['email'];

        // Update the user's email verification status in the users table
        $updateStmt = $db->prepare("UPDATE tenants SET email_verified = 1 WHERE email = :email");
        $updateStmt->execute([':email' => $email]);

        // Optionally, delete the verification entry after successful verification
        $deleteStmt = $db->prepare("DELETE FROM email_verification WHERE token = :token");
        $deleteStmt->execute([':token' => $token]);

        $_SESSION['success'] = "Your email has been verified successfully!";
    } else {
        // Token is invalid or expired
        $_SESSION['errors']['token'] = "Invalid or expired token.";
    }
} else {
    // Token is missing from the URL
    $_SESSION['errors']['token'] = "No token provided.";
}

// Redirect to a confirmation page or display success message
header("Location: email_confirmation.php"); // Redirect to a page to display success or error message
exit();

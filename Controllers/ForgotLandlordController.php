<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

require '../vendor/autoload.php'; // Include PHPMailer's autoloader

$dotenv = Dotenv::createImmutable('D:\xampp\htdocs\Poblacion');
try {
    $dotenv->load();
} catch (Exception $e) {
    die('Failed to load .env file: ' . $e->getMessage());
}

// Include database connection
include 'Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? null;

    // Validate the email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['errors']['email'] = 'Invalid email address';
        header('Location: ../forgot_landlord.php');
        exit;
    }

    // Check if the email exists in the database
    $db = new Database();
    $conn = $db->getConnection();
    $stmt = $conn->prepare("SELECT * FROM landlords WHERE email = :email LIMIT 1");  // Assuming you have a tenants table
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $_SESSION['errors']['email'] = 'Email not found.';
        header('Location: ../forgot_landlord.php');
        exit;
    }

    // Generate a unique reset token
    $token = bin2hex(random_bytes(16)); // Generate a secure random token
    date_default_timezone_set('Asia/Manila'); // Set this to your local timezone
    $expiration = date('Y-m-d H:i:s', strtotime('+15 minutes'));  // Token expires in 1 hour

    // Store the reset token in the database
    $stmt = $conn->prepare("INSERT INTO landlord_resets (user_id, token, expiration) VALUES (:user_id, :token, :expiration)");
    $stmt->bindParam(':user_id', $user['id'], PDO::PARAM_INT);
    $stmt->bindParam(':token', $token, PDO::PARAM_STR);
    $stmt->bindParam(':expiration', $expiration, PDO::PARAM_STR);
    $stmt->execute();

    // Send the reset email
    try {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = $_ENV['SMTP_HOST']; // Set the SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USER']; // SMTP username
        $mail->Password = $_ENV['SMTP_PASS']; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $_ENV['SMTP_PORT'];

        // Sender and recipient
        $mail->setFrom('poblacionease@gmail.com', 'PoblacionEase');
        $mail->addAddress($email); // Add the recipient email

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request';
        $mail->Body    = "We received a request to reset your password. Click the link below to reset your password.<br>
                        <a href='localhost/poblacion/landlord-reset?token=$token'>Reset Password</a>";

        // Send the email
        $mail->send();

        // Redirect or show success message
        $_SESSION['message'] = 'A password reset link has been sent to your email address.';
        header('Location: ../forgot_landlord.php');
    } catch (Exception $e) {
        $_SESSION['errors']['email'] = 'Mailer Error: ' . $mail->ErrorInfo;
        header('Location: ../forgot_landlord.php');
    }
}

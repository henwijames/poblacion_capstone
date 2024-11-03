<?php
session_start();
require 'vendor/autoload.php'; // Load PHPMailer if using Composer
use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Specify the path to your .env file
$dotenv = Dotenv::createImmutable(__DIR__); // Change __DIR__ if your .env is in another directory

// Load the .env file and check for success
try {
    $dotenv->load();
} catch (Exception $e) {
    die('Failed to load .env file: ' . $e->getMessage());
}
// Check if the environment variable is set
if (!$_ENV['SMTP_HOST']) {
    die("SMTP_HOST is not set in the environment variables.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_SESSION['email']; // Make sure the user's email is stored in the session

    // Sending verification email using PHPMailer
    $mail = new PHPMailer();
    try {
        $mail->isSMTP();
        $mail->Host = $_ENV['SMTP_HOST']; // Update with your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USER']; // Your SMTP username
        $mail->Password = $_ENV['SMTP_PASS']; // Your SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $_ENV['SMTP_PORT']; // Your SMTP port

        // Email settings
        $mail->setFrom('poblacionease@gmail.com', 'poblacion');
        $mail->addAddress($email); // Send to user's email

        $mail->isHTML(true);
        $mail->Subject = 'PoblacionEase Email Verification';
        $mail->Body    = 'Click the link to verify your email: <a href="http://yourwebsite.com/verify_email.php">Verify Email</a>';

        $mail->send();
        $_SESSION['success'] = "Verification email sent. Please check your email.";
    } catch (Exception $e) {
        $_SESSION['errors']['email'] = "Error sending email: {$mail->ErrorInfo}";
    }
    header("Location: email_verification.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PoblacionEase</title>

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/aos.css">

    <!-- FontAwesome CDN -->
    <script src="https://kit.fontawesome.com/f284e8c7c2.js" crossorigin="anonymous"></script>

    <!-- JQuery File -->
    <script src="./assets/js/jquery-3.7.1.min.js"></script>
</head>

<body class="flex justify-center items-center" style="background-image: url('assets/img/volcano.jpg'); background-repeat: no-repeat; background-size: cover; background-position: center;  height: 100vh;">

    <div class="container mx-auto flex items-center justify-center gap-16 " data-aos="fade-right" data-aos-delay="50" data-aos-duration="1000">
        <img src="assets/img/notif.svg" alt="notif" class="relative">
        <div class="container mx-auto md:px-[120px] mb-4 px-6 py-2 absolute top-10">
            <nav class="flex justify-center items-center mb-2">
                <a href="index"><img src="assets/img/poblacionease.png" alt="Poblacionease logo" class="w-[150px] h-[60px]"></a>
            </nav>
        </div>
        <div class="flex flex-col items-center justify-center gap-4 py-12 absolute bottom-5">
            <h1 class="text-xl sm:text-3xl font-bold">Email Verification</h1>
            <p>Please verify your email to continue.</p>
            <form method="POST">
                <button type="submit" class="btn bg-primary text-white">Send to Email</button>
            </form>
        </div>

    </div>
    <script src="assets/js/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>
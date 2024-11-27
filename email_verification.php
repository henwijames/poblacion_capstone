<?php
session_start();
require 'Controllers/Database.php';
require 'Models/Tenants.php';
require 'Models/Landlords.php';
require 'vendor/autoload.php';

use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dotenv = Dotenv::createImmutable(__DIR__);
try {
    $dotenv->load();
} catch (Exception $e) {
    die('Failed to load .env file: ' . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['email']) || !isset($_SESSION['user_role'])) {
        die("No email or user role found in session. Please log in first.");
    }

    $database = new Database();
    $db = $database->getConnection();
    $tenants = new Tenants($db);
    $landlords = new Landlords($db);

    $email = $_SESSION['email'];
    $user_role = $_SESSION['user_role'];

    if ($user_role === 'tenant') {
        $user = new Tenants($db);
    } elseif ($user_role === 'landlord') {
        $user = new Landlords($db);
    } else {
        die("Invalid user role.");
    }

    $token = bin2hex(random_bytes(16));
    $tenants->insertEmailVerificationToken($email, $token);
    $landlords->insertEmailVerificationToken($email, $token);

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USER'];
        $mail->Password = $_ENV['SMTP_PASS'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $_ENV['SMTP_PORT'];
        // Configure SMTP options to skip SSL verification (for debugging)
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        // Store debug output in a variable instead of displaying it
        ob_start();
        $mail->SMTPDebug = 2;
        $mail->Debugoutput = function ($str, $level) {
            echo "Debug level $level; message: $str<br>";
        };

        $mail->setFrom('poblacionease@gmail.com', 'PoblacionEase');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'PoblacionEase Email Verification';
        $mail->Body = '
            <div style="font-family: Arial, sans-serif; padding: 20px; background-color: #f9f9f9; border: 1px solid #ddd;">
                <h2 style="color: #333;">PoblacionEase Email Verification</h2>
                <p style="color: #555; line-height: 1.5;">
                    Thank you for signing up! Please verify your email address to activate your account.
                </p>
                <p style="text-align: center; margin-top: 30px;">
                    <a href="localhost/poblacion/verify_email.php?token=' . $token . '" style="
                        display: inline-block;
                        padding: 10px 20px;
                        font-size: 16px;
                        color: #ffffff;
                        background-color: #4CAF50;
                        text-decoration: none;
                        border-radius: 5px;
                    ">Verify Email</a>
                </p>
                <p style="color: #888; font-size: 12px; margin-top: 20px;">
                    If you did not request this email, please ignore it.
                </p>
            </div>';

        if ($mail->send()) {
            $_SESSION['success'] = "Verification email sent. Please check your email.";
        }
    } catch (Exception $e) {
        $_SESSION['errors']['email'] = "Error sending email: {$mail->ErrorInfo}";
    }

    // Clear the output buffer to prevent header issues
    ob_end_clean();

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
    <script src="https://kit.fontawesome.com/f284e8c7c2.js" crossorigin="anonymous"></script>
    <script src="./assets/js/jquery-3.7.1.min.js"></script>
</head>

<body class="flex justify-center items-center" style="background-image: url('assets/img/volcano.jpg'); background-repeat: no-repeat; background-size: cover; background-position: center; height: 100vh;">
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
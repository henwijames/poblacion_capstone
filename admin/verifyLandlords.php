
<?php
header('Content-Type: application/json');
include '../Controllers/Database.php';
require_once '../Models/Landlords.php';
require '../vendor/autoload.php'; // Load PHPMailer (ensure this path is correct)
use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dotenv = Dotenv::createImmutable('D:\xampp\htdocs\Poblacion');
try {
    $dotenv->load();
} catch (Exception $e) {
    die('Failed to load .env file: ' . $e->getMessage());
}

$database = new Database();
$db = $database->getConnection();
$landlords = new Landlords($db);

if (isset($_GET['id'])) {
    $landlordId = $_GET['id'];

    // Assuming verifyLandlord is a function that verifies a landlord account
    $result = $landlords->verifyLandlord($landlordId);

    if ($result) {
        $landlord = $landlords->findById($landlordId);
        $email =  $landlord['email'];


        $mail = new PHPMailer(true);
        try {
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = $_ENV['SMTP_HOST']; // Set the SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['SMTP_USER']; // SMTP username
            $mail->Password = $_ENV['SMTP_PASS']; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $_ENV['SMTP_PORT'];

            // Sender and recipient
            $mail->setFrom('poblacionease@gmail.com', 'PoblacionEase');
            $mail->addAddress($email); // Landlord's email

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Account Verification Success';
            $mail->Body = '
            <div style="font-family: Arial, sans-serif; padding: 20px; background-color: #f9f9f9; border: 1px solid #ddd;">
                <h2 style="color: #333;">' . 'Dear ' .  htmlspecialchars($landlord['first_name']) . ',</h2>
                <p style="color: #555; line-height: 1.5;">Based on your business permit submission, your account has been successfully verified.</p>
                <p style="color: #555; line-height: 1.5;">Thank you for being part of PoblacionEase!</p>
                
                <p style="color: #888; font-size: 12px; margin-top: 20px;">
                    If you did not request this email, please ignore it.
                </p>
            </div>';

            // Send email
            if ($mail->send()) {
                // Return a successful response
                echo json_encode(['status' => 'success', 'message' => 'Account verified successfully, and email sent.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Verification successful, but email could not be sent.']);
            }
        } catch (Exception $e) {
            // If an error occurs in PHPMailer
            echo json_encode(['status' => 'error', 'message' => 'Verification successful, but email could not be sent. Error: ' . $mail->ErrorInfo]);
        }
    } else {
        // Return an error response
        echo json_encode(['status' => 'error', 'message' => 'Verification failed.']);
    }
} else {
    // If no ID is passed, return an error response
    echo json_encode(['status' => 'error', 'message' => 'Landlord ID not provided.']);
}

?>
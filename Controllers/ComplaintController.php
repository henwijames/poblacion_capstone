<?php
session_start();
include 'Database.php';
require '../vendor/autoload.php';

use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json'); // Tell the client it's JSON

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
try {
    $dotenv->load();
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to load .env file.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $listingId = $_POST['listing_id'];
    $complainMessage = trim($_POST['complain_message']);
    $userId = $_SESSION['user_id'] ?? null;

    if (!$userId) {
        echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
        exit;
    }

    $database = new Database();
    $db = $database->getConnection();

    $query = "INSERT INTO complaints (user_id, listing_id, message, created_at) VALUES (:user_id, :listing_id, :message, NOW())";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':listing_id', $listingId, PDO::PARAM_INT);
    $stmt->bindParam(':message', $complainMessage, PDO::PARAM_STR);

    if ($stmt->execute()) {
        // Retrieve landlord details
        $query = "SELECT landlords.email, landlords.first_name FROM landlords
                  INNER JOIN listings ON landlords.id = listings.user_id 
                  WHERE listings.id = :listing_id";
        $stmtLandlord = $db->prepare($query);
        $stmtLandlord->bindParam(':listing_id', $listingId, PDO::PARAM_INT);
        $stmtLandlord->execute();
        $landlord = $stmtLandlord->fetch(PDO::FETCH_ASSOC);

        if ($landlord) {
            $landlordEmail = $landlord['email'];
            $landlordName = $landlord['first_name'];

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = $_ENV['SMTP_HOST'];
                $mail->SMTPAuth = true;
                $mail->Username = $_ENV['SMTP_USER'];
                $mail->Password = $_ENV['SMTP_PASS'];
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = $_ENV['SMTP_PORT'];

                $mail->setFrom('poblacionease@gmail.com', 'PoblacionEase');
                $mail->addAddress($landlordEmail);

                $mail->isHTML(true);
                $mail->Subject = 'New Complaint Submitted';
                $mail->Body = "
                <h2>Dear {$landlordName},</h2>
                <p>A new complaint has been submitted:</p>
                <p><strong>Message:</strong> {$complainMessage}</p>";

                $mail->send();
                // Send response only once
                echo json_encode(['status' => 'success', 'message' => 'Complaint submitted successfully.']);
            } catch (Exception $e) {
                echo json_encode(['status' => 'error', 'message' => 'Error sending email.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Landlord information not found.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database error.']);
    }
}

<?php
include '../../Controllers/Database.php';
include '../../Models/Listing.php';  // Assuming Listings model has a method to retrieve landlord_id
require '../../vendor/autoload.php'; // Ensure this path is correct

use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');

try {
    $dotenv->load();
} catch (Exception $e) {
    die('Failed to load .env file: ' . $e->getMessage());
}

// Assuming you have established the database connection as $db
// Ensure you have PHPMailer installed (via Composer)

$database = new Database();
$db = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bookingId = $_POST['booking_id'];
    $totalAmount = $_POST['total_amount'];
    $screenshot = $_FILES['screenshot'];

    // Validate the screenshot file (optional)
    if ($screenshot['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['status' => 'error', 'message' => 'Error uploading the screenshot.']);
        exit;
    }

    // Save the screenshot file (you should have a folder like "uploads/screenshots/")
    $targetDirectory = 'uploads/';
    $filePath = $targetDirectory . basename($screenshot['name']);
    $fileName = basename($screenshot['name']);
    if (move_uploaded_file($screenshot['tmp_name'], $filePath)) {
        // Update the transaction status to 'pending' and save the screenshot file path
        $updateQuery = "UPDATE transactions SET transaction_status = 'pending', screenshot = :screenshot WHERE transaction_id = :transaction_id";
        $stmt = $db->prepare($updateQuery);
        $stmt->bindValue(':screenshot', $fileName, PDO::PARAM_STR);
        $stmt->bindValue(':transaction_id', $bookingId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Get landlord's email based on landlord_id from the landlords table
            $getLandlordQuery = "SELECT email FROM landlords WHERE landlord_id = (SELECT landlord_id FROM listings WHERE listing_id = :listing_id)";
            $stmt = $db->prepare($getLandlordQuery);
            $stmt->bindValue(':listing_id', $listingId, PDO::PARAM_INT);
            $stmt->execute();
            $landlord = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($landlord) {
                // Send email to the landlord
                $mail = new PHPMailer(true);
                try {
                    //Server settings
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
                    $mail->Subject = 'PoblacionEase Payment Status Update';
                    $mail->Body    = "
                        <p>Dear Landlord,</p>
                        <p>Your tenant has uploaded a screenshot and the payment status is now pending.</p>
                        <p>Transaction ID: $bookingId</p>
                        <p>Total Amount: $$totalAmount</p>
                        <p>Please review the payment and proceed accordingly.</p>
                        <p>Best regards,<br>Web-Based Business System</p>
                    ";

                    $mail->send();
                } catch (Exception $e) {
                    echo json_encode(['status' => 'error', 'message' => "Mailer Error: {$mail->ErrorInfo}"]);
                    exit;
                }
            }


            echo json_encode([
                'status' => 'success',
                'message' => 'Transaction updated to pending and landlord notified.',
                'redirect_url' => 'your_redirect_url_here'
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update the transaction status.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to upload screenshot file.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}

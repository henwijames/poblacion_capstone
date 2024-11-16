<?php
header('Content-Type: application/json');
include '../../Controllers/Database.php';
include '../../Models/Bookings.php';
require '../../vendor/autoload.php';

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
$bookings = new Bookings($db);

if (isset($_GET['id'])) {
    $inquiryId = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Fetch details for email notification
    $query = "SELECT 
                  tenants.email, 
                  CONCAT(tenants.first_name, ' ', tenants.middle_name, ' ', tenants.last_name) AS tenant_name,
                  CONCAT(landlords.first_name, ' ', landlords.middle_name, ' ', landlords.last_name) AS landlord_name
              FROM bookings
              JOIN tenants ON bookings.user_id = tenants.id
              JOIN landlords ON bookings.landlord_id = landlords.id
              WHERE bookings.id = :id";

    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $inquiryId, PDO::PARAM_INT);
    $stmt->execute();
    $tenant = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$tenant) {
        echo json_encode(['status' => 'error', 'message' => 'Inquiry not found.']);
        exit();
    }

    $tenantName = $tenant['tenant_name'];
    $tenantEmail = $tenant['email'];
    $landlordName = $tenant['landlord_name'];

    // Prepare the email
    $mail = new PHPMailer(true);
    $emailBody = '
        <html>
        <head>
            <meta charset="UTF-8">
            <meta content="width=device-width, initial-scale=1" name="viewport">
            <title>Declined Inquiry</title>
        </head>
        <body>
            <div>
                <table width="100%" cellspacing="0" cellpadding="0">
                    <tbody>
                        <tr>
                            <td align="center">
                                <img src="https://fptpbfq.stripocdn.email/content/guids/CABINET_905d63f3814e55730c693afd59e4c30260908b814c9950bcfeb18e2a36b9dd7a/images/poblacionease_Tdn.png" alt="PoblacionEase" width="197">
                            </td>
                        </tr>
                        <tr>
                            <td align="center">
                                <h2>Dear ' . htmlspecialchars($tenantName) . ',</h2>
                                <p>Your inquiry has been <span style: font-weight: bold;>declined</span> by ' . htmlspecialchars($landlordName) . '. You need to inquire on a different day. Thank you for choosing PoblacionEase!</p>
                                <p>If you did not request this email, please ignore it.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </body>
        </html>';

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USER'];
        $mail->Password = $_ENV['SMTP_PASS'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $_ENV['SMTP_PORT'];

        // Set sender and recipient
        $mail->setFrom('poblacionease@gmail.com', 'PoblacionEase');
        $mail->addAddress($tenantEmail);

        // Email subject and body
        $mail->isHTML(true);
        $mail->Subject = 'Declined Inquiry';
        $mail->Body = $emailBody;

        // Send the email
        if ($mail->send()) {
            // Decline inquiry after email is sent
            $result = $bookings->declineInquiry($inquiryId);

            if ($result) {
                echo json_encode(['status' => 'success', 'message' => 'Email sent and inquiry declined successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Email sent, but inquiry decline failed.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to send email notification.']);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to send email notification. Error: ' . $mail->ErrorInfo]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Inquiry ID not provided.']);
}

<?php
header('Content-Type: application/json');
include '../../Controllers/Database.php';
include '../../Models/Bookings.php';
require '../../vendor/autoload.php';

use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');

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

    $result = $bookings->verifyInquiry($inquiryId);

    if ($result) {
        $query = "SELECT tenants.email, CONCAT(tenants.first_name, ' ', tenants.middle_name, ' ', tenants.last_name) AS tenant_name
              FROM bookings
              JOIN tenants ON bookings.user_id = tenants.id
              WHERE bookings.id = :id";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $inquiryId, PDO::PARAM_INT);
        $stmt->execute();
        $tenant = $stmt->fetch(PDO::FETCH_ASSOC);
        $tenantName = $tenant['tenant_name'];
        $tenantEmail = $tenant['email'];

        // Prepare the email
        $mail = new PHPMailer(true);
        $emailBody =
            '
            <html dir="ltr" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
            <head>
                <meta charset="UTF-8">
                <meta content="width=device-width, initial-scale=1" name="viewport">
                <title> Inquiry Verification Success</title>
            </head>
            <body class="body">
                <div dir="ltr" class="es-wrapper-color">
                    <table width="100%" cellspacing="0" cellpadding="0" class="es-wrapper">
                        <tbody>
                            <tr>
                                <td valign="top" class="esd-email-paddings">
                                    <table width="600" cellspacing="0" cellpadding="0" align="center" class="es-content-body" style="background-color:transparent">
                                        <tbody>
                                            <tr>
                                                <td align="center" class="esd-block-image" style="font-size:0">
                                                    <img src="https://fptpbfq.stripocdn.email/content/guids/CABINET_905d63f3814e55730c693afd59e4c30260908b814c9950bcfeb18e2a36b9dd7a/images/poblacionease_Tdn.png" alt="PoblacionEase" width="197">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <h2>Dear ' . htmlspecialchars($tenantName) . ',</h2>
                                                    <p>Your inquiry has been successfully verified. You can now proceed to pay the rent. Thank you for choosing PoblacionEase!</p>
                                                    <p>If you did not request this email, please ignore it.</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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
            $mail->Subject = 'Inquiry Verification Success';
            $mail->Body = $emailBody;

            // Send the email
            if ($mail->send()) {
                echo json_encode(['status' => 'success', 'message' => 'Inquiry verified successfully, and email sent.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Verification successful, but email could not be sent.']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Verification successful, but email could not be sent. Error: ' . $mail->ErrorInfo]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Inquiry verification failed.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Inquiry ID not provided.']);
}

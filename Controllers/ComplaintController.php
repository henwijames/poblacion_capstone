<?php
session_start();
include 'Database.php';
require '../vendor/autoload.php'; // Load PHPMailer (ensure this path is correct)
use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');

try {
    $dotenv->load();
} catch (Exception $e) {
    die('Failed to load .env file: ' . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();
    $db = $database->getConnection();

    $listingId = $_POST['listing_id'];
    $complainMessage = $_POST['complain_message'];
    $userId = $_SESSION['user_id']; // Get the logged-in user ID

    // Insert complaint into the database
    $query = "INSERT INTO complaints (user_id, listing_id, message, created_at) VALUES (:user_id, :listing_id, :message, NOW())";
    $stmt = $db->prepare($query);

    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':listing_id', $listingId, PDO::PARAM_INT);
    $stmt->bindParam(':message', $complainMessage, PDO::PARAM_STR);

    if ($stmt->execute()) {
        $query = "SELECT landlords.email, landlords.first_name FROM landlords
        INNER JOIN listings ON landlords.id = listings.user_id 
        WHERE listings.id = :listing_id";
        $stmtLandlord = $db->prepare($query);
        $stmtLandlord->bindParam(':listing_id', $listingId, PDO::PARAM_INT);
        $stmtLandlord->execute();
        $landlord = $stmtLandlord->fetch(PDO::FETCH_ASSOC);

        if ($landlord) {
            $landlordName = $landlord['first_name'];
            $landlordEmail = $landlord['email'];

            $mail = new PHPMailer(true);
            $emailBody = '
            <html dir="ltr" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
            <head>
                <meta charset="UTF-8">
                <meta content="width=device-width, initial-scale=1" name="viewport">
                <title>Tenants Complain</title>
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
                                                    <h2>Dear ' . htmlspecialchars($landlordName) . ',</h2>
                                                    <p>A new complaint has been submitted for one of your listings.</p>
                                                    <p>Message: ' . htmlspecialchars($complainMessage) . '</p>
                                                    <p>Please log in to your account to view more details.</p>
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
                $mail->Host = $_ENV['SMTP_HOST']; // Set the SMTP server
                $mail->SMTPAuth = true;
                $mail->Username = $_ENV['SMTP_USER']; // SMTP username
                $mail->Password = $_ENV['SMTP_PASS']; // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = $_ENV['SMTP_PORT'];

                // Sender and recipient
                $mail->setFrom('poblacionease@gmail.com', 'PoblacionEase');
                $mail->addAddress($email); // Tenant's email

                // Email content
                $mail->isHTML(true);
                $mail->Subject = 'New Complaint Submitted';
                $mail->Body = $emailBody;
                if ($mail->send()) {
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Your complaint has been submitted successfully, and the landlord has been notified',
                    ]);
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Complaint submitted, but email notification could not be sent,',
                    ]);
                }
            } catch (Exception $e) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Complaint submitted, but there was an error sending the email: ' . $mail->ErrorInfo,
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Complaint submitted, but landlord information could not be retrieved.',
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'There was an error submitting your complaint. Please try again.',
        ]);
    }
}

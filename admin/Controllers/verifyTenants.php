
<?php
header('Content-Type: application/json');
include '../../Controllers/Database.php';
require_once '../../Models/Tenants.php';
require '../../vendor/autoload.php'; // Load PHPMailer (ensure this path is correct)
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
$tenants = new Tenants($db);

if (isset($_GET['id'])) {
    $tenantId = $_GET['id'];
    $result = $tenants->verifyTenant($tenantId);

    if ($result) {
        $tenant = $tenants->findById($tenantId);
        $email = $tenant['email'];
        $mail = new PHPMailer(true);
        $emailBody = '
            <html dir="ltr" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
            <head>
                <meta charset="UTF-8">
                <meta content="width=device-width, initial-scale=1" name="viewport">
                <title>Account Verification Success</title>
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
                                                    <h2>Dear ' . htmlspecialchars($tenant['first_name']) . ',</h2>
                                                    <p>Your account has been successfully verified based on your Valid ID submission. Thank you for being part of PoblacionEase!</p>
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
            $mail->Subject = 'Account Verification Success';
            $mail->Body = $emailBody;

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
    echo json_encode(['status' => 'error', 'message' => 'Tenant ID not provided.']);
}

?>
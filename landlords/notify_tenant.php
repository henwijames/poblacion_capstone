<?php
require '../vendor/autoload.php';

use Dotenv\Dotenv;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');

try {
    $dotenv->load();
    echo 'Connected to .env';
} catch (Exception $e) {
    die('Failed to load .env file: ' . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tenantEmail = filter_var($_POST['tenant_email'], FILTER_SANITIZE_EMAIL);
    $tenantName = filter_var($_POST['tenant_name'], FILTER_SANITIZE_STRING);
    $listingName = filter_var($_POST['listing_name'], FILTER_SANITIZE_STRING);

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
        $mail->addAddress($tenantEmail); // Tenant's email

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Rent Payment Reminder';
        $mail->Body = '
            <html dir="ltr" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
            <head>
                <meta charset="UTF-8">
                <meta content="width=device-width, initial-scale=1" name="viewport">
                <title>Rent Payment Reminder</title>
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
                                                    <h2>Dear ' . $tenantName . ',</h2>
                                                    <p>This is a friendly reminder that your rent for the property <b>' . $listingName . '</b> is due in 9 days. Please ensure to pay your rent before the due date to avoid penalties.</p>
                                                    <p>Thank you!</p>
                                                    <p>Best regards,<br>PoblacionEase</p>
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

        // Send email
        $mail->send();
        echo json_encode(['status' => 'success', 'message' => 'Notification email sent successfully!']);
        header('Location: rents');
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to send email. Error: ' . $mail->ErrorInfo]);
    }
}

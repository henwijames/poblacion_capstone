<?php
session_start();
require_once '../Controllers/Database.php';
require '../vendor/autoload.php';

use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
try {
    $dotenv->load();
} catch (Exception $e) {
    die('Failed to load .env file: ' . $e->getMessage());
}

$database = new Database();
$db = $database->getConnection();

$action = $_POST['action'] ?? null;
$transaction_id = $_POST['transaction_id'] ?? null;

// Validate input
if (!$action || !$transaction_id) {
    $_SESSION['error_message'] = "Invalid action or transaction ID.";
    header('Location: index');
    exit();
}

try {
    // Start transaction
    $db->beginTransaction();

    // Determine transaction status
    $status = $action === 'verify' ? 'completed' : 'declined';

    // Update transaction status
    $query = "UPDATE transactions SET transaction_status = :status WHERE transaction_id = :transaction_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':transaction_id', $transaction_id);
    if (!$stmt->execute()) {
        throw new Exception("Failed to update transaction status.");
    }

    // Fetch transaction details
    $transactionQuery = "SELECT listing_id, user_id, amount FROM transactions WHERE transaction_id = :transaction_id";
    $transactionStmt = $db->prepare($transactionQuery);
    $transactionStmt->bindParam(':transaction_id', $transaction_id);
    if (!$transactionStmt->execute()) {
        throw new Exception("Failed to fetch transaction details.");
    }

    $transaction = $transactionStmt->fetch(PDO::FETCH_ASSOC);
    if (!$transaction) {
        throw new Exception("Transaction not found.");
    }

    $listing_id = $transaction['listing_id'];
    $tenant_id = $transaction['user_id'];
    $amount = $transaction['amount'];

    // Fetch tenant details
    $tenantQuery = "SELECT email FROM tenants WHERE id = :tenant_id";
    $tenantStmt = $db->prepare($tenantQuery);
    $tenantStmt->bindParam(':tenant_id', $tenant_id);
    if (!$tenantStmt->execute()) {
        throw new Exception("Failed to fetch tenant details.");
    }

    $tenant = $tenantStmt->fetch(PDO::FETCH_ASSOC);
    if (!$tenant) {
        throw new Exception("Tenant not found.");
    }

    $tenantEmail = $tenant['email'];

    // Process based on action
    if ($action === 'verify') {
        // Send email notification
        sendEmailNotification($tenantEmail, $amount);

        // Update rent details
        $rentQuery = "SELECT rent_date, due_month FROM rent WHERE listing_id = :listing_id AND user_id = :tenant_id";
        $rentStmt = $db->prepare($rentQuery);
        $rentStmt->bindParam(':listing_id', $listing_id);
        $rentStmt->bindParam(':tenant_id', $tenant_id);
        if (!$rentStmt->execute()) {
            throw new Exception("Failed to fetch rent details.");
        }

        $rent = $rentStmt->fetch(PDO::FETCH_ASSOC);
        if (!$rent) {
            throw new Exception("Rent details not found.");
        }

        $rent_date = $rent['rent_date'];
        $due_month = $rent['due_month'];
        $new_due_month = ($due_month === null) ? date('Y-m-d', strtotime("+1 month", strtotime($rent_date))) :
            date('Y-m-d', strtotime("+1 month", strtotime($due_month)));

        // Update rent table
        $updateRentQuery = "
            UPDATE rent 
            SET due_month = :new_due_month, rent_status = 'paid' 
            WHERE listing_id = :listing_id AND user_id = :tenant_id
        ";
        $updateRentStmt = $db->prepare($updateRentQuery);
        $updateRentStmt->bindParam(':new_due_month', $new_due_month);
        $updateRentStmt->bindParam(':listing_id', $listing_id);
        $updateRentStmt->bindParam(':tenant_id', $tenant_id);
        if (!$updateRentStmt->execute()) {
            throw new Exception("Failed to update rent details.");
        }

        // Update listing status
        $updateListingQuery = "UPDATE listings SET status = 'occupied' WHERE id = :listing_id";
        $updateListingStmt = $db->prepare($updateListingQuery);
        $updateListingStmt->bindParam(':listing_id', $listing_id);
        if (!$updateListingStmt->execute()) {
            throw new Exception("Failed to update listing status.");
        }
    } elseif ($action === 'declined') {
        // Send declined notification
        sendDeclinedEmailNotification($tenantEmail);
    }

    // Commit transaction
    $db->commit();
    $_SESSION['success_message'] = "Transaction has been $status successfully.";
} catch (Exception $e) {
    // Rollback transaction on error
    $db->rollBack();
    $_SESSION['error_message'] = "Transaction failed: " . $e->getMessage();
    error_log("Error: " . $e->getMessage());
} finally {
    header('Location: tenants');
    exit();
}




/**
 * Function to send an email notification to the tenant
 *
 * @param string $tenantEmail - The tenant's email address
 * @param float $amount - The amount of the payment
 */
function sendEmailNotification($tenantEmail, $amount)
{
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

        // Recipients
        $mail->setFrom('poblacionease@gmail.com', 'PoblacionEase');
        $mail->addAddress($tenantEmail); // Tenant's email address

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Payment Approved';
        $mail->Body    = '<html dir="ltr" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
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
                                                    <p>Your payment of <strong>₱' . number_format($amount, 2) . '</strong> has been approved and processed successfully.</p>
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


        // Send email
        $mail->send();
    } catch (Exception $e) {
        // Handle error
        error_log('Mailer Error: ' . $mail->ErrorInfo);
    }
}

function sendDeclinedEmailNotification($tenantEmail)
{
    $mail = new PHPMailer(true);
    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = $_ENV['SMTP_HOST']; // SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USER']; // SMTP username
        $mail->Password = $_ENV['SMTP_PASS']; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $_ENV['SMTP_PORT'];
        $mail->SMTPDebug = 2; // or PHPMailer::DEBUG_SERVER
        $mail->Debugoutput = 'error_log'; // Log output

        // Recipients
        $mail->setFrom('poblacionease@gmail.com', 'PoblacionEase');
        $mail->addAddress($tenantEmail); // Tenant's email address

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Payment Declined';
        $mail->Body    =
            '<html dir="ltr" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
            <head>
                <meta charset="UTF-8">
                <meta content="width=device-width, initial-scale=1" name="viewport">
                <title> Payment Declined</title>
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
                                                    <p>We regret to inform you that your payment request has been <strong>declined</strong> because of invalid reference number.</p>
                                                    <p>If you have any questions, please contact us for assistance.</p>
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
    } catch (Exception $e) {
        // Log detailed error messages
        error_log('Mailer Error: ' . $mail->ErrorInfo);
        error_log('Exception: ' . $e->getMessage());
    }
}

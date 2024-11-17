<?php
session_start();
require_once '../../Controllers/Database.php';
require_once '../../Models/Landlords.php';
require_once '../../Models/Tenants.php';
require_once '../../Models/Listing.php';
require_once '../../vendor/autoload.php'; // Include PHPMailer via Composer

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

$listing = new Listing($db);
$landlords = new Landlords($db);

$listing_id =  $_GET['id'] ?? null;
$user_id = $_SESSION['user_id'];



// Decode the payment options (if any) and check if it's an array

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["book_now"])) {

    $listingDetails = $listing->getListingById($listing_id);
    if (!$listingDetails) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Listing not found or no longer available.'
        ]);
        exit;
    }

    $landlord = $landlords->findById($listingDetails['user_id']);
    if (!$landlord) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Landlord information not found.'
        ]);
        exit;
    }
    $landlord_id = $listingDetails['user_id'];

    $paymentOptions = json_decode($listingDetails['payment_options'], true);


    if (!is_array($paymentOptions)) {
        $paymentOptions = [];  // Ensure it's an empty array if it's not valid
    }

    $errors = [];

    $check_in = $_POST['check_in'];

    if (empty($check_in)) {
        $errors['check_in'] = "Check-in date is required.";
        $_SESSION['error_message'] = "Check-in date is required.";
        header("Location: ../booking.php?id=$listing_id");
        exit();
    }

    $monthly_rent = $listingDetails['rent'];
    $total_amount = $monthly_rent;

    // Check if the payment options are available and if so, apply them
    if (in_array("one month advance", $paymentOptions)) {
        $total_amount += $monthly_rent;
    }

    if (in_array("one month deposit", $paymentOptions)) {
        $total_amount += $monthly_rent;
    }

    $db->beginTransaction();

    try {
        // Insert the booking into the bookings table
        $query = "INSERT INTO bookings (listing_id, user_id, check_in, total_amount, landlord_id) 
                  VALUES (:listing_id, :user_id, :check_in, :total_amount, :landlord_id)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':listing_id', $listing_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':check_in', $check_in);
        $stmt->bindParam(':total_amount', $total_amount);
        $stmt->bindParam(':landlord_id', $landlord_id, PDO::PARAM_INT);
        $stmt->execute();

        // Commit the transaction
        $db->commit();

        // Notify landlord via email
        sendEmailNotificationToLandlord($landlord['email'], $listingDetails, $total_amount, $check_in);

        echo "Booking successful! Landlord notified.";
        header("Location: ../inquiries.php?id=");
    } catch (Exception $e) {
        // Rollback the transaction if something goes wrong
        $db->rollBack();
        echo "Failed to book. Error: " . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'cancel') {
    $bookingId = $_POST['booking_id'];

    try {
        $database = new Database();
        $db = $database->getConnection();
        $booking = new Tenants($db);

        // Attempt to delete booking
        if ($booking->deleteBooking($bookingId)) {
            // Ensure no other output is sent before this response
            echo json_encode([
                'status' => 'success',
                'message' => 'Booking has been successfully deleted.'
            ]);
            exit; // Stop script execution
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to delete booking. It may not exist or has already been deleted.'
            ]);
            exit;
        }
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'An unexpected error occurred: ' . $e->getMessage()
        ]);
        exit;
    }
}



/**
 * Function to send an email notification to the landlord
 *
 * @param string $landlordEmail
 * @param array $listingDetails
 * @param string $checkInDate
 */
function sendEmailNotificationToLandlord($landlordEmail, $listingDetails, $totalAmount, $checkInDate)
{
    $mail = new PHPMailer(true);
    $emailBody = '
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
                                                    <h2>Hello, ' . $listingDetails['property_name'] . 'Landlord!</h2>
                                                    <p>You have received a new inquiry for your listing <b>' . $listingDetails['listing_name'] . '</b>.</p>
                                                    <p><b>Check-in Date:</b>' . $checkInDate . '</p>
                                                    <p><b>Total Amount:</b> ' . htmlspecialchars(number_format($totalAmount, 2)) . '</p>
                                                    <p>Kindly review the details in your dashboard.</p>
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

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = $_ENV['SMTP_HOST']; // Replace with your SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USER']; // Replace with your email
        $mail->Password = $_ENV['SMTP_PASS']; // Replace with your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $_ENV['SMTP_PORT'];

        // Email setup
        $mail->setFrom('poblacionease@gmail.com', 'PoblacionEase'); // Replace with sender info
        $mail->addAddress($landlordEmail); // Send to the landlord

        $mail->isHTML(true);
        $mail->Subject = 'New Inquiry for Your Listing';
        $mail->Body = $emailBody;

        // Send email
        $mail->send();
    } catch (Exception $e) {
        echo "Notification email could not be sent. Error: {$mail->ErrorInfo}";
    }
}

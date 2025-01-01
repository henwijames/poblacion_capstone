<?php
header('Content-Type: application/json');
session_start();
require_once 'Database.php';
require_once '../Models/Review.php';
require_once '../Models/Rents.php'; // require_once Rent model to delete rent record
require_once '../Models/Listing.php'; // Include Listing model to update occupancy status
require '../Models/Landlords.php'; // Include Listing model to update occupancy status
require '../vendor/autoload.php'; // Ensure this path is correct

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
    // Sanitize and assign POST data
    $user_id = $_SESSION['user_id'];
    $listing_id = $_POST['listing_id'];
    $rating = $_POST['rating'];
    $review_message = $_POST['review_message'];

    $database = new Database();
    $db = $database->getConnection();

    // Start a transaction to ensure both actions are completed together
    try {
        $db->beginTransaction();

        // Submit the review
        $review = new Review($db);
        $result = $review->submitReview($user_id, $listing_id, $rating, $review_message);
        if (!$result) {
            throw new Exception("Error submitting review");
        }

        // // Delete the rent record
        $rent = new Rent($db);
        $deleteRent = $rent->deleteRentByListing($listing_id);
        if (!$deleteRent) {
            throw new Exception("Error deleting rent record");
        }

        // // Update listing occupancy status
        $listing = new Listing($db);
        $updateListing = $listing->updateOccupancyStatus($listing_id);
        if (!$updateListing) {
            throw new Exception("Error updating listing occupancy status");
        }

        // Fetch landlord email
        $landlords = new Landlords($db);
        $landlordEmail = $landlords->getLandlordEmailByListing($listing_id);
        if (!$landlordEmail) {
            throw new Exception("Error fetching landlord's email");
        }

        // Send email to landlord
        $mail = new PHPMailer(true);
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
        $mail->Subject = 'Tenant Departure and Review Notification';
        $mail->Body = '<p>Review submitted</p>';

        if (!$mail->send()) {
            throw new Exception("Error sending email: " . $mail->ErrorInfo);
        }

        // Commit the transaction
        $db->commit();
        echo json_encode(['status' => 'success', 'message' => 'Review submitted, rent record deleted, and landlord notified']);
    } catch (Exception $e) {
        // Rollback transaction on error
        if ($db) {
            $db->rollBack();
        }
        file_put_contents('log.txt', "Error: " . $e->getMessage() . "\n", FILE_APPEND);
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $listing_id = $_POST['listing_id'];
//     $rating = $_POST['rating'];
//     $review_message = $_POST['review_message'];

//     $database = new Database();
//     $db = $database->getConnection();

//     // Temporarily skip transaction and email logic
//     try {
//         // Just for testing: directly respond with success without doing the actual logic
//         echo json_encode(['status' => 'success', 'message' => 'Test successful']);
//     } catch (Exception $e) {
//         header('Content-Type: application/json');
//         echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
//     }
// }

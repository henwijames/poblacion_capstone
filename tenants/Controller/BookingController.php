<?php
session_start();
require_once '../../Controllers/Database.php';
require_once '../../Models/Tenants.php';
require_once '../../Models/Listing.php';
$database = new Database();
$db = $database->getConnection();
$listing = new Listing($db);
$listing_id =  $_GET['id'] ?? null;
$user_id = $_SESSION['user_id'];
$listingDetails = $listing->getListingById($listing_id);
$paymentOptions = json_decode($listingDetails['payment_options'], true);
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["book_now"])) {
    $errors = [];

    $check_in = $_POST['check_in'];


    if (empty($check_in)) {
        $errors['check_in'] = "Check-in date is required.";
        $SESSION['error_message'] = "Check-in date is required.";
        header("Location: ../booking.php?id=$listing_id");
        exit();
    }

    $monthly_rent = $listingDetails['rent'];
    $total_amount = $monthly_rent;

    if (in_array("one month advance", $paymentOptions)) {
        $total_amount += $monthly_rent;
    }

    if (in_array("one month deposit", $paymentOptions)) {
        $total_amount += $monthly_rent;
    }



    $db->beginTransaction();

    try {
        // Insert the booking into the bookings table
        $query = "INSERT INTO bookings (listing_id, user_id, check_in, total_amount) 
                  VALUES (:listing_id, :user_id, :check_in, :total_amount)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':listing_id', $listing_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':check_in', $check_in);
        $stmt->bindParam(':total_amount', $total_amount);
        $stmt->execute();

        // Update the status of the listing to 'pending'
        $updateListingQuery = "UPDATE listings SET status = 'pending' WHERE id = :listing_id";
        $updateStmt = $db->prepare($updateListingQuery);
        $updateStmt->bindParam(':listing_id', $listing_id, PDO::PARAM_INT);
        $updateStmt->execute();

        // Commit the transaction
        $db->commit();

        echo "Booking successful! Listing status updated to pending.";
        header("Location: ../profile.php");
    } catch (Exception $e) {
        // Rollback the transaction if something goes wrong
        $db->rollBack();
        echo "Failed to book. Error: " . $e->getMessage();
    }
}

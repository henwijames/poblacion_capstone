<?php
session_start();
include '../../Controllers/Database.php';
include '../../Models/Listing.php';  // Assumes Listings model has a method to retrieve landlord_id

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
    exit;
}

// Check if the booking_id and reference number are provided via POST
if (isset($_POST['booking_id']) && isset($_POST['reference_number'])) {
    $bookingId = filter_var($_POST['booking_id'], FILTER_SANITIZE_NUMBER_INT); // Sanitize input
    $referenceNumber = filter_var($_POST['reference_number'], FILTER_SANITIZE_STRING); // Sanitize input
    $userId = $_SESSION['user_id'];

    // Validate that required fields are not empty
    if (empty($bookingId) || empty($referenceNumber)) {
        echo json_encode(['status' => 'error', 'message' => 'Required fields are missing or invalid.']);
        exit;
    }

    // Initialize the database
    $database = new Database();
    $db = $database->getConnection();

    // Query the booking details (assuming a Bookings model or direct query)
    $query = "
        SELECT b.listing_id, l.user_id AS landlord_id, l.address AS apartment_name, b.total_amount AS amount
        FROM bookings b
        JOIN listings l ON b.listing_id = l.id
        WHERE b.id = :booking_id AND b.user_id = :user_id
    ";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':booking_id', $bookingId, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Fetch the booking details
        $bookingDetails = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($bookingDetails) {
            $listingId = $bookingDetails['listing_id'];
            $landlordId = $bookingDetails['landlord_id'];
            $apartmentName = $bookingDetails['apartment_name'];
            $amount = $bookingDetails['amount'];

            // Get the current date and add one month for the rent due date
            $currentDate = new DateTime();

            // Insert into transactions table
            $transactionQuery = "
                INSERT INTO transactions (user_id, landlord_id, listing_id, apartment_name, amount, reference_number, details)
                VALUES (:user_id, :landlord_id, :listing_id, :apartment_name, :amount, :reference_number, :details)
            ";
            $stmt = $db->prepare($transactionQuery);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':landlord_id', $landlordId, PDO::PARAM_INT);
            $stmt->bindParam(':listing_id', $listingId, PDO::PARAM_INT);
            $stmt->bindParam(':apartment_name', $apartmentName, PDO::PARAM_STR);
            $stmt->bindParam(':amount', $amount, PDO::PARAM_STR);
            $stmt->bindParam(':reference_number', $referenceNumber, PDO::PARAM_STR);


            // Details can be a dynamic input or set to a default value
            $details = "Payment for booking #$bookingId"; // Example details
            $stmt->bindParam(':details', $details, PDO::PARAM_STR);

            if ($stmt->execute()) {
                // Insert into rent table after the transaction is successfully recorded
                $rentQuery = "
                    INSERT INTO rent (user_id, landlord_id, listing_id, amount, rent_date)
                    VALUES (:user_id, :landlord_id, :listing_id, :amount, NOW())
                ";
                $stmt = $db->prepare($rentQuery);
                $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                $stmt->bindParam(':landlord_id', $landlordId, PDO::PARAM_INT);
                $stmt->bindParam(':listing_id', $listingId, PDO::PARAM_INT);
                $stmt->bindParam(':amount', $amount, PDO::PARAM_STR);
                $stmt->bindParam(':reference_number', $referenceNumber, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    // Delete the booking record from the bookings table
                    $deleteQuery = "
                        DELETE FROM bookings WHERE id = :booking_id AND user_id = :user_id
                    ";
                    $stmt = $db->prepare($deleteQuery);
                    $stmt->bindParam(':booking_id', $bookingId, PDO::PARAM_INT);
                    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

                    if ($stmt->execute()) {
                        // Successful transaction, rent insertion, and booking deletion
                        echo json_encode([
                            'status' => 'success',
                            'message' => 'Transaction completed successfully and booking deleted.',
                            'redirect_url' => 'inquiries.php' // URL to redirect to after success
                        ]);
                    } else {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Failed to delete the booking record.'
                        ]);
                    }
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Failed to record the rent transaction.'
                    ]);
                }
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Failed to record the transaction.'
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Booking not found or unauthorized access.'
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to retrieve booking details.'
        ]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Required information missing.']);
}
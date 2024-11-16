<?php
session_start();
include 'Database.php';

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
        echo json_encode([
            'status' => 'success',
            'message' => 'Your complaint has been submitted successfully.',
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'There was an error submitting your complaint. Please try again.',
        ]);
    }
}

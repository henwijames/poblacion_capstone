<?php
session_start();
require_once '../../Models/Landlords.php';
require_once '../../Controllers/Database.php';

// Update Landlords Profile
if (isset($_POST['update_listing'])) {
    $listing_id = $_GET['id'] ?? null;

    if ($listing_id) {
        $database = new Database();
        $db = $database->getConnection();
        $listing = new Listing($db);

        // Collect form data
        $data = [
            'property_type' => $_POST['property_type'] ?? '',
            'address' => $_POST['address'] ?? '',
            'bedrooms' => $_POST['bedrooms'] ?? '',
            'bathrooms' => $_POST['bathrooms'] ?? '',
            'amenities' => isset($_POST['amenities']) ? $_POST['amenities'] : [],
            'sqft' => $_POST['sqft'] ?? '',
            'rent' => $_POST['rent'] ?? '',
            'description' => $_POST['description'] ?? '',
            'user_id' => $_SESSION['user_id'],
            'id' => $listing_id // Include listing_id here
        ];

        // Add more validation as needed...

        if (empty($errors)) {
            // Update listing in the database
            if ($listing->updateListing($data)) {
                $_SESSION['success_message'] = 'Listing updated successfully.';
                header("Location: ../edit-listings.php?id=" . $listing_id);
                exit();
            } else {
                $_SESSION['errors'] = ['update' => 'Failed to update the listing.'];
            }
        } else {
            $_SESSION['errors'] = $errors;
        }

        // Redirect back to the edit page with form data if there are errors
        $_SESSION['form_data'] = $_POST;
        header("Location: ../edit-listings.php?id=" . $listing_id);
        exit();
    } else {
        $_SESSION['errors'] = ['update' => 'Invalid listing ID.'];
        header("Location: ../listings.php");
        exit();
    }
}

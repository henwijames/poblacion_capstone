<?php
session_start();
require_once '../../Models/Landlords.php';
require_once '../../Controllers/Database.php';

// Update Landlords Profile
if (isset($_POST['update-profile'])) {
    // Initialize Tenant model
    $database = new Database();
    $db = $database->getConnection();
    $landlordModel = new Landlords($db);

    // Get tenant ID (make sure this is available, for example from the session or a hidden field)
    $landlordId = $_SESSION['user_id']; // or another method of retrieving the tenant ID
    if (!$landlordId) {
        die('Landlord ID not found.');
    }

    // Collect form data
    $data = [
        'first_name' => $_POST['firstName'] ?? '',
        'middle_name' => $_POST['middleName'] ?? '',
        'last_name' => $_POST['lastName'] ?? '',
        'address' => $_POST['address'] ?? '',
        'phone_number' => $_POST['phoneNumber'] ?? '',
        'email' => $_POST['email'] ?? '',
        'property_name' => $_POST['propertyName'] ?? '',
    ];

    $photoPath = null;
    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/'; // Set your upload directory
        $photoPath = $uploadDir . basename($_FILES['profile_photo']['name']);

        // Move the uploaded file
        if (!move_uploaded_file($_FILES['profile_photo']['tmp_name'], $photoPath)) {
            $_SESSION['error_message'] = "Failed to upload photo.";
            header("Location: edit-profile.php?error=1");
            exit();
        }
    }

    // Update tenant profile
    if ($landlordModel->updateLandlords($landlordId, $data,  $photoPath)) {
        // Redirect or inform user of success
        $_SESSION['success_message'] = 'Profile updated successfully.';
        header('Location: ../edit-profile.php?success=1');
        exit();
    } else {
        $_SESSION['error_message'] = "An error occurred while updating your profile.";
        header("Location: ../edit-profile.php?error=1");
        exit();
    }
}

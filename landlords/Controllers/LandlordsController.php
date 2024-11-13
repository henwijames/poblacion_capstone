<?php
session_start();
require_once '../../Models/Landlords.php';
require_once '../../Models/Listing.php';
require_once '../../Controllers/Database.php';

// Update Landlords Profile
if (isset($_POST['update-profile'])) {
    // Initialize Tenant model
    $database = new Database();
    $db = $database->getConnection();
    $landlordModel = new Landlords($db);

    // Get Landlord ID (make sure this is available, for example from the session or a hidden field)
    $landlordId = $_SESSION['user_id']; // or another method of retrieving the Landlord ID
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

if (isset($_POST['save_permit'])) {
    $database = new Database();
    $db = $database->getConnection();
    $landlords = new Landlords($db);

    $landlordId = $_SESSION['user_id']; // or another method of retrieving the Landlord ID
    if (!$landlordId) {
        die('Landlord ID not found.');
    }

    $photoPath = null;
    if (isset($_FILES['permit']) && $_FILES['permit']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/'; // Set your upload directory
        $photoPath = $uploadDir . ($_FILES['permit']['name']);

        // Move the uploaded file
        if (!move_uploaded_file($_FILES['permit']['tmp_name'], $photoPath)) {
            $_SESSION['error_message'] = "Failed to upload photo.";
            header("Location: permit.php?error=1");
            exit();
        }
    }

    if ($landlords->savePermit($landlordId, $photoPath)) {
        // Redirect or inform user of success
        $_SESSION['success_message'] = 'Permit uploaded successfully.';
        header('Location: ../index?success=1');
        exit();
    } else {
        $_SESSION['error_message'] = "An error occurred while updating your profile.";
        header("Location: ../permit?error=1");
        exit();
    }
}

if (isset($_POST['save_qr'])) {
    $database = new Database();
    $db = $database->getConnection();
    $landlords = new Landlords($db);

    $landlordId = $_SESSION['user_id']; // or another method of retrieving the Landlord ID
    if (!$landlordId) {
        die('Landlord ID not found.');
    }

    $photoPath = null;
    $qrPayment = isset($_POST['qr_payment']) ? $_POST['qr_payment'] : null;
    if (isset($_FILES['qrcode']) && $_FILES['qrcode']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/'; // Set your upload directory
        $photoPath = $uploadDir . basename($_FILES['qrcode']['name']);

        // Move the uploaded file
        if (!move_uploaded_file($_FILES['qrcode']['tmp_name'], $photoPath)) {
            $_SESSION['error_message'] = "Failed to upload photo.";
            header("Location: qrcode.php?error=1");
            exit();
        }
    }

    if ($qrPayment && $photoPath) {
        // Save the QR code and payment method for the landlord
        if ($landlords->saveQR($landlordId, $photoPath)) {
            // Save also to the listings if necessary (linking landlord_id with user_id)
            $listings = new Listing($db);
            if ($listings->updateQrPayment($landlordId, $qrPayment)) {
                // Redirect or inform user of success
                $_SESSION['success_message'] = 'QR Code and Payment Method uploaded successfully.';
                header('Location: ../qrcode?success=1');
                exit();
            } else {
                $_SESSION['error_message'] = "Failed to update payment method in listings.";
                header("Location: ../qrcode?error=1");
                exit();
            }
        } else {
            $_SESSION['error_message'] = "An error occurred while updating QR code and payment method.";
            header("Location: ../qrcode?error=1");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "QR Code and Payment Method are required.";
        header("Location: ../qrcode?error=1");
        exit();
    }
}

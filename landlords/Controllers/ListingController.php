<?php
session_start();
require_once '../../Controllers/Database.php';
require_once '../../Models/Listing.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $database = new Database();
    $db = $database->getConnection();
    $listing = new Listing($db);

    // Retrieve and trim form data
    $listing->address = trim($_POST['address']);
    $listing->bedrooms = trim($_POST['bedrooms']);
    $listing->bathrooms = trim($_POST['bathrooms']);
    $listing->sqft = trim($_POST['sqft']);
    $listing->rent = trim($_POST['rent']);
    $listing->description = trim($_POST['description']);
    $listing->amenities = isset($_POST['amenities']) ? $_POST['amenities'] : [];

    // Validate input fields
    $errors = [];

    if (empty($listing->address)) {
        $errors['address'] = "Address is required";
    }
    if (empty($listing->bedrooms) || !is_numeric($listing->bedrooms)) {
        $errors['bedrooms'] = "Number of bedrooms is required and must be a number";
    }
    if (empty($listing->bathrooms) || !is_numeric($listing->bathrooms)) {
        $errors['bathrooms'] = "Number of bathrooms is required and must be a number";
    }
    if (empty($listing->sqft) || !is_numeric($listing->sqft)) {
        $errors['sqft'] = "Square meters is required and must be a number";
    }
    if (empty($listing->rent) || !is_numeric($listing->rent)) {
        $errors['rent'] = "Rent price is required and must be a number";
    }
    if (empty($listing->description)) {
        $errors['description'] = "Description is required";
    }

    // Handle file uploads
    $allowed_types = ['image/png', 'image/jpeg', 'image/gif'];
    $max_files = 5;
    $uploaded_files = [];
    $max_file_size = 10 * 1024 * 1024; // 10MB

    if (isset($_FILES['file-upload']) && !empty($_FILES['file-upload']['name'])) {
        if (is_array($_FILES['file-upload']['name'])) {
            foreach ($_FILES['file-upload']['tmp_name'] as $key => $tmp_name) {
                // Check file size
                if ($_FILES['file-upload']['size'][$key] > $max_file_size) {
                    $errors['file-upload'][] = "File size exceeds the limit of 10MB for file: " . $_FILES['file-upload']['name'][$key];
                    continue;
                }
                // Check file type
                $file_type = $_FILES['file-upload']['type'][$key];
                if (in_array($file_type, $allowed_types)) {
                    $upload_dir = 'uploads/';
                    $file_name = basename($_FILES['file-upload']['name'][$key]);
                    $upload_path = $upload_dir . $file_name;
                    if (move_uploaded_file($tmp_name, $upload_path)) {
                        $uploaded_files[] = $upload_path;
                    } else {
                        $errors['file-upload'][] = "Failed to upload file: " . $file_name;
                    }
                } else {
                    $errors['file-upload'][] = "Invalid file type for file: " . $_FILES['file-upload']['name'][$key];
                }
            }
        } else {
            // Check file size
            if ($_FILES['file-upload']['size'] > $max_file_size) {
                $errors['file-upload'][] = "File size exceeds the limit of 10MB for file: " . $_FILES['file-upload']['name'];
            } else {
                // Check file type
                $file_type = $_FILES['file-upload']['type'];
                if (in_array($file_type, $allowed_types)) {
                    $upload_dir = 'uploads/';
                    $file_name = basename($_FILES['file-upload']['name']);
                    $upload_path = $upload_dir . $file_name;
                    if (move_uploaded_file($_FILES['file-upload']['tmp_name'], $upload_path)) {
                        $uploaded_files[] = $upload_path;
                    } else {
                        $errors['file-upload'][] = "Failed to upload file: " . $file_name;
                    }
                } else {
                    $errors['file-upload'][] = "Invalid file type for file: " . $_FILES['file-upload']['name'];
                }
            }
        }
    }

    // Insert data if no errors
    if (empty($errors)) {
        try {
            $listingID = $listing->create();
            if ($listingID) {
                if ($listing->saveImages($listingID, $uploaded_files)) {
                    $_SESSION['success'] = "Listing created successfully!";
                    header("Location: ../index");
                    exit();
                } else {
                    $_SESSION['success'] = "Listing created successfully, but no images were uploaded.";
                    header("Location: ../index");
                    exit();
                }
            } else {
                throw new Exception("Failed to create listing.");
            }
        } catch (Exception $e) {
            $_SESSION['errors']['database'] = "Error: " . $e->getMessage();
            header("Location: ../add-listings");
            exit();
        }
    } else {
        $_SESSION['errors'] = $errors;
        $_SESSION['form_data'] = $_POST;
        header("Location: ../add-listings");
        exit();
    }
}

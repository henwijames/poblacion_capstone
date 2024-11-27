<?php
session_start();
require_once '../../Controllers/Database.php';
require_once '../../Models/Listing.php';

$errors = [];


//Add listings
if (isset($_POST['add_listing'])) {
    $database = new Database();
    $db = $database->getConnection();
    $listing = new Listing($db);

    // Retrieve and trim form data
    $listing->listing_name = trim($_POST['listing_name']);
    $listing->address = trim($_POST['address']);
    $listing->bedrooms = trim($_POST['bedrooms']);
    $listing->bathrooms = trim($_POST['bathrooms']);
    $listing->sqft = trim($_POST['sqft']);
    $listing->rent = trim($_POST['rent']);
    $listing->description = trim($_POST['description']);
    $listing->property_type = isset($_POST['property_type']) ? trim($_POST['property_type']) : null;
    $listing->amenities = isset($_POST['amenities']) ? $_POST['amenities'] : [];
    $listing->utilities = isset($_POST['utilities']) ? $_POST['utilities'] : [];
    $listing->user_id = $_SESSION['user_id'];
    $listing->payment_options = isset($_POST['payment_options']) ? $_POST['payment_options'] : [];

    // Validate input fields
    $errors = [];

    if (empty($listing->listing_name)) {
        $errors['listing_name'] = "Property Name is required";
    }
    if (empty($listing->address)) {
        $errors['address'] = "Address is required";
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
    if (empty($listing->property_type)) {
        $errors['property_type'] = "Property type is required";
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
                $data = ['id' => $listingID];
                // var_dump($data); // Debugging line
                // var_dump($uploaded_files); // Check if uploaded files are being populated
                // die();
                if ($listing->saveImages($data, $uploaded_files)) {
                    $_SESSION['success_add'] = "Listing created successfully!";
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

//Update Listing
if (isset($_POST['update_listing'])) {
    $listing_id = $_GET['id'] ?? null;

    if ($listing_id) {
        $database = new Database();
        $db = $database->getConnection();
        $listing = new Listing($db);

        // Collect form data
        $data = [
            'property_type' => $_POST['property_type'] ?? '',
            'listing_name' => $_POST['listing_name'] ?? '',
            'address' => $_POST['address'] ?? '',
            'bedrooms' => $_POST['bedrooms'] ?? '',
            'bathrooms' => $_POST['bathrooms'] ?? '',
            'amenities' => isset($_POST['amenities']) ? $_POST['amenities'] : [],
            'utilities' => isset($_POST['utilities']) ? $_POST['utilities'] : [],
            'sqft' => $_POST['sqft'] ?? '',
            'description' => $_POST['description'] ?? '',
            'payment_options' => isset($_POST['payment_options']) ? $_POST['payment_options'] : [],
            'id' => $listing_id
        ];

        // Add more validation as needed...

        if (empty($errors)) {
            // Check if new images were uploaded
            $newImagesUploaded = !empty($_FILES['file-upload']['name'][0]);

            // Only delete old images if new images are uploaded
            if ($newImagesUploaded) {
                if (!$listing->deleteImagesByListing($listing_id)) {
                    $_SESSION['error_message'] = ['update' => 'Failed to delete old images.'];
                    // Redirect to edit page on error
                    $_SESSION['form_data'] = $_POST;
                    header("Location: ../edit-listings.php?id=" . $listing_id);
                    exit();
                }
            }

            // Process image upload if new images are uploaded
            $uploadedImages = [];
            if ($newImagesUploaded) {
                $uploadedImages = $listing->uploadImages($_FILES['file-upload'], $listing_id);
            }

            // Update listing in the database
            if ($listing->updateListing($data, $uploadedImages)) {
                $_SESSION['success_message'] = 'Listing updated successfully.';
                header("Location: ../view-listings.php?id=" . $listing_id);
                exit();
            } else {
                $_SESSION['error_message'] = ['update' => 'Failed to update the listing.'];
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

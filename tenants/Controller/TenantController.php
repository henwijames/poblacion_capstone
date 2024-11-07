<?php
session_start();
require_once '../../Controllers/Database.php';
require_once '../../Models/Tenants.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Initialize Tenant model
    $database = new Database();
    $db = $database->getConnection();
    $tenantModel = new Tenants($db);

    // Get tenant ID (make sure this is available, for example from the session or a hidden field)
    $tenantId = $_SESSION['user_id']; // or another method of retrieving the tenant ID
    if (!$tenantId) {
        die('Tenant ID not found.');
    }

    $currentTenant = $tenantModel->findById($tenantId);
    $currentProfilePicture = $currentTenant['profile_picture'] ?? null;

    // Collect form data
    $data = [
        'first_name' => $_POST['firstName'] ?? '',
        'middle_name' => $_POST['middleName'] ?? '',
        'last_name' => $_POST['lastName'] ?? '',
        'address' => $_POST['address'] ?? '',
        'profile_picture' => $currentProfilePicture, // Profile picture, if uploaded
    ];


    // Handle Profile Picture Upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
        $fileName = $_FILES['profile_picture']['name'];
        $fileSize = $_FILES['profile_picture']['size'];
        $fileType = $_FILES['profile_picture']['type'];

        // Get the file extension
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        // Validate file extension
        if (in_array(strtolower($fileExtension), $allowedExtensions)) {
            // Define upload directory
            $uploadDir = 'uploads/'; // Adjust the path as needed
            $newFileName = 'profile_' . $tenantId . '.' . $fileExtension;
            $uploadFilePath = $uploadDir . $newFileName;

            // Move the uploaded file to the target directory
            if (move_uploaded_file($fileTmpPath, $uploadFilePath)) {
                // Update the profile picture path in the data array
                $data['profile_picture'] = $newFileName;
            } else {
                header('Location: ../edit-profile.php?error=upload_failed');
                exit();
            }
        } else {
            header('Location: ../edit-profile.php?error=invalid_file_type');
            exit();
        }
    }

    // Update tenant profile
    if ($tenantModel->updateTenant($tenantId, $data)) {
        // Redirect or inform user of success
        header('Location: ../edit-profile.php?success=1');
        exit();
    } else {
        // Handle error
        header('Location: ../edit-profile.php?error=update_failed');
        exit();
    }
}

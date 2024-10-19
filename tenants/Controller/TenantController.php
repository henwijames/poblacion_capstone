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

    // Collect form data
    $data = [
        'first_name' => $_POST['firstName'] ?? '',
        'middle_name' => $_POST['middleName'] ?? '',
        'last_name' => $_POST['lastName'] ?? '',
        'address' => $_POST['address'] ?? '',
        'phone_number' => $_POST['phoneNumber'] ?? '',
    ];

    // Update tenant profile
    if ($tenantModel->updateTenant($tenantId, $data)) {
        // Redirect or inform user of success
        header('Location: ../profile.php?status=success');
        exit();
    } else {
        // Handle error
        echo 'Error updating profile.';
    }
}

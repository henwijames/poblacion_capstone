
<?php
header('Content-Type: application/json');
include '../Controllers/Database.php';
require_once '../Models/Tenants.php';
$database = new Database();
$db = $database->getConnection();
$tenants = new Tenants($db);

if (isset($_GET['id'])) {
    $tenantId = $_GET['id'];

    // Assuming verifyLandlord is a function that verifies a landlord account
    $result = $tenants->verifyTenant($tenantId);

    if ($result) {
        // Return a successful response
        echo json_encode(['status' => 'success', 'message' => 'Account verified successfully.']);
    } else {
        // Return an error response
        echo json_encode(['status' => 'error', 'message' => 'Verification failed.']);
    }
} else {
    // If no ID is passed, return an error response
    echo json_encode(['status' => 'error', 'message' => 'Landlord ID not provided.']);
}

?>
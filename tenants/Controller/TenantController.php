<?php
session_start();
require_once '../../Controllers/Database.php';
require_once '../../Models/Tenants.php';
require '../../vendor/autoload.php'; // Ensure this path is correct
use Dotenv\Dotenv;

// Specify the path to your .env file
$dotenv = Dotenv::createImmutable('D:\xampp\htdocs\Poblacion'); // Change __DIR__ if your .env is in another directory

// Load the .env file and check for success
try {
    $dotenv->load();
} catch (Exception $e) {
    die('Failed to load .env file: ' . $e->getMessage());
}
// Check if the environment variable is set
if (!$_ENV['SMS_API']) {
    die("SMS_API is not set in the environment variables.");
}
function sendVerificationSMS($phone, $code)
{
    $ch = curl_init();
    $apiKey = $_ENV['SMS_API'];
    $senderName = 'SNIHS';
    $message = "Your verification code is: $code. It will expire in 5 minutes.";

    $url = "https://api.semaphore.co/api/v4/priority";
    $data   = [
        'apikey' => $apiKey,
        'number' => $phone,
        'message' => $message,
        'sendername' => $senderName
    ];


    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);

    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);


    if (!$output) {
        error_log('Error sending SMS: ' . curl_error($ch));
    }
}

$database = new Database();
$db = $database->getConnection();
$tenantModel = new Tenants($db);
$tenantId = $_SESSION['user_id']; // or another method of retrieving the tenant ID
if (!$tenantId) {
    die('Tenant ID not found.');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_tenant'])) {
    // Initialize Tenant model
    // Get tenant ID (make sure this is available, for example from the session or a hidden field)


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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['verify_mobile'])) {
    // Fetch the tenant details to check the stored verification code and expiration time
    $currentTenant = $tenantModel->findById($tenantId);
    $verificationCode = mt_rand(100000, 999999);
    $expiresAt = date('Y-m-d H:i:s', strtotime('+5 minutes'));

    $phone = $currentTenant['phone_number'] ?? null;

    if ($phone) {
        sendVerificationSMS($phone, $verificationCode);

        $updateData = [
            'verification_code' => $verificationCode,
            'verification_expires_at' => $expiresAt
        ];

        if ($tenantModel->smsVerCode($tenantId, $updateData)) {
            header('Location: ../verify-otp.php');
            exit();
        } else {
            header('Location: ../verifymobile.php?error=verification_failed');
            exit();
        }
    } else {
        $_SESSION['errors']['phone'] = "Phone number not found.";
        header('Location: ../verifymobile.php?error=phone_not_found');
        exit();
    }
}

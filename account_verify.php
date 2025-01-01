<?php
session_start();
require_once 'Controllers/Database.php';
require_once 'Models/Tenants.php';
require_once 'Models/Landlords.php';
require 'vendor/autoload.php'; // Ensure this path is correct

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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $tenants = new Tenants($db);
    $landlords = new Landlords($db);

    $user_id = $_SESSION['user_id'];
    $code = implode('', array_map('trim', $_POST['verification']));


    // Check if the user is a tenant or landlord
    if ($_SESSION['user_role'] == 'tenant') {
        // Retrieve the tenant by ID
        $tenant = $tenants->findById($user_id);

        date_default_timezone_set('Asia/Manila');

        // Get the current time and expiration time
        $current_time = time();
        $expires_at = strtotime($tenant['verification_expires_at']);

        // Check if the code matches and is not expired
        if ($tenant['verification_code'] === $code && $expires_at > $current_time) {
            // Code is valid, mark the phone number as verified
            $tenants->verifyPhoneNumber($user_id);
            $_SESSION['mobile_verified'] = true;
            $_SESSION['success'] = "Phone number verified successfully!";
            header("Location: email_verification.php"); // Redirect to email verification page
            exit();
        } else {
            // Code is invalid or expired
            $_SESSION['errors']['verification'] = "Invalid or expired verification code.";
            header("Location: account_verify.php"); // Redirect back to verification page
            exit();
        }
    }
    if ($_SESSION['user_role'] == 'landlord') {
        $verificationCode = $_SESSION['verification'];
        $landlords = new Landlords($db);
        $landlord = $landlords->findById($user_id);

        // Set timezone to Manila
        date_default_timezone_set('Asia/Manila');

        // Get the current time and expiration time
        $current_time = time();

        // Ensure the expiration time is parsed correctly
        $expires_at = strtotime($landlord['verification_expires_at']);

        // Debugging output for expiration time and current time
        echo "Current time (timestamp): " . $current_time . "<br>";
        echo "Expires at (timestamp): " . $expires_at . "<br>";

        // Check if the code matches and if the expiration time is greater than the current time
        if ($landlord["verification_code"] === $code && $expires_at > $current_time) {
            // Code is valid, mark the phone number as verified
            $landlords->verifyPhoneNumber($user_id);

            $_SESSION['success'] = "Phone number verified successfully!";
            header("Location: email_verification.php"); // Redirect to email verification page
            exit();
        } else {
            // Code is invalid or expired
            $_SESSION['errors'] = "Invalid or expired verification code.";
            header("Location: account_verify.php"); // Redirect back to verification page
            exit();
        }
    }
}
if (isset($_GET['resend_otp'])) {
    // Resend OTP logic
    $user_id = $_SESSION['user_id'];
    $database = new Database();
    $db = $database->getConnection();
    $tenants = new Tenants($db);
    $landlords = new Landlords($db);

    // Set the timezone to Asia/Manila
    date_default_timezone_set('Asia/Manila');

    if ($_SESSION['user_role'] == 'tenant') {
        $tenant = $tenants->findById($user_id);
        // Generate new OTP and expiration time
        $new_code = rand(100000, 999999);
        $expires_at = date('Y-m-d H:i:s', strtotime('+5 minutes'));

        // Update the tenant's verification code and expiration time
        $tenants->updateVerificationCode($user_id, $new_code, $expires_at);

        // Send the SMS with the new code
        sendVerificationSMS($tenant['phone_number'], $new_code); // Actual SMS sending

        $_SESSION['success'] = "A new OTP has been sent to your phone number.";
        header("Location: account_verify.php"); // Reload the verification page
        exit();
    }

    if ($_SESSION['user_role'] == 'landlord') {
        $landlord = $landlords->findById($user_id);
        // Generate new OTP and expiration time
        $new_code = rand(100000, 999999);
        $expires_at = date('Y-m-d H:i:s', strtotime('+5 minutes'));

        // Update the landlord's verification code and expiration time
        $landlords->updateVerificationCode($user_id, $new_code, $expires_at);

        // Send the SMS with the new code
        sendVerificationSMS($landlord['phone_number'], $new_code); // Actual SMS sending

        $_SESSION['success'] = "A new OTP has been sent to your phone number.";
        header("Location: account_verify.php"); // Reload the verification page
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PoblacionEase</title>

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/aos.css">

    <!-- FontAwesome CDN -->
    <script src="https://kit.fontawesome.com/f284e8c7c2.js" crossorigin="anonymous"></script>

    <!-- JQuery File -->
    <script src="./assets/js/jquery-3.7.1.min.js"></script>
</head>

<body>
    <div class="container mx-auto md:px-[120px] mb-4 px-6 py-2">
        <nav class="flex justify-center items-center mb-2">
            <a href="index"><img src="assets/img/poblacionease.png" alt="Poblacionease logo" class="w-[150px] h-[60px]"></a>

        </nav>
    </div>


    <div class="container mx-auto h-full flex items-center justify-center">
        <div class="flex flex-col items-center justify-center gap-4 py-12">
            <h1 class="text-4xl text-primary font-bold">Enter OTP from SMS</h1>
            <p class="text-center text-muted-foreground">Please verify your account to continue.</p>
            <div class=" p-8 rounded-lg  w-96">
                <form id="otpForm" class="space-y-4" method="POST" action="account_verify.php">
                    <div class=" flex justify-between">
                        <input type="text" name="verification[]" maxlength="1" class="w-12 h-12 text-center text-2xl border-2 border-gray-300 rounded-md focus:border-blue-500 focus:outline-none" required>
                        <input type="text" name="verification[]" maxlength="1" class="w-12 h-12 text-center text-2xl border-2 border-gray-300 rounded-md focus:border-blue-500 focus:outline-none" required>
                        <input type="text" name="verification[]" maxlength="1" class="w-12 h-12 text-center text-2xl border-2 border-gray-300 rounded-md focus:border-blue-500 focus:outline-none" required>
                        <input type="text" name="verification[]" maxlength="1" class="w-12 h-12 text-center text-2xl border-2 border-gray-300 rounded-md focus:border-blue-500 focus:outline-none" required>
                        <input type="text" name="verification[]" maxlength="1" class="w-12 h-12 text-center text-2xl border-2 border-gray-300 rounded-md focus:border-blue-500 focus:outline-none" required>
                        <input type="text" name="verification[]" maxlength="1" class="w-12 h-12 text-center text-2xl border-2 border-gray-300 rounded-md focus:border-blue-500 focus:outline-none" required>
                    </div>
                    <button type="submit" class="btn bg-primary w-full text-white">Verify OTP</button>
                </form>
                <div id="countdown" class=" text-center mt-4 text-red-500 font-semibold">
                    It will expire in 5 minutes.
                </div>
                <div class="text-center mt-4 btn bg-primary w-full">
                    <a href="?resend_otp=true" class="text-white hover:underline">Resend OTP</a>
                </div>
            </div>
        </div>
    </div>






    <script>
        const inputs = document.querySelectorAll('input[type="text"]');
        const form = document.getElementById('otpForm');

        inputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                if (e.target.value.length === 1) {
                    if (index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                }
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && e.target.value.length === 0) {
                    if (index > 0) {
                        inputs[index - 1].focus();
                    }
                }
            });
        });
    </script>
</body>

</html>
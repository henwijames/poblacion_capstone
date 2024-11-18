<?php
require '../vendor/autoload.php'; // Ensure this path is correct
use Dotenv\Dotenv;

// Specify the path to your .env file
$dotenv = Dotenv::createImmutable(__DIR__ . '/../'); // Change __DIR__ if your .env is in another directory

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

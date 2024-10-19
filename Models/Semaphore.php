<?php

function sendVerificationSMS($phone, $code)
{
    $ch = curl_init();
    $apiKey = 'f17b086e3d1e0a96cfb1a922f62dc33d';
    $senderName = 'SNIHS';
    $message = "Your verification code is: $code. It will expire in 5 minutes.";

    $url = "https://api.semaphore.co/api/v4/messages";
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

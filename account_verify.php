<?php
session_start();
include 'partials/session.php';
require_once 'Controllers/Database.php';
require_once 'Models/Tenants.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $tenants = new Tenants($db);

    $user_id = $_SESSION['user_id'];
    echo $user_id;
    $code = implode('', $_POST['verification_code']);

    // Retrieve the tenant by ID
    $tenant = $tenants->findById($user_id);


    // Check if the code matches and is not expired
    if ($tenant['verification_code'] === $code && strtotime($tenant['verification_expires_at']) > time()) {
        // Code is valid, mark the phone number as verified
        $tenants->verifyPhoneNumber($user_id);

        $_SESSION['success'] = "Phone number verified successfully!";
        $_SESSION['user_role'] = "tenant";
        header("Location: tenants/index");
        exit();
    } else {
        // Code is invalid or expired
        $_SESSION['errors']['verification'] = "Invalid or expired verification code.";
        header("Location: account_verify.php");
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
                        <input type="text" name="verification_code[]" maxlength="1" class="w-12 h-12 text-center text-2xl border-2 border-gray-300 rounded-md focus:border-blue-500 focus:outline-none" required>
                        <input type="text" name="verification_code[]" maxlength="1" class="w-12 h-12 text-center text-2xl border-2 border-gray-300 rounded-md focus:border-blue-500 focus:outline-none" required>
                        <input type="text" name="verification_code[]" maxlength="1" class="w-12 h-12 text-center text-2xl border-2 border-gray-300 rounded-md focus:border-blue-500 focus:outline-none" required>
                        <input type="text" name="verification_code[]" maxlength="1" class="w-12 h-12 text-center text-2xl border-2 border-gray-300 rounded-md focus:border-blue-500 focus:outline-none" required>
                        <input type="text" name="verification_code[]" maxlength="1" class="w-12 h-12 text-center text-2xl border-2 border-gray-300 rounded-md focus:border-blue-500 focus:outline-none" required>
                        <input type="text" name="verification_code[]" maxlength="1" class="w-12 h-12 text-center text-2xl border-2 border-gray-300 rounded-md focus:border-blue-500 focus:outline-none" required>
                    </div>
                    <button type="submit" class="btn bg-primary w-full">Verify OTP</button>
                </form>
                <div id="countdown" class="text-center mt-4 text-red-500 font-semibold">
                    It will expire in 5 minutes.
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
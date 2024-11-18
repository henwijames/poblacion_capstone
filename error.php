<?php
$error  = $_SERVER["REDIRECT_STATUS"];

$error_title = '';
$error_message = '';

if ($error ==  404) {
    $error_title = '404';
    $error_message = 'The document/file requested was not found on this server.';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($error_title); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-red-500 h-screen flex flex-col items-center justify-center p-6">
    <h1 class="text-[200px] font-bold text-white"><?php echo htmlspecialchars($error_title); ?></h1>
    <p class="text-white text-lg mb-6 text-center"><?php echo htmlspecialchars($error_message); ?></p>
    <a href="/" class="px-6 py-3 text-white rounded-md border border-white  transition">
        Go Back to Homepage
    </a>

</body>

</html>
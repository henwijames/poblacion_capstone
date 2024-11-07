<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Confirmation</title>
</head>

<body>
    <h1>Email Verification Status</h1>

    <?php if (isset($_SESSION['success'])): ?>
        <p style="color: green;"><?php echo $_SESSION['success'];
                                    unset($_SESSION['success']); ?></p>
    <?php elseif (isset($_SESSION['errors']['token'])): ?>
        <p style="color: red;">
            <?php echo $_SESSION['errors']['token'];
            unset($_SESSION['errors']['token']); ?>
        </p>
    <?php endif; ?>

    <a href="login.php">Go back to homepage</a>
</body>

</html>
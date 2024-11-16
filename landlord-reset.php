<?php
include 'partials/header.php';

use Dotenv\Dotenv;

require 'vendor/autoload.php';

$dotenv = Dotenv::createImmutable('D:\xampp\htdocs\Poblacion');
try {
    $dotenv->load();
} catch (Exception $e) {
    die('Failed to load .env file: ' . $e->getMessage());
}

include 'Controllers/Database.php';

// Retrieve the token from the URL
$token = $_GET['token'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'] ?? null;
    $newPassword = $_POST['password'] ?? null;
    if (!$token || !$newPassword) {
        $_SESSION['errors']['password'] = 'Invalid data provided.';
        header("Location: landlord-reset.php?token=" . urlencode($token));
        exit;
    }

    $db = new Database();
    $conn = $db->getConnection();
    $stmt = $conn->prepare("SELECT * FROM landlord_resets WHERE token = :token AND expiration > NOW()");
    $stmt->bindParam(':token', $token, PDO::PARAM_STR);
    $stmt->execute();
    $resetRequest = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$resetRequest) {
        $_SESSION['errors']['token'] = 'Invalid or expired token.';
        header("Location: landlord-reset.php?token=" . urlencode($token));
        exit;
    }

    $newPasswordHash = password_hash($newPassword, PASSWORD_BCRYPT);
    $userId = $resetRequest['user_id'];
    $stmt = $conn->prepare("UPDATE landlords SET password = :password WHERE id = :user_id");
    $stmt->bindParam(':password', $newPasswordHash, PDO::PARAM_STR);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $stmt = $conn->prepare("DELETE FROM landlord_resets WHERE token = :token");
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);
        $stmt->execute();

        $_SESSION['message'] = 'Your password has been successfully reset.';
        header('Location: login.php');
        exit;
    } else {
        $_SESSION['errors']['password'] = 'Failed to reset password. Please try again.';
        header("Location: landlord-reset.php?token=" . urlencode($token));
        exit;
    }
}
?>

<main class="home flex flex-col items-center justify-center min-h-screen">
    <div class="relative flex flex-col m-6 space-y-8 bg-white shadow-2xl rounded-2xl md:flex-row md:space-y-0">
        <div class="flex flex-col justify-center p-8 md:p-14">
            <span class="mb-2 text-2xl font-bold text-[#C1C549] uppercase">Reset your <span class="text-secondary">Password</span></span>
            <?php
            if (isset($_SESSION['errors']['token'])) {
                echo "<p style='color:red'>{$_SESSION['errors']['token']}</p>";
                unset($_SESSION['errors']['token']);
            }
            ?>
            <form action="landlord-reset.php" method="POST">
                <div class="py-4">
                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token, ENT_QUOTES, 'UTF-8'); ?>">
                    <p class="mb-2 text-md">New Password</p>
                    <input type="password" class="w-full p-2 border border-gray-300 rounded-md placeholder:font-light placeholder:text-gray-500" name="password" id="password" placeholder="New Password">
                    <?php if (isset($_SESSION['errors']['password'])): ?>
                        <p class="text-red-500 text-sm"><?php echo htmlspecialchars($_SESSION['errors']['password']); ?></p>
                    <?php endif; ?>
                </div>
                <button id="login-button" class="btn bg-primary w-full mb-3 text-white" type="submit">
                    <span id="login-text">Submit</span>
                    <img id="login-loader" src="assets/loader2.gif" style="display: none; width: 20px; height: 20px; vertical-align: middle; margin-left: 10px;">
                </button>
            </form>
            <div class="text-center text-gray-400">
                Go back to <a href="choose" class="text-black font-bold hover:text-[#C1C549]">Login</a>
            </div>
        </div>
        <div class="relative">
            <img src="assets/img/poblacionease.png" alt="signin" class="absolute hidden md:block inset-0 m-auto h-[200px] z-20 shadow-md">
            <img src="assets/img/volcano.jpg" alt="img" class="w-[400px] h-full hidden rounded-r-2xl md:block object-cover">
            <div class="absolute top-0 left-0 z-10 w-full h-full bg-[#FBFBF3] opacity-50 rounded-r-2xl md:block"></div>
        </div>
    </div>
</main>
</body>

</html>
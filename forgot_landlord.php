<?php
include 'partials/header.php';

$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
$formData = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];

// Clear session data
unset($_SESSION['errors']);
unset($_SESSION['form_data']);

?>
<main class="home  flex flex-col items-center justify-center min-h-screen">
    <div class="relative flex flex-col m-6 space-y-8 bg-white shadow-2xl rounded-2xl md:flex-row md:space-y-0">
        <div class="flex flex-col justify-center p-8 md:p-14">
            <span class="mb-2 text-2xl font-bold text-[#C1C549] uppercase">Forgot <span class="text-secondary">Password?</span></span>
            <span class="font-light text-gray-400 mb-4">
                Enter your email and we'll send you a link to reset your password.
            </span>
            <form action="Controllers/ForgotLandlordController.php" method="POST">
                <?php if (isset($errors['login'])): ?>
                    <p class="text-red-500 text-sm mb-4"><?php echo htmlspecialchars($errors['login']); ?></p>
                <?php endif; ?>
                <div class="py-4">
                    <span class="mb-2 text-md">Email</span>
                    <input type="text" class="w-full p-2 border border-gray-300 rounded-md
                placeholder:font-light placeholder:text-gray-500" name="email" id="email" placeholder="johndoe@email.com" value="<?php echo htmlspecialchars($formData['email'] ?? ''); ?>">
                    <?php if (isset($errors['email'])): ?>
                        <p class="text-red-500 text-sm"><?php echo htmlspecialchars($errors['email']); ?></p>
                    <?php endif; ?>
                </div>
                <button id="login-button" class="btn bg-primary w-full mb-3 text-white"
                    type="submit">
                    <span id="login-text">Submit</span>
                    <img id="login-loader" src="assets/loader2.gif" style="display: none; width: 20px; height: 20px; vertical-align: middle; margin-left: 10px;">
                </button>
            </form>
            <div class="text-center text-gray-400">

                Go back to <a href="login" class="text-black font-bold hover:text-[#C1C549]">Login</a>
            </div>
        </div>
        <div class="relative">
            <img src="assets/img/poblacionease.png" alt="signin" class="absolute hidden md:block inset-0 m-auto h-[200p] z-20 shadow-md">
            <img src="assets/img/volcano.jpg" alt="img" class="w-[400px] h-full hidden rounded-r-2xl md:block object-cover">
            <div class="absolute top-0 left-0 z-10 w-full h-full bg-[#FBFBF3] opacity-50 rounded-r-2xl md:block"></div>
        </div>
    </div>

</main>
<script>
    document.querySelector('form').addEventListener('submit', function(e) {

        let loginButton = document.getElementById('login-button');
        // Prevent the form from submitting immediately
        e.preventDefault();

        // Show the GIF loader
        document.getElementById('login-loader').style.display = 'inline-block';
        document.getElementById('login-text').textContent = 'Logging in...';

        // Disable the button to prevent multiple submissions
        loginButton.disabled = true;
        loginButton.classList.remove('hover:bg-accent');

        const form = this;
        setTimeout(function() {
            form.submit();
        }, 2000);
    });
</script>

</body>

</html>
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
            <span class="mb-3 text-5xl font-bold text-[#C1C549] uppercase">log<span class="text-secondary">in</span></span>
            <span class="font-light text-gray-400 mb-4">
                Welcome back to <a href="index" class="font-bold">Poblacion<span class="text-primary">Ease</span></a>. Please login to your account.
            </span>
            <form action="Controllers/LoginController.php" method="POST">
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
                <div class="py-4">
                    <span class="mb-2 text-md">Password</span>
                    <input type="password" class="w-full p-2 border border-gray-300 rounded-md
                placeholder:font-light placeholder:text-gray-500" name="password" id="password" placeholder="Enter your password">
                    <?php if (isset($errors['password'])): ?>
                        <p class=" text-red-500 text-sm"><?php echo htmlspecialchars($errors['password']); ?></p>
                    <?php endif; ?>
                </div>
                <div class="flex justify-between w-full py-4">
                    <div class="mr-24">
                        <input type="checkbox" name="ch" id="ch" class="mr-2">
                        <span class="text-md">Remember for 30 days</span>
                    </div>
                    <a href="#" class="font-bold text-md hover:text-gray-400 transition-colors ease">Forgot Password?</a>
                </div>
                <button id="login-button" class="w-full bg-[#C1C549] text-white p-2 rounded-lg mb-6 flex items-center justify-center
                    hover:bg-accent border-[#C1C549] hover:border 
                    hover:border-gray-300 transition-all ease-in uppercase shadow"
                    type="submit">
                    <span id="login-text">Login</span>
                    <img id="login-loader" src="assets/loader2.gif" style="display: none; width: 20px; height: 20px; vertical-align: middle; margin-left: 10px;">
                </button>
            </form>
            <div class="text-center text-gray-400">
                Don't have an account? <a href="choose" class="text-black font-bold hover:text-[#C1C549]">Sign Up</a>
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
        // Prevent the form from submitting immediately
        e.preventDefault();

        // Show the GIF loader
        document.getElementById('login-loader').style.display = 'inline-block';
        document.getElementById('login-text').textContent = 'Logging in...';

        // Disable the button to prevent multiple submissions
        document.getElementById('login-button').disabled = true;

        // Save the form reference to use later
        const form = this;

        // Use setTimeout to delay the form submission by 3 seconds
        setTimeout(function() {

            // Manually trigger form submission after 3 seconds
            form.submit();
        }, 2000); // 3000 milliseconds = 3 seconds
    });
</script>

</body>

</html>
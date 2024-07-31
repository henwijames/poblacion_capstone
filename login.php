<?php include 'partials/header.php'; ?>

<main class="home flex items-center justify-center min-h-screen">
    <div class="relative flex flex-col m-6 space-y-8 bg-white shadow-2xl rounded-2xl md:flex-row md:space-y-0">
        <div class="flex flex-col justify-center p-8 md:p-14">
            <span class="mb-3 text-4xl font-bold text-[#C1C549]">Sign In</span>
            <span class="font-light text-gray-400 mb-8">
                Welcome back to PoblacionEase. Please login to your account.
            </span>
            <div class="py-4">
                <span class="mb-2 text-md">Email</span>
                <input type="text" class="w-full p-2 border border-gray-300 rounded-md
                placeholder:font-light placeholder:text-gray-500" name="email" id="email" placeholder="johndoe@email.com">
            </div>
            <div class="py-4">
                <span class="mb-2 text-md">Password</span>
                <input type="text" class="w-full p-2 border border-gray-300 rounded-md
                placeholder:font-light placeholder:text-gray-500" name="password" id="password" placeholder="Enter your password">
            </div>
            <div class="flex justify-between w-full py-4">
                <div class="mr-24">
                    <input type="checkbox" name="ch" id="ch" class="mr-2">
                    <span class="text-md">Remember for 30 days</span>
                </div>
                <a href="#" class="font-bold text-md">Forgot Password</a>
            </div>
            <button class="w-full bg-[#C1C549] text-white p-2 rounded-lg mb-6 
            hover:bg-white hover:text-black border border-[#C1C549] hover:border hover:border-gray-300 transition-all ease-in">
                Sign In
            </button>
            <div class="text-center text-gray-400">
                Don't have an account? <a href="signup" class="text-black font-bold hover:text-[#C1C549]">Sign Up</a>
            </div>
        </div>
        <div class="relative">
            <img src="assets/img/signin.png" alt="signin" class="absolute inset-0 m-auto h-1/2 z-20">
            <img src="assets/img/volcano.jpg" alt="img" class="w-[400px] h-full hidden rounded-r-2xl md:block object-cover">
            <div class="absolute top-0 left-0 z-10 w-full h-full bg-[#FBFBF3] opacity-50 rounded-r-2xl md:block"></div>
        </div>
    </div>

</main>

<?php include 'partials/footer.php'; ?>
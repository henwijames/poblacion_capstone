<!DOCTYPE html>
<?php
// session_start();
// include 'session.php';
?>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PoblacionEase</title>

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/aos.css">
    <!-- FontAwesome CDN -->
    <script src="https://kit.fontawesome.com/f284e8c7c2.js" crossorigin="anonymous"></script>
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- JQuery File -->
    <script src="assets/js/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container mx-auto h-full flex items-center justify-center">
        <div class="flex flex-col items-center justify-center gap-4 py-12">
            <h1 class="text-4xl text-primary font-bold">Enter OTP from SMS</h1>
            <p class="text-center text-muted-foreground">Please verify your account to continue.</p>
            <div class=" p-8 rounded-lg  w-96">
                <form id="otpForm" class="space-y-4">
                    <div class="flex justify-between">
                        <input type="text" maxlength="1" class="w-12 h-12 text-center text-2xl border-2 border-gray-300 rounded-md focus:border-blue-500 focus:outline-none" required>
                        <input type="text" maxlength="1" class="w-12 h-12 text-center text-2xl border-2 border-gray-300 rounded-md focus:border-blue-500 focus:outline-none" required>
                        <input type="text" maxlength="1" class="w-12 h-12 text-center text-2xl border-2 border-gray-300 rounded-md focus:border-blue-500 focus:outline-none" required>
                        <input type="text" maxlength="1" class="w-12 h-12 text-center text-2xl border-2 border-gray-300 rounded-md focus:border-blue-500 focus:outline-none" required>
                        <input type="text" maxlength="1" class="w-12 h-12 text-center text-2xl border-2 border-gray-300 rounded-md focus:border-blue-500 focus:outline-none" required>
                        <input type="text" maxlength="1" class="w-12 h-12 text-center text-2xl border-2 border-gray-300 rounded-md focus:border-blue-500 focus:outline-none" required>
                    </div>
                    <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 transition duration-300">Verify OTP</button>
                </form>
            </div>
        </div>
    </div>

</body>
<script>
    //Start Sidebar
    const sidebarToggle = document.querySelector(".sidebar-toggle");
    const sidebarOverlay = document.querySelector(".sidebar-overlay");
    const sidebarMenu = document.querySelector(".sidebar-menu");
    const main = document.querySelector(".main");

    sidebarToggle.addEventListener("click", (e) => {
        e.preventDefault();
        main.classList.toggle("active");
        sidebarOverlay.classList.toggle("hidden");
        sidebarMenu.classList.toggle("-translate-x-full");
    });

    sidebarOverlay.addEventListener("click", (e) => {
        e.preventDefault();
        main.classList.add("active");
        sidebarOverlay.classList.toggle("hidden");
        sidebarMenu.classList.toggle("-translate-x-full");
    });

    document.querySelectorAll(".sidebar-dropdown-toggle").forEach((item) => {
        item.addEventListener("click", (e) => {
            e.preventDefault();
            const parent = item.closest(".group");
            if (parent.classList.contains("selected")) {
                parent.classList.remove("selected");
            } else {
                document.querySelectorAll(".sidebar-dropdown-toggle").forEach((item) => {
                    item.closest(".group").classList.remove("selected");
                });
                parent.classList.add("selected");
            }
            parent.classList.add("selected");
        });
    });

    document.querySelectorAll(".dropdown-toggle").forEach((button) => {
        button.addEventListener("click", () => {
            const dropdownMenu = button.nextElementSibling;

            // Toggle the hidden class to show/hide the dropdown
            dropdownMenu.classList.toggle("hidden");

            // Close any other open dropdowns
            document.querySelectorAll(".dropdown-menu").forEach((menu) => {
                if (menu !== dropdownMenu) {
                    menu.classList.add("hidden");
                }
            });
        });
    });

    // Optional: Close the dropdown if clicked outside
    document.addEventListener("click", (e) => {
        const isDropdown =
            e.target.matches(".dropdown-toggle") || e.target.closest(".dropdown");
        if (!isDropdown) {
            document.querySelectorAll(".dropdown-menu").forEach((menu) => {
                menu.classList.add("hidden");
            });
        }
    });

    //End Sidebar
</script>

</html>
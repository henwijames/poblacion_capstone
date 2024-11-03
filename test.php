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
    <div class="container mx-auto flex items-center justify-center gap-16 ">
        <img src=" assets/img/notif.svg" alt="notif" class="relative">
        <div class="container mx-auto md:px-[120px] mb-4 px-6 py-2 absolute top-10">
            <nav class="flex justify-center items-center mb-2">
                <a href="index"><img src="assets/img/poblacionease.png" alt="Poblacionease logo" class="w-[150px] h-[60px]"></a>
            </nav>
        </div>
        <div class="flex flex-col items-center justify-center gap-4 py-12 absolute bottom-5">
            <h1 class="text-xl sm:text-3xl font-bold">Email Verification</h1>
            <p>Please verify your email to continue.</p>
            <form method="POST">
                <button type="submit" class="btn bg-primary text-white">Send to Email</button>
            </form>
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
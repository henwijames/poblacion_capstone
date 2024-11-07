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
    <a href="approve.php?id=<?php echo $inquiry['id']; ?>" class="btn btn-info btn-sm text-sm text-white">Profile</a>
    <a href="approve.php?id=<?php echo $inquiry['id']; ?>" class="btn btn-sm text-sm bg-primary text-white">Approve</a>
    <a href="reject.php?id=<?php echo $inquiry['id']; ?>" class="btn btn-sm text-sm btn-error text-white">Reject</a>


</body>
<script>
    $(document).ready(function() {

        let clickedEyeIcon = false;

        // Toggle password visibility
        $('#show-password').on('mousedown', function() {
            clickedEyeIcon = true;
            const passwordInput = $('#password');
            const icon = $(this).find('i');

            if (passwordInput.attr('type') === 'password') {
                passwordInput.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                passwordInput.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        }).on('mouseup', function() {
            setTimeout(() => clickedEyeIcon = false, 0);
        });

        $('#password').on('focus', function() {
            $('#requirements').removeClass('hidden');
            $('#show-password').removeClass('hidden');
        }).on('focusout', function() {
            if (!clickedEyeIcon) {
                $('#requirements').addClass('hidden');
                $('#show-password').addClass('hidden');
            }
        });

        $('#password').on('input', function() {
            const password = $(this).val();

            // Show requirements box when typing
            if (password.length > 0) {
                $('#requirements').removeClass('hidden');
            } else {
                $('#requirements').addClass('hidden');
            }

            // Validation checks
            $('#length').toggleClass('text-green-500', password.length >= 8)
                .toggleClass('text-red-500', password.length < 8);

            $('#special').toggleClass('text-green-500', /[!@#$%^&*(),.?":{}|<>]/.test(password))
                .toggleClass('text-red-500', !/[!@#$%^&*(),.?":{}|<>]/.test(password));

            $('#lowercase').toggleClass('text-green-500', /[a-z]/.test(password))
                .toggleClass('text-red-500', !/[a-z]/.test(password));

            $('#uppercase').toggleClass('text-green-500', /[A-Z]/.test(password))
                .toggleClass('text-red-500', !/[A-Z]/.test(password));

            $('#number').toggleClass('text-green-500', /\d/.test(password))
                .toggleClass('text-red-500', !/\d/.test(password));


            const requirements = [{
                    selector: '#length',
                    condition: password.length >= 8
                },
                {
                    selector: '#special',
                    condition: /[!@#$%^&*(),.?":{}|<>]/.test(password)
                },
                {
                    selector: '#lowercase',
                    condition: /[a-z]/.test(password)
                },
                {
                    selector: '#uppercase',
                    condition: /[A-Z]/.test(password)
                },
                {
                    selector: '#number',
                    condition: /\d/.test(password)
                },
            ];

            let allValid = true;
            requirements.forEach(requirement => {
                const icon = $(requirement.selector).find('i');
                if (requirement.condition) {
                    icon.removeClass('fa-times-circle text-red-500').addClass('fa-check-circle text-green-500');
                } else {
                    icon.removeClass('fa-check-circle text-green-500').addClass('fa-times-circle text-red-500');
                    allValid = false;
                }
            });

            // Update validation icon based on allValid status
            const validationIcon = $('#validation-icon i');
            if (allValid) {
                $('#validation-icon').removeClass('text-red-500').addClass('text-green-500');
                validationIcon.removeClass('fa-times-circle').addClass('fa-check-circle');
                $('#requirements').addClass('hidden'); // Hide requirements box if valid
            } else {
                $('#validation-icon').removeClass('text-green-500').addClass('text-red-500');
                validationIcon.removeClass('fa-check-circle').addClass('fa-times-circle');
            }
        });
    });

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

    function previewProfilePhoto(event) {
        const reader = new FileReader();
        const fileInput = event.target;

        reader.onload = function() {
            const imageElement = document.getElementById('profilePhoto');
            imageElement.src = reader.result; // Set the new image source to the uploaded file
        };

        if (fileInput.files[0]) {
            reader.readAsDataURL(fileInput.files[0]); // Read the selected file and convert to a data URL
        }
    }

    //End Sidebar
</script>

</html>
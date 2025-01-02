<!DOCTYPE html>
<?php
session_start();
include 'session.php';
include '../Controllers/Database.php';
include '../Models/Listing.php';
include '../Models/Landlords.php';

$userName = "Guest";
$defaultProfilePicture = "../assets/img/me.jpg"; //Default profile picture

if (isset($_SESSION['user_id']) && isset($_SESSION['user_role'])) {
    require_once '../Models/Tenants.php';
    require_once '../Models/Landlords.php';


    $database = new Database();
    $db = $database->getConnection();

    if ($_SESSION['user_role'] == 'tenant') {
        $tenants = new Tenants($db);
        $tenant = $tenants->findById($_SESSION['user_id']);
        $fullName = $tenant['first_name'] . " " . $tenant['middle_name'] . " " . $tenant['last_name']; // Full name of the tenant
        $userName = $tenant['first_name']; // Replace 'first_name' with the actual column name
        if (empty($tenant['profile_picture'])) {
            $profilePicture = $defaultProfilePicture;
        } else {
            $profilePicture = $tenant['profile_picture']; // Assuming 'profile_picture' is the column name for the profile picture
        }
    } elseif ($_SESSION['user_role'] == 'landlord') {
        $landlords = new Landlords($db);
        $landlord = $landlords->findById($_SESSION['user_id']);
        $userName = $landlord['name']; // Replace 'name' with the actual column name
        $profilePicture = $landlord['profile_picture']; // Replace 'profile_picture' with the actual column name
    }
}
?>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PoblacionEase</title>

    <link rel="stylesheet" href="../assets/css/style.css">

    <!-- FontAwesome CDN -->
    <script src="https://kit.fontawesome.com/f284e8c7c2.js" crossorigin="anonymous"></script>
    <!-- Swiper CSS -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- JQuery File -->
    <script src="../assets/js/jquery-3.7.1.min.js"></script>
    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Animate CSS -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>

<body class="font-custom">
    <?php require 'includes/sidebar.php'; ?>

    <main class="main-content main">
        <?php require 'includes/topbar.php'; ?>
        <div class="p-6">
            <div class="bg-white rounded-lg overflow-hidden">

                <div class="relative px-4 py-6">

                    <h1 class="text-3xl font-bold text-gray-800 mb-8">Edit Profile</h1>
                    <?php if (isset($_GET['success'])): ?>
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Profile updated successfully!',
                                confirmButtonColor: '#C1C549',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = 'profile.php'; // Redirect to the same page to clear the query string
                                }
                            });
                        </script>
                    <?php elseif (isset($_GET['error'])): ?>
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong! Please try again.',
                                confirmButtonColor: '#C1C549',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = 'edit-profile.php'; // Redirect to the same page to clear the query string
                                }
                            });
                        </script>
                    <?php endif; ?>
                    <form class="space-y-6" method="POST" action="Controller/TenantController.php" enctype="multipart/form-data">
                        <div class="flex items-center space-x-6">
                            <div class="shrink-0">
                                <img id="profilePhoto" class="h-16 w-16 object-cover rounded-full" src="<?php echo !empty($tenant['profile_picture']) ? 'Controller/uploads/' . htmlspecialchars($tenant['profile_picture']) : '../assets/img/me.jpg'; ?>" alt="Current profile photo" />
                            </div>
                            <label class="block">
                                <span class="sr-only">Choose profile photo</span>
                                <input type="file" name="profile_picture" class="block w-full cursor-pointer text-sm text-slate-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-violet-50 file:text-primary
                            hover:file:bg-accent
                            "
                                    onchange="validateFileSize(event)"
                                    accept=" image/jpg, image/jpeg, image/png"
                                    value="<?php echo htmlspecialchars($tenant['profile_picture']); ?>" />
                            </label>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="firstName" class="block text-sm font-medium text-gray-700">First Name</label>
                                <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($tenant['first_name']); ?>" class="input input-bordered w-full">
                            </div>
                            <div>
                                <label for="middleName" class="block text-sm font-medium text-gray-700">Middle Name</label>
                                <input type="text" id="middleName" name="middleName" value="<?php echo htmlspecialchars($tenant['middle_name']); ?>" class="input input-bordered w-full">
                            </div>
                            <div>
                                <label for="lastName" class="block text-sm font-medium text-gray-700">Last Name</label>
                                <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($tenant['last_name']); ?>" class="input input-bordered w-full">
                            </div>
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($tenant['address']); ?>" class="input input-bordered w-full">
                            </div>
                        </div>
                        <div class="flex justify-end space-x-4">
                            <a href="profile" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                Cancel
                            </a>
                            <button type="submit" name="update_tenant" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-accent ">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script>
        function validateFileSize(event) {
            const file = event.target.files[0]; // Get the selected file
            if (file && file.size > 2 * 1024 * 1024) { // Check if file size exceeds 2MB
                Swal.fire({
                    icon: 'error',
                    title: 'File Too Large',
                    text: 'The selected file exceeds the 2MB limit. Please choose a smaller file.',
                });
                event.target.value = ''; // Clear the input
            } else {
                previewProfilePhoto(event); // Call your preview function if file size is valid
            }
        }

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
    </script>
    <?php require 'includes/footer.php'; ?>
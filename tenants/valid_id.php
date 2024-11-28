<!DOCTYPE html>
<?php
session_start();
include 'session.php';
include '../Controllers/Database.php';
include '../Models/Listing.php';
include '../Models/Landlords.php';
include '../Models/Tenants.php';

$userName = "Guest";
$defaultProfilePicture = "../assets/img/me.jpg"; //Default profile picture

if (isset($_SESSION['user_id']) && isset($_SESSION['user_role'])) {
    require_once '../Models/Tenants.php';


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
        <?php include 'includes/topbar.php'; ?>
        <div class="p-6">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold mb-6">Upload/Update Valid ID</h1>
            </div>
            <form action="Controller/TenantController.php" method="POST" enctype="multipart/form-data">
                <div class="flex flex-col md:items-start items-end justify-center">
                    <div class="mb-4">
                        <img id="profilePhoto" class="h-[400px] w-[400px] object-contain mb-6" src="../assets/img/permit.svg" alt="Current profile photo" />
                        <input type="file" name="validid" class="file-input file-input-bordered w-full max-w-xs" onchange="previewProfilePhoto(event)" />
                    </div>
                </div>
                <div>
                    <button type="submit" name="save_valid" class="btn bg-primary text-white">
                        Save
                    </button>
                    <a href="index" class="btn btn-outline ">
                        Cancel
                    </a>
                </div>

            </form>



        </div>
    </main>
    <script>
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
    <?php include 'includes/footer.php'; ?>
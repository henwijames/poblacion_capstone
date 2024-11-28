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

    <?php
    if (isset($_SESSION['success_valid'])) {
        echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{$_SESSION['success_valid']}',
            showConfirmButton: false,
            timer: 1500
        });
    </script>";
        // Clear the session variable so the message doesn't show again on reload.
        unset($_SESSION['success_valid']);
    }
    if (isset($_SESSION['error_valid'])) {
        echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{$_SESSION['error_valid']}',
            showConfirmButton: false,
            timer: 1500
        });
    </script>";
        // Clear the session variable so the message doesn't show again on reload.
        unset($_SESSION['error_valid']);
    }
    ?>

    <?php require 'includes/sidebar.php'; ?>



    <main class="main-content main">

        <?php require 'includes/topbar.php'; ?>
        <div class="flex flex-col">
            <!-- Cover Image -->
            <img src="../assets/img/volcano.jpg" alt="User Cover"
                class="w-full h-auto max-h-[20rem] object-cover" />

            <!-- Profile Image and Name -->
            <div class="sm:w-[80%] xs:w-[90%] mx-auto flex flex-col items-center -mt-16">
                <img src="<?php echo !empty($tenant['profile_picture']) ? 'Controller/uploads/' . htmlspecialchars($tenant['profile_picture']) : '../assets/img/me.jpg'; ?>" alt="User Profile"
                    class="rounded-full object-cover w-28 h-28 sm:w-32 sm:h-32 lg:w-48 lg:h-48 outline outline-2 outline-offset-2 relative" />
                <div class="flex flex-col sm:flex-row justify-center items-center gap-4 my-6">
                    <h1 class="text-center text-primary text-2xl sm:text-3xl lg:text-4xl">
                        <?php echo htmlspecialchars($fullName); ?>
                    </h1>
                    <span class="badge text-sm inline-flex items-center capitalize text-white 
                    <?php echo ($tenant['account_status'] === 'pending') ? 'badge-warning' : ''; ?>
                    <?php echo ($tenant['account_status'] === 'verified') ? 'badge-success' : ''; ?>
                    <?php echo ($tenant['account_status'] === 'not verified') ? 'badge-error' : ''; ?>">
                        <?php echo htmlspecialchars($tenant['account_status']); ?>
                    </span>
                </div>



            </div>

            <!-- Details Section -->
            <div class="w-full px-4 md:px-6 lg:px-0 xl:w-[80%] lg:w-[90%] mx-auto flex flex-col gap-4 items-center relative -mt-6">
                <!-- Detail -->
                <div class="w-full my-auto py-6 flex flex-col md:flex-row gap-4 justify-center">
                    <div class="w-full">
                        <dl class="text-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                            <div class="flex flex-col pb-3">
                                <dt class="mb-1 text-gray-500 text-md md:text-lg dark:text-gray-400">First Name</dt>
                                <dd class="text-lg font-semibold"><?php echo htmlspecialchars($userName); ?></dd>
                            </div>
                            <div class="flex flex-col py-3">
                                <dt class="mb-1 text-gray-500 text-md md:text-lg dark:text-gray-400">Middle Name</dt>
                                <dd class="text-lg font-semibold"><?php echo htmlspecialchars($tenant["middle_name"]); ?></dd>
                            </div>
                            <div class="flex flex-col py-3">
                                <dt class="mb-1 text-gray-500 text-md md:text-lg dark:text-gray-400">Last Name</dt>
                                <dd class="text-lg font-semibold"><?php echo htmlspecialchars($tenant["last_name"]); ?></dd>
                            </div>
                        </dl>
                    </div>
                    <div class="w-full">
                        <dl class="text-gray-900 divide-y divide-gray-200  dark:divide-gray-700">
                            <div class="flex flex-col pb-3">
                                <dt class="mb-1 text-gray-500 text-md md:text-lg dark:text-gray-400">Address</dt>
                                <dd class="text-lg font-semibold"><?php echo htmlspecialchars($tenant["address"]); ?></dd>
                            </div>
                            <div class="flex flex-col pt-3">
                                <dt class="mb-1 text-gray-500 text-md md:text-lg dark:text-gray-400">Phone Number</dt>
                                <dd class="text-lg font-semibold"><?php echo htmlspecialchars($tenant["phone_number"]); ?></dd>
                            </div>
                            <div class="flex flex-col pt-3">
                                <dt class="mb-1 text-gray-500 text-md md:text-lg dark:text-gray-400">Email</dt>
                                <dd class="text-lg font-semibold"><?php echo htmlspecialchars($tenant["email"]); ?></dd>
                            </div>
                        </dl>
                    </div>
                </div>
                <div class="flex justify-center gap-2 py-2">
                    <a href="edit-profile" class="bg-primary text-white btn">Edit Profile</a>
                    <button class="bg-primary text-white btn" onclick="my_modal_1.showModal()">Valid ID</button>
                    <dialog id="my_modal_1" class="modal">
                        <div class="modal-box">
                            <h3 class="text-lg font-bold">Valid ID</h3>
                            <img src="<?php echo ($tenant['validid']) ? 'Controller/uploads/' . htmlspecialchars($tenant['validid']) : ''; ?>"
                                alt="<?php echo ($tenant['validid']) ? 'Valid ID' : 'No Valid ID Uploaded'; ?>">
                            <div class="modal-action">
                                <form method="dialog">
                                    <button class="btn">Close</button>
                                </form>
                            </div>
                        </div>
                    </dialog>
                </div>
            </div>
        </div>
    </main>
    <?php
    if (isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'tenant') {
        $database = new Database();
        $db = $database->getConnection();
        $tenantId = $_SESSION['user_id'];
        $tenant = new Tenants($db);
        $tenantDetails = $tenant->findById($tenantId);

        if ($tenantDetails['account_status'] === 'banned') {
            echo "
            <script>
                Swal.fire({
                    title: 'Your Account is Banned',
                    text: 'You must pay your balance',
                    allowOutsideClick: false,
                    icon: 'warning',
                    confirmButtonColor: '#C1C549',
                    confirmButtonText: 'OK',
                    showClass: {
                    popup: `
      animate__animated
      animate__fadeInUp
      animate__faster
    `,
                },
                hideClass: {
                    popup: `
      animate__animated
      animate__fadeOutDown
      animate__faster
    `,
                },
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'pay-rent';
                    }
                });
            </script>
        ";
            exit;
        }
    }
    ?>
    <?php require 'includes/footer.php'; ?>
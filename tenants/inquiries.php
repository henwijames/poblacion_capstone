<!DOCTYPE html>
<?php
session_start();
include 'session.php';
include '../Controllers/Database.php';
include '../Models/Listing.php';
include '../Models/Landlords.php';

$user_id = $_SESSION['user_id'];
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

// Query to get the listings the tenant inquired about (booked)
$query = "
    SELECT b.id as booking_id, b.booking_status, l.address, l.rent, b.check_in, b.total_amount, l.status, ln.property_name
    FROM bookings b
    LEFT JOIN listings l ON b.listing_id = l.id
    LEFT JOIN landlords ln ON l.user_id = ln.id
    WHERE b.user_id = :user_id
    ORDER BY b.check_in DESC
";
$stmt = $db->prepare($query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$listings = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

        <div class=" p-6">
            <h2 class="text-2xl font-semibold mb-4">Your Inquired Listings</h2>

            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                        <tr class="text-left">
                            <th class="px-6 py-3 border-b">Property Name</th>
                            <th class="px-6 py-3 border-b">Address</th>
                            <th class="px-6 py-3 border-b">Rent</th>
                            <th class="px-6 py-3 border-b">Check-In Date</th>
                            <th class="px-6 py-3 border-b">Total Amount</th>
                            <th class="px-6 py-3 border-b">Status</th>
                            <th class="px-6 py-3 border-b">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($listings)) : ?>
                            <?php foreach ($listings as $listing) : ?>
                                <tr>
                                    <td class="px-6 py-3 border-b"><?php echo htmlspecialchars($listing['property_name']); ?></td>
                                    <td class="px-6 py-3 border-b"><?php echo htmlspecialchars($listing['address']); ?></td>
                                    <td class="px-6 py-3 border-b"><?php echo htmlspecialchars($listing['rent']); ?></td>
                                    <td class="px-6 py-3 border-b"><?php echo htmlspecialchars($listing['check_in']); ?></td>
                                    <td class="px-6 py-3 border-b"><?php echo htmlspecialchars($listing['total_amount']); ?></td>
                                    <td class="px-6 py-3 border-b">
                                        <?php echo ucfirst($listing['booking_status']); ?>
                                    </td>
                                    <td class="px-6 py-3 border-b">
                                        <?php
                                        if ($listing['booking_status'] == 'verified') {
                                            echo '<button id="payButton_' . $listing['booking_id'] . '" onclick="payRent(' . $listing['booking_id'] . ')" class="btn btn-sm bg-primary text-white">Pay Rent</button>';
                                        } else {
                                            echo '<button onclick="cancelBooking(' . $listing['user_id'] . ')" class="btn btn-sm btn-warning text-white">Cancel</button>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="6" class="px-6 py-3 border-b text-center">You have not made any inquiries yet.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <script>
        function payRent(bookingId) {
            // Set up the AJAX request
            $.ajax({
                url: 'Controller/PaymentController.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    booking_id: bookingId
                },
                success: function(response) {
                    // Check if the response contains a redirect URL
                    if (response.redirect_url) {
                        // Redirect the user to the BUX payment page
                        window.location.href = response.redirect_url;
                    } else {
                        // Display an error message if payment initialization failed
                        Swal.fire({
                            icon: 'error',
                            title: 'Payment Error',
                            text: response.error || 'Could not initiate payment. Please try again.'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Error: ' + error);
                    console.log('Status: ' + status);
                    console.log('Response: ' + xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Request Failed',
                        text: 'There was an error processing your request.'
                    });
                }

            });
        }
    </script>

    <?php require 'includes/footer.php'; ?>
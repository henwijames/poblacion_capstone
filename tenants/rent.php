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

// Query to get the listings based on landlord's ID
// Query to get the listings the tenant inquired about (booked), including property_name from the landlords table
$query = "
    SELECT 
        rent.*, 
        landlords.property_name, 
        CONCAT(landlords.first_name, ' ', landlords.middle_name, ' ', landlords.last_name)
        AS landlords_name,
        landlords.qr_payment,
        landlords.mode_of_payment,
        listings.rent,
        listings.address 
    FROM rent
    LEFT JOIN listings ON rent.listing_id = listings.id
    LEFT JOIN landlords ON listings.user_id = landlords.id
    WHERE rent.user_id = :user_id
";
$stmt = $db->prepare($query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$rents = $stmt->fetchAll(PDO::FETCH_ASSOC);


$stmt = $db->prepare($query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$rents = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            <h2 class="text-2xl font-semibold mb-4">My Rent</h2>

            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                        <tr class="text-left">
                            <th class="px-6 py-3 border-b">Property Name</th>
                            <th class="px-6 py-3 border-b">Address</th>
                            <th class="px-6 py-3 border-b">Rent</th>
                            <th class="px-6 py-3 border-b">Check-In Date</th>
                            <th class="px-6 py-3 border-b">Status</th>
                            <th class="px-6 py-3 border-b">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($rents)) : ?>
                            <?php foreach ($rents as $rent) : ?>
                                <tr>
                                    <td class="px-6 py-3 border-b"><?php echo htmlspecialchars($rent['property_name']); ?></td>
                                    <td class="px-6 py-3 border-b"><?php echo htmlspecialchars($rent['address']); ?></td>
                                    <td class="px-6 py-3 border-b font-bold"><?php echo htmlspecialchars($rent['rent']); ?></td>
                                    <td class="px-6 py-3 border-b"><?php echo htmlspecialchars($rent['rent_date']); ?></td>
                                    <td class="px-6 py-3 border-b capitalize">
                                        <?php echo htmlspecialchars($rent['rent_status']); ?>
                                    </td>
                                    <td class="px-6 py-3 border-b">
                                        <a href="rent-listing?id=<?php echo $rent['listing_id'] ?>" class="btn bg-primary text-white">View Rent</a>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="6" class="px-6 py-3 border-b text-center font-bold text-xl">You don't have any rents yet.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <script>
        function payRent(bookingId, totalAmount, referenceNumber) {
            const modal = document.getElementById(`modal_${bookingId}`);
            // Setup AJAX request for payment initiation
            if (!referenceNumber) {
                modal.close();
                Swal.fire({
                    icon: 'warning',
                    title: 'Reference Number Required',
                    text: 'Please enter a reference number to proceed with the payment.'
                }).then(() => {
                    modal.showModal();
                });
                return;
            }

            modal.close();
            $.ajax({
                url: 'Controller/RentController.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    booking_id: bookingId,
                    reference_number: referenceNumber,
                    total_amount: totalAmount
                },
                success: function(response) {
                    if (response.status === 'success') {
                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Transaction Completed',
                            text: response.message
                        }).then(() => {
                            // Redirect to the inquiries page
                            window.location.href = response.redirect_url;
                        });
                    } else {
                        // Show error message if transaction failed
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    console.log('Response:', xhr.responseText);
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
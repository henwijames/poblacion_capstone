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
    SELECT b.id as booking_id, b.booking_status, l.address, l.rent, b.check_in, b.total_amount, l.status, ln.property_name, ln.qr_payment,ln.first_name, ln.mode_of_payment
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
                                    <td class="px-6 py-3 border-b"><?php echo htmlspecialchars_decode($listing['property_name'], ENT_QUOTES); ?></td>
                                    <td class="px-6 py-3 border-b"><?php echo htmlspecialchars($listing['address']); ?></td>
                                    <td class="px-6 py-3 border-b"><?php echo htmlspecialchars($listing['rent']); ?></td>
                                    <td class="px-6 py-3 border-b"><?php echo htmlspecialchars($listing['check_in']); ?></td>
                                    <td class="px-6 py-3 border-b font-bold"><?php echo htmlspecialchars($listing['total_amount']); ?></td>
                                    <td class="px-6 py-3 border-b">
                                        <?php echo ucfirst($listing['booking_status']); ?>
                                    </td>
                                    <td class="px-6 py-3 border-b">
                                        <?php
                                        if ($listing['booking_status'] == 'verified') {
                                            // Button to open the modal for "Pay Rent"
                                            echo '<button class="btn bg-primary text-white" onclick="document.getElementById(\'modal_' . $listing['booking_id'] . '\').showModal()">Pay Rent</button>';

                                            // Modal dialog for "Pay Rent"
                                            echo '<dialog id="modal_' . htmlspecialchars($listing['booking_id']) . '" class="modal">
                                                    <div class="modal-box w-11/12 max-w-5xl flex flex-col items-start">
                                                        <form method="dialog">
                                                            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                                                        </form>
                                                        <h3 class="text-lg font-bold mb-4">' . htmlspecialchars($listing['first_name']) . "'s  " . htmlspecialchars($listing['mode_of_payment']) . " QR Code</h3>";
                                            echo '<p class="mb-4 text-red-500">Note: Please pay the exact amount or else your transaction will be cancelled.</p>';
                                            // Display permit image if available, otherwise show message
                                            if (!empty($listing['qr_payment'])) {
                                                echo "<img src='../landlords/Controllers/uploads/" . htmlspecialchars($listing['qr_payment']) . "' alt='permit' class=' h-96 object-cover rounded-lg shadow-lg'>";
                                            } else {
                                                echo "<h1 class='text-4xl text-center p-6 text-red-500 uppercase font-bold'>No QR Code Uploaded</h1>";
                                            }
                                            echo '<label id="reference" class="mt-4 text-xl">' . $listing['mode_of_payment'] . ' Reference Number</label>';
                                            echo '<input name="reference" id="reference_' . htmlspecialchars($listing['booking_id']) . '" type="text" pattern="^\d{13}$" title="Please enter exactly 13 digits" class="input input-bordered mb-4" maxlength="13">';
                                            // Pay Rent button with onclick event
                                            echo '<button type="button" class="btn bg-primary text-white" onclick="payRent(' . htmlspecialchars($listing['booking_id']) . ', ' . htmlspecialchars($listing['total_amount']) . ', document.getElementById(\'reference_' . $listing['booking_id'] . '\').value)">Pay Rent</button>';

                                            echo '</div>
                                                    </dialog>';
                                        } else {
                                            // Button to cancel booking
                                            echo '<button onclick="cancelBooking(' . htmlspecialchars($listing['booking_id']) . ')" class="btn btn-sm btn-warning text-white">Cancel</button>';
                                        }
                                        ?>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="6" class="px-6 py-3 border-b text-center font-bold text-xl">You have not made any inquiries yet.</td>
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
                url: 'Controller/PaymentController.php',
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

        function cancelBooking(bookingId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to cancel this booking? This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#C1C549',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, cancel it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'Controller/BookingController.php',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            action: 'cancel',
                            booking_id: bookingId
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Booking Deleted',
                                    text: response.message
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Error:', error);
                            console.log('Response Text:', xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Request Failed',
                                text: 'There was an error processing your request.'
                            });
                        }
                    });
                }
            });
        }
    </script>

    <?php require 'includes/footer.php'; ?>
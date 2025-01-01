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

$database = new Database();
$db = $database->getConnection();

// Get tenant_id from GET parameter
$tenant_id = $_SESSION['user_id']; // If id is not set in GET, use null

if (!$tenant_id) {
    echo "Tenant ID is required.";
    exit();
}
$tenants = new Tenants($db);

// Fetch tenant transactions based on tenant_id from GET
$tenantPendingTransactions = $tenants->getPendingTransactions($tenant_id,);
$tenantCompletedTransactions = $tenants->getCompletedTransactions($tenant_id);
$tenantDeclinedTransactions = $tenants->getDeclinedTransactions($tenant_id);


// Query to get the listings the tenant inquired about (booked)
$query = "
    SELECT t.amount, t.screenshot, t.transaction_date, t.transaction_id, t.transaction_status, 
           l.listing_name, l.user_id, lg.first_name AS landlord_first_name, lg.last_name AS landlord_last_name, lg.email AS landlord_email,
           lg.qr_payment, lg.mode_of_payment
    FROM transactions t
    JOIN listings l ON t.listing_id = l.id
    JOIN landlords lg ON l.user_id = lg.id  -- Join the landlords table
    WHERE t.user_id = :tenant_id
    AND t.transaction_status = 'declined'  -- Added condition to filter by 'declined' status
    ORDER BY t.transaction_date DESC
";

$stmt = $db->prepare($query);
$stmt->bindParam(':tenant_id', $tenant_id, PDO::PARAM_INT);
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
        <?php include 'includes/topbar.php'; ?>
        <div class="p-6">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold">My Transactions</h1>
                <a href="tenants" class="btn btn-sm bg-primary text-white">Back</a>
            </div>

            <div role="tablist" class="tabs tabs-lifted mt-4 overflow-x-auto">
                <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="Pending" checked="checked" />
                <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">
                    <div class="mt-4 overflow-x-auto">
                        <table class="w-full border border-gray-200 rounded-md">
                            <thead class="bg-gray-50">
                                <tr class="bg-slate-100">
                                    <th class="py-2 px-4 border-r border-gray-200">House Name</th>
                                    <th class="py-2 px-4 border-r border-gray-200">Amount</th>
                                    <th class="py-2 px-4 border-r border-gray-200">Screenshot Transaction</th>
                                    <th class="py-2 px-4 border-r border-gray-200">Transaction Date</th>
                                    <th class="py-2 px-4 border-r border-gray-200">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($tenantPendingTransactions)): ?>
                                    <tr class="border-b">
                                        <td colspan="5" class="py-2 px-4 text-center">No transactions found</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($tenantPendingTransactions as $transaction): ?>
                                        <tr class="border-b">
                                            <td class="py-2 px-4 border-r border-gray-200"><?php echo htmlspecialchars($transaction['listing_name']); ?></td>
                                            <td class="py-2 px-4 border-r border-gray-200"><?php echo htmlspecialchars($transaction['amount']); ?></td>
                                            <td class="py-2 px-4 border-r border-gray-200"><?php echo htmlspecialchars($transaction['screenshot']); ?></td>
                                            <td class="py-2 px-4 border-r border-gray-200"><?php echo date('F j, Y', strtotime($transaction['transaction_date'])); ?></td>
                                            <td class="py-2 px-4 border-r border-gray-200 capitalize"><?php echo htmlspecialchars($transaction['transaction_status']); ?></td>

                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <input
                    type="radio"
                    name="my_tabs_2"
                    role="tab"
                    class="tab "
                    aria-label="Completed" />
                <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">
                    <div class="mt-4 overflow-x-auto">
                        <table class="w-full border border-gray-200 rounded-md">
                            <thead class="bg-gray-50">
                                <tr class="bg-slate-100">
                                    <th class="py-2 px-4 border-r border-gray-200">House Name</th>
                                    <th class="py-2 px-4 border-r border-gray-200">Amount</th>
                                    <th class="py-2 px-4 border-r border-gray-200">Screenshot Transaction</th>
                                    <th class="py-2 px-4 border-r border-gray-200">Transaction Date</th>
                                    <th class="py-2 px-4 border-r border-gray-200">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($tenantCompletedTransactions)): ?>
                                    <tr class="border-b">
                                        <td colspan="5" class="py-2 px-4 text-center">No transactions found</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($tenantCompletedTransactions as $transaction): ?>
                                        <tr class="border-b">
                                            <td class="py-2 px-4 border-r border-gray-200"><?php echo htmlspecialchars($transaction['listing_name']); ?></td>
                                            <td class="py-2 px-4 border-r border-gray-200"><?php echo htmlspecialchars($transaction['amount']); ?></td>
                                            <td class="py-2 px-4 border-r border-gray-200"><?php echo htmlspecialchars($transaction['screenshot']); ?></td>
                                            <td class="py-2 px-4 border-r border-gray-200"><?php echo date('F j, Y', strtotime($transaction['transaction_date'])); ?></td>
                                            <td class="py-2 px-4 border-r border-gray-200 capitalize">
                                                <!-- Add DaisyUI badge based on status -->
                                                <?php if ($transaction['transaction_status'] === 'completed'): ?>
                                                    <span class="badge badge-success ml-2 text-white">Completed</span>
                                                <?php endif; ?>
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <input type="radio" name="my_tabs_2" role="tab " class="tab" aria-label="Declined" />
                <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">
                    <div class="mt-4 overflow-x-auto">
                        <table class="w-full border border-gray-200 rounded-md">
                            <thead class="bg-gray-50">
                                <tr class="bg-slate-100">
                                    <th class="py-2 px-4 border-r border-gray-200">House Name</th>
                                    <th class="py-2 px-4 border-r border-gray-200">Amount</th>
                                    <th class="py-2 px-4 border-r border-gray-200">Screenshot Transaction</th>
                                    <th class="py-2 px-4 border-r border-gray-200">Transaction Date</th>
                                    <th class="py-2 px-4 border-r border-gray-200">Status</th>
                                    <th class="py-2 px-4 border-r border-gray-200">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($tenantDeclinedTransactions)): ?>
                                    <tr class="border-b">
                                        <td colspan="5" class="py-2 px-4 text-center">No transactions found</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($tenantDeclinedTransactions as $transaction): ?>
                                        <tr class="border-b">
                                            <td class="py-2 px-4 border-r border-gray-200"><?php echo htmlspecialchars($transaction['listing_name']); ?></td>
                                            <td class="py-2 px-4 border-r border-gray-200"><?php echo htmlspecialchars($transaction['amount']); ?></td>
                                            <td class="py-2 px-4 border-r border-gray-200"><?php echo htmlspecialchars($transaction['screenshot']); ?></td>
                                            <td class="py-2 px-4 border-r border-gray-200"><?php echo date('F j, Y', strtotime($transaction['transaction_date'])); ?></td>
                                            <td class="py-2 px-4 border-r border-gray-200 capitalize">
                                                <!-- Add DaisyUI badge based on status -->
                                                <?php if ($transaction['transaction_status'] === 'declined'): ?>
                                                    <span class="badge badge-error ml-2 text-white">Declined</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="px-6 py-3 border-b">
                                                <?php if (!empty($listings)) : ?>
                                                    <?php foreach ($listings as $listing) : ?>
                                                        <?php
                                                        if ($listing['transaction_status'] === 'declined') {
                                                            $bookingId = htmlspecialchars($listing['transaction_id']);
                                                            $firstName = htmlspecialchars($listing['landlord_first_name']);
                                                            $modeOfPayment = htmlspecialchars($listing['mode_of_payment']);
                                                            $qrPayment = htmlspecialchars($listing['qr_payment']);
                                                            $totalAmount = htmlspecialchars($listing['amount']);
                                                        ?>

                                                            <!-- Button to open the modal for "Pay Rent" -->
                                                            <button class="btn bg-primary text-white" onclick="document.getElementById('modal_<?= $bookingId ?>').showModal()">
                                                                Pay Rent
                                                            </button>

                                                            <!-- Modal dialog for "Pay Rent" -->
                                                            <dialog id="modal_<?= $bookingId ?>" class="modal">
                                                                <div class="modal-box w-11/12 max-w-5xl flex flex-col items-start">
                                                                    <form method="dialog">
                                                                        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                                                                    </form>

                                                                    <h3 class="text-lg font-bold mb-4">
                                                                        <?= $firstName ?>'s <?= $modeOfPayment ?> QR Code
                                                                    </h3>

                                                                    <p class="mb-4 text-red-500">
                                                                        Note: Please pay the exact amount or else your transaction will be cancelled.
                                                                    </p>

                                                                    <?php if (!empty($qrPayment)) { ?>
                                                                        <img src="../landlords/Controllers/uploads/<?= $qrPayment ?>" alt="QR Code" class="h-96 object-cover rounded-lg shadow-lg">
                                                                    <?php } else { ?>
                                                                        <h1 class="text-4xl text-center p-6 text-red-500 uppercase font-bold">No QR Code Uploaded</h1>
                                                                    <?php } ?>

                                                                    <div class="mb-4">
                                                                        <img id="screenshot_<?= $bookingId ?>" class="h-[400px] w-[400px] mb-6 object-scale-down" src="../assets/img/upload.svg" alt="Screenshot Transaction" />
                                                                        <input type="file" id="uploadInput_<?= $bookingId ?>" name="screenshot" class="file-input file-input-bordered w-full max-w-xs" onchange="previewQrCode(event, <?= $bookingId ?>)" accept="image/png, image/gif, image/jpeg" />
                                                                    </div>

                                                                    <button
                                                                        type="button"
                                                                        class="btn bg-primary text-white"
                                                                        onclick="payRent(<?= $bookingId ?>, <?= $totalAmount ?>, 'uploadInput_<?= $bookingId ?>')">
                                                                        Pay Rent
                                                                    </button>
                                                                </div>
                                                            </dialog>

                                                        <?php } else { ?>

                                                            <!-- Button to cancel booking -->
                                                            <button
                                                                onclick="cancelBooking(<?= htmlspecialchars($listing['transaction_id']) ?>)"
                                                                class="btn btn-sm btn-warning text-white">
                                                                Cancel
                                                            </button>

                                                        <?php } ?>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </td>


                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </main>
    <script>
        function previewQrCode(event, bookingId) {
            const reader = new FileReader();
            const fileInput = event.target;

            reader.onload = function() {
                // Dynamically get the image element based on the bookingId
                const imageElement = document.getElementById('screenshot_' + bookingId);
                imageElement.src = reader.result; // Set the new image source to the uploaded file
            };

            if (fileInput.files[0]) {
                reader.readAsDataURL(fileInput.files[0]); // Read the selected file and convert it to a data URL
            }
        }


        function payRent(bookingId, totalAmount, uploadInputId) {
            const modal = document.getElementById(`modal_${bookingId}`);
            const uploadInput = document.getElementById(uploadInputId); // Get the actual input element
            const file = uploadInput.files[0]; // Get the selected file

            // Check if a screenshot file is selected
            if (!file) {
                modal.close();
                Swal.fire({
                    icon: 'warning',
                    title: 'Screenshot Transaction Required',
                    text: 'Please upload a Screenshot Transaction to proceed with the payment.'
                }).then(() => {
                    modal.showModal();
                });
                return;
            }

            // If the screenshot is selected, proceed with payment
            const formData = new FormData();
            formData.append('booking_id', bookingId);
            formData.append('screenshot', file); // Add the screenshot file to the form data
            formData.append('total_amount', totalAmount);

            modal.close();
            $.ajax({
                url: 'Controller/PayAgainController.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                processData: false, // Important: to prevent jQuery from processing the data
                contentType: false, // Important: to prevent jQuery from setting the content type
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Transaction Completed',
                            text: response.message
                        }).then(() => {
                            window.location.href = response.redirect_url;
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

    <?php include 'includes/footer.php'; ?>
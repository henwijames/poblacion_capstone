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
                <h1 class="text-2xl font-bold">Tenant Transactions</h1>
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
                                    <th class="py-2 px-4 border-r border-gray-200">Reference Number</th>
                                    <th class="py-2 px-4 border-r border-gray-200">Transaction Date</th>
                                    <th class="py-2 px-4 border-r border-gray-200">Status</th>
                                    <th class="py-2 px-4 border-r border-gray-200">Actions</th>
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
                                            <td class="py-2 px-4 border-r border-gray-200"><?php echo htmlspecialchars($transaction['reference_number']); ?></td>
                                            <td class="py-2 px-4 border-r border-gray-200"><?php echo date('F j, Y', strtotime($transaction['transaction_date'])); ?></td>
                                            <td class="py-2 px-4 border-r border-gray-200 capitalize"><?php echo htmlspecialchars($transaction['transaction_status']); ?></td>
                                            <td class="py-2 px-4 border-r border-gray-200 text-center">
                                                <?php if ($transaction['transaction_status'] === 'pending'): ?>
                                                    <button
                                                        class="btn bg-primary btn-sm text-white"
                                                        onclick="confirmAction('verify', <?php echo $transaction['transaction_id']; ?>)">
                                                        Verify
                                                    </button>
                                                    <button
                                                        class="btn btn-error btn-sm text-white"
                                                        onclick="confirmAction('declined', <?php echo $transaction['transaction_id']; ?>)">
                                                        Decline
                                                    </button>
                                                <?php else: ?>
                                                    <span class="text-gray-500">No actions available</span>
                                                <?php endif; ?>
                                            </td>
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
                                    <th class="py-2 px-4 border-r border-gray-200">Reference Number</th>
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
                                            <td class="py-2 px-4 border-r border-gray-200"><?php echo htmlspecialchars($transaction['reference_number']); ?></td>
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
                                    <th class="py-2 px-4 border-r border-gray-200">Reference Number</th>
                                    <th class="py-2 px-4 border-r border-gray-200">Transaction Date</th>
                                    <th class="py-2 px-4 border-r border-gray-200">Status</th>
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
                                            <td class="py-2 px-4 border-r border-gray-200"><?php echo htmlspecialchars($transaction['reference_number']); ?></td>
                                            <td class="py-2 px-4 border-r border-gray-200"><?php echo date('F j, Y', strtotime($transaction['transaction_date'])); ?></td>
                                            <td class="py-2 px-4 border-r border-gray-200 capitalize">
                                                <!-- Add DaisyUI badge based on status -->
                                                <?php if ($transaction['transaction_status'] === 'declined'): ?>
                                                    <span class="badge badge-error ml-2 text-white">Declined</span>
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
        function confirmAction(action, transactionId) {
            const actionText = action === 'verify' ? 'verify' : 'declined';
            const actionColor = action === 'verify' ? '#4CAF50' : '#F44336'; // Green for Verify, Red for Decline

            Swal.fire({
                title: `Are you sure you want to ${actionText.toLowerCase()} this transaction?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: actionColor,
                cancelButtonColor: '#d33',
                confirmButtonText: `Yes, ${actionText}!`
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create a form dynamically and submit it
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = 'process_transaction.php';

                    const actionInput = document.createElement('input');
                    actionInput.type = 'hidden';
                    actionInput.name = 'action';
                    actionInput.value = action;

                    const idInput = document.createElement('input');
                    idInput.type = 'hidden';
                    idInput.name = 'transaction_id';
                    idInput.value = transactionId;

                    form.appendChild(actionInput);
                    form.appendChild(idInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>

    <?php include 'includes/footer.php'; ?>
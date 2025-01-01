<?php
ob_start();
include 'includes/header.php';
$listing = new Listing($db);
$landlords = new Landlords($db);

$listing_id = $_GET['id'] ?? null;

if (isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'tenant') {
    $tenantId = $_SESSION['user_id'];
    $tenant = new Tenants($db);
    $tenantDetails = $tenant->findById($tenantId);

    // Redirect if tenant is not verified
    if ($tenantDetails['email_verified'] != 1 || $tenantDetails['mobile_verified'] != 1 || $tenantDetails['account_status'] != 'verified') {
        echo "
            <script>
                Swal.fire({
                    title: 'Verification Required',
                    text: 'You must verify your account to proceed.',
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
                        window.location.href = 'apartment.php?id=$listing_id';
                    }
                });
            </script>
        ";
        exit;
    }
}

if ($listing_id) {
    $database = new Database();
    $db = $database->getConnection();
    $listing = new Listing($db);

    // Fetch listing details
    $listingDetails = $listing->getListingById($listing_id);
} else {
    // Handle the case where no listing ID is provided
    echo "Listing not found.";
    exit;
}

$landlord = $landlords->findById($listingDetails['user_id']);
if (!$landlord) {
    echo "Landlord not found.";
    exit;
}

$paymentOptions = json_decode($listingDetails['payment_options'], true);
$oneMonthDeposit = $listingDetails['rent'];
$oneMonthAdvance = $listingDetails['rent'];

// Get the landlord's full name from the database
$fullName = htmlspecialchars($landlord['first_name'] . ' ' . $landlord['last_name']);

ob_end_flush(); // End output buffering and send output
?>

<section class="" id="apartment">
    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20" id="about">
        <!-- Landlord's Apartment/Business Establishment Name -->
        <div class="mb-6">
            <div class="flex items-center gap-4">
                <a href="apartment?id=<?= $listingDetails["id"]; ?>" class="rounded-full w-10 h-10 hover:bg-primary hover:text-white flex items-center justify-center transition-colors ease-in duration-100  hover:shadow-md">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
                <h1 class="text-3xl font-bold">Request to Rent</h1>
            </div>
        </div>
        <!-- Images -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
            <div class="">
                <h1 class="text-xl mb-2">Your Rent</h1>
                <form action="Controller/BookingController.php?id=<?= $listingDetails['id']; ?>" method="POST">
                    <div class="border rounded p-2 mb-6">
                        <label for="check-in" class="font-semibold block mb-1">CHECK-IN</label>
                        <input type="date" id="check-in" name="check_in" class="w-full text-sm" value="2024-11-03">
                    </div>
                    <hr>
                    <div class="mt-6">
                        <button type="submit" name="book_now" class="btn bg-primary w-full text-white hover:text-black">Rent Now</button>
                    </div>
                </form>
            </div>
            <div class="w-full mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-6">
                    <h2 class="text-3xl font-bold mb-4">₱<?= htmlspecialchars($listingDetails['rent']); ?> <span class="text-lg font-normal">/month</span></h2>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span>Monthly Rent</span>
                            <span>₱<?= htmlspecialchars(number_format($listingDetails['rent'])); ?></span>
                        </div>

                        <?php if (is_array($paymentOptions) && in_array("one month advance", $paymentOptions)): ?>
                            <div class="flex justify-between">
                                <span>One month advance</span>
                                <span>₱<?= htmlspecialchars(number_format($listingDetails['rent'])); ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if (is_array($paymentOptions) && in_array("one month deposit", $paymentOptions)): ?>
                            <div class="flex justify-between">
                                <span>One month deposit</span>
                                <span>₱<?= htmlspecialchars(number_format($listingDetails['rent'])); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="border-t mt-4 pt-4">
                        <div class="flex justify-between font-semibold">
                            <span>Total before payment</span>
                            <span>
                                ₱<?= htmlspecialchars(
                                        number_format(
                                            ($listingDetails['rent']) +
                                                (is_array($paymentOptions) && in_array("one month advance", $paymentOptions) ? $listingDetails['rent'] : 0) +
                                                (is_array($paymentOptions) && in_array("one month deposit", $paymentOptions) ? $listingDetails['rent'] : 0)
                                        )
                                    ); ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
</section>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const dateInput = document.getElementById("check-in");
        const today = new Date().toISOString().split("T")[0]; // Get today's date in YYYY-MM-DD format
        dateInput.setAttribute("min", today); // Set the min attribute
    });
</script>
<?php include 'includes/footer.php'; ?>
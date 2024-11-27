<?php
include 'includes/header.php';
$database = new Database();
$db = $database->getConnection();
$listing = new Listing($db);
$landlords = new Landlords($db);

$landlordListings = $listing->getAllApartmentListings();

$user_id = $_SESSION['user_id'];
$userListings = $listing->getListingsByUser($user_id);

if (isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'tenant') {
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

<section class="h-[500px] tenants-home" style="background-image: url('../assets/img/bg.png');  background-size: cover; background-position: center;">
    <div class="container mx-auto flex flex-col justify-center items-center text-center h-full px-4 text-[20px]">
        <h1 class="text-4xl font-bold">Discover a New Era of Convenience and Connection</h1>
        <p class="mt-4 mb-4 text-base md:text-lg">Experience effortless living in Poblacion, Taal with Poblacion<span class="text-primary">Ease</span>.</p>

        <div class="flex flex-col md:flex-row items-center gap-4 mt-4 w-full max-w-xl">
            <form action="filter" method="GET" class="w-full flex flex-col md:flex-row items-center gap-4">
                <div class="w-full">

                    <select name="price_range" class="select select-success w-full">
                        <option disabled selected>Choose Price Range</option>
                        <option value="0-5000">₱0 - ₱5,000</option>
                        <option value="5001-10000">₱5,001 - ₱10,000</option>
                        <option value="10001-15000">₱10,001 - ₱15,000</option>
                        <option value="15001-20000">₱15,001 - ₱20,000</option>
                        <option value="20001-25000">₱20,001 - ₱25,000</option>
                        <option value="25001-30000">₱25,001 - ₱30,000</option>
                        <option value="30001+">₱30,001+</option>
                    </select>
                </div>
                <button type="submit" class=" btn bg-primary text-white border-none w-full sm:w-20 ">
                    Search
                </button>
            </form>
        </div>

    </div>


</section>
<div class="flex flex-col">
    <main class="flex-1 mx-auto py-8 px-6 md:px-8 lg:px-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <?php if (!empty($landlordListings)): ?>
            <?php foreach ($landlordListings as $landlordListing): ?>
                <div class="rounded-lg border bg-card text-card-foreground shadow-sm overflow-hidden bg-white">
                    <?php
                    $images = $listing->getImagesByListing($landlordListing['id']);
                    // Check if $images is an array and contains data
                    if (is_array($images) && !empty($images)) {
                        $imageSrc = $images[0]; // Access the first image in the array
                    } else {
                        $imageSrc = 'assets/img/image_placeholder.png'; // Fallback if no image is available
                    }

                    $landlordDetails = $landlords->findById($landlordListing['user_id']);
                    $property_name = $landlordDetails['property_name'] ?? 'Property Name Not Available';
                    $fullName = $landlordDetails['first_name'] . ' ' . $landlordDetails['last_name'];
                    ?>
                    <img
                        src="../landlords/Controllers/<?php echo htmlspecialchars($imageSrc); ?>"
                        alt="Featured Listing 1"
                        width="400"
                        height="300"
                        class="rounded-t-md object-cover w-full h-60"
                        style="aspect-ratio: 400 / 300; object-fit: cover;" />
                    <div class="p-4">
                        <h3 class="text-lg font-semibold"><?php echo htmlspecialchars_decode($property_name, ENT_QUOTES); ?></h3>
                        <h3 class="text-base text-muted-foreground"><?php echo htmlspecialchars($landlordListing['address']); ?></h3>
                        <p class="mt-2 text-muted-foreground">Hosted by <?php echo htmlspecialchars($fullName); ?></p>
                        <p class="text-muted-foreground mb-2"><?= htmlspecialchars($landlordListing['sqft']); ?> sqft | <?= htmlspecialchars($landlordListing['bedrooms']); ?> Bed | <?= htmlspecialchars($landlordListing['bathrooms']); ?> Bathrooms</p>
                        <p class="text-primary font-bold text-lg">₱<?= htmlspecialchars($landlordListing['rent']) ?>/month</p>
                        <div class="mt-4">
                            <a class=" btn bg-primary text-white" href="apartment?id=<?= $landlordListing['id'] ?>" rel="ugc">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </main>
</div>

<?php if (empty($landlordListings)): ?>
    <div class="flex flex-col justify-center items-center w-full h-full">
        <img src="../assets/img/nolistings.svg" alt="no listings" class="mx-auto w-80 sm:w-[600px]">
        <h1 class="text-2xl text-center font-bold mt-6">No listings available</h1>
    </div>
<?php endif; ?>



<?php include 'includes/footer.php'; ?>
<?php
include 'includes/header.php';
$database = new Database();
$db = $database->getConnection();
$listing = new Listing($db);
$landlords = new Landlords($db);

$landlordListings = $listing->getAllEstablishmentListings();

$user_id = $_SESSION['user_id'];
$userListings = $listing->getListingsByUser($user_id);
?>

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
                        <h3 class="text-lg font-semibold"><?php echo htmlspecialchars($property_name); ?></h3>
                        <h3 class="text-base text-muted-foreground"><?php echo htmlspecialchars($landlordListing['address']); ?></h3>
                        <p class="mt-2 text-muted-foreground">Hosted by <?php echo htmlspecialchars($fullName); ?></p>
                        <p class="text-muted-foreground mb-2"><?= htmlspecialchars($landlordListing['sqft']); ?> sqft | <?= htmlspecialchars($landlordListing['bedrooms']); ?> Bed | <?= htmlspecialchars($landlordListing['bathrooms']); ?> Bathrooms</p>
                        <p class="text-primary font-bold text-lg">₱<?= htmlspecialchars($landlordListing['rent']) ?>/month</p>
                        <div class="mt-4">
                            <a class=" btn bg-primary text-white" href="apartment.php?id=<?= $landlordListing['id'] ?>" rel="ugc">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No listings available.</p>
        <?php endif; ?>
    </main>
</div>



<?php include 'includes/footer.php'; ?>
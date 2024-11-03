<?php
include 'includes/header.php';
$database = new Database();
$db = $database->getConnection();
$landlords = new Landlords($db);
$listing = new Listing($db);

$landlordListings = $listing->getAllApartmentListings();


$landlordId  = $_GET['id'] ?? null;

$listingByUser = $listing->getListingsByUser(user_id: $landlordId);

if ($landlordId) {
    // Fetch landlord details using the ID
    $landlordDetails = $landlords->findById($landlordId);
} else {
    // Handle the case where ID is not provided
    die('Landlord ID not specified.');
}


$landlordFullName = $landlordDetails['first_name'] . ' ' . $landlordDetails['last_name'];

?>


<main class="px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20" id="about">
    <!-- Landlord's Apartment/Business Establishment Name -->
    <div class="mb-6">
        <div class="flex items-center gap-4">
            <a href="contact-landlord.php?id=<?php echo $landlordDetails['id']; ?>" class="rounded-full w-10 h-10 hover:bg-primary hover:text-white flex items-center justify-center transition-colors ease-in duration-100  hover:shadow-md">
                <i class="fa-solid fa-chevron-left"></i>
            </a>
            <h1 class="text-lg sm:text-3xl font-bold"><?= $landlordFullName . "'s Properties"; ?></h1>
        </div>
        <div class="flex-1 mx-auto py-8 px-6 md:px-8 lg:px-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php if (!empty($listingByUser)): ?>
                <?php foreach ($listingByUser as $listings): ?>
                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm overflow-hidden bg-white">
                        <?php
                        $images = $listing->getImagesByListing($listings['id']);
                        // Check if $images is an array and contains data
                        if (is_array($images) && !empty($images)) {
                            $imageSrc = $images[0]; // Access the first image in the array
                        } else {
                            $imageSrc = 'assets/img/image_placeholder.png'; // Fallback if no image is available
                        }

                        $landlordDetails = $landlords->findById($listings['user_id']);
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
                            <h3 class="text-base text-muted-foreground"><?php echo htmlspecialchars($listings['address']); ?></h3>
                            <p class="mt-2 text-muted-foreground">Hosted by <?php echo htmlspecialchars($fullName); ?></p>
                            <p class="text-muted-foreground mb-2"><?= htmlspecialchars($listings['sqft']); ?> sqft | <?= htmlspecialchars($listings['bedrooms']); ?> Bed | <?= htmlspecialchars($listings['bathrooms']); ?> Bathrooms</p>
                            <p class="text-primary font-bold text-lg">₱<?= htmlspecialchars($listings['rent']) ?>/month</p>
                            <div class="mt-4">
                                <a class=" btn bg-primary text-white" href="apartment.php?id=<?= $listings['id'] ?>" rel="ugc">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No listings available.</p>
            <?php endif; ?>
        </div>
</main>



<?php include 'includes/footer.php'; ?>
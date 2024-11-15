<?php
include 'includes/header.php';
$listing = new Listing($db);
$landlords = new Landlords($db);
$listing_id = $_GET['id'] ?? null;

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
$images = $listing->getImagesByListing($listing_id);
$paymentOptions = json_decode($listingDetails['payment_options'], true);
$listingDetails['images'] = $images;

// Get the landlord's full name from the database
$fullName = htmlspecialchars($landlord['first_name'] . ' ' . $landlord['last_name']);
?>

<section class="" id="apartment">
    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20" id="about">
        <!-- Landlord's Apartment/Business Establishment Name -->
        <div class="mb-6">
            <div class="flex items-center gap-4">
                <a href="rent" class="rounded-full w-10 h-10 hover:bg-primary hover:text-white flex items-center justify-center transition-colors ease-in duration-100  hover:shadow-md">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
                <h1 class="text-3xl font-bold"><?= htmlspecialchars($landlord['property_name']); ?></h1>
            </div>
        </div>
        <!-- Images -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
            <div class="swiper h-[300px] md:h-[400px] w-full">
                <div class="swiper-wrapper">
                    <?php if (isset($listingDetails['images']) && is_array($listingDetails['images'])): ?>
                        <?php foreach ($listingDetails['images'] as $image): ?>
                            <div class="swiper-slide">
                                <img
                                    src="<?= htmlspecialchars("../landlords/Controllers/" . $image); ?>"
                                    alt="Apartment Image"
                                    class="rounded-lg object-cover shadow-lg w-full h-full" />
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No images available.</p>
                    <?php endif; ?>
                </div>
                <div class="swiper-button-prev" style="color: #C1C549"></div>
                <div class="swiper-button-next" style="color: #C1C549"></div>
                <div class="swiper-scrollbar"></div>
            </div>
            <div class="grid grid-cols-2 gap-4 w-full">
                <?php if (isset($listingDetails['images']) && is_array($listingDetails['images'])): ?>
                    <?php $maxImages = 4; ?>
                    <?php $count = 0; ?>
                    <?php foreach ($listingDetails['images'] as $image): ?>
                        <?php if ($count >= $maxImages) break; ?>
                        <img
                            src="<?= htmlspecialchars("../landlords/Controllers/" . $image); ?>"
                            alt="Apartment Image"
                            width="300"
                            height="200"
                            class="rounded-lg object-cover shadow-lg"
                            style="aspect-ratio: 300 / 210; object-fit: cover; height: 100%;" />
                        <?php $count++; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No images available.</p>
                <?php endif; ?>
            </div>
        </div>
        <hr>
        <div class="grid grid-cols-2 lg:grid-cols-4 sm gap-4 mt-6">
            <div class="mb-6">
                <h2 class="text-xl font-bold mb-2">Landlord</h2>
                <p class="text-muted-foreground"><?= htmlspecialchars($fullName); ?></p>
                <p class="text-muted-foreground"><?= htmlspecialchars($listingDetails['address']); ?></p>
                <p class="text-muted-foreground">Phone Number: <span class=" font-bold"><?= htmlspecialchars($landlord['phone_number']); ?></span></p>
            </div>
            <div class="mb-6">
                <h2 class="text-xl font-bold mb-2">Rooms</h2>
                <div>
                    <p class="text-muted-foreground mb-2"><?= htmlspecialchars($listingDetails['sqft']); ?> sqft | <?= htmlspecialchars($listingDetails['bedrooms']); ?> Bed | <?= htmlspecialchars($listingDetails['bathrooms']); ?> Bathrooms</p>
                </div>
            </div>
            <div class="mb-6">
                <h2 class="text-xl font-bold mb-2">Payment Rules</h2>
                <ul class="grid grid-cols-1 gap-4 capitalize">
                    <?php
                    // Decode the amenities and handle null cases
                    $payment_options = json_decode($listingDetails['payment_options'], true);
                    if (is_array($payment_options) && !empty($payment_options)): ?>
                        <?php foreach ($payment_options as $payment_option): ?>
                            <li class="flex items-center gap-2">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="w-5 h-5 text-primary">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="m9 12 2 2 4-4"></path>
                                </svg>
                                <span><?= htmlspecialchars($payment_option); ?></span>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>No amenities available.</li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="mb-6">
                <h2 class="text-xl font-bold mb-2">Amenities</h2>
                <ul class="grid grid-cols-1 gap-4 capitalize">
                    <?php
                    // Decode the amenities and handle null cases
                    $amenities = json_decode($listingDetails['amenities'], true);
                    if (is_array($amenities) && !empty($amenities)): ?>
                        <?php foreach ($amenities as $amenity): ?>
                            <li class="flex items-center gap-2">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="w-5 h-5 text-primary">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="m9 12 2 2 4-4"></path>
                                </svg>
                                <span><?= htmlspecialchars($amenity); ?></span>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>No amenities available.</li>
                    <?php endif; ?>
                </ul>
            </div>

        </div>
        <div class="w-full">
            <div class="mt-4">
                <p class="text-muted-foreground text-justify text-[18px]"><?= htmlspecialchars($listingDetails['description']); ?></p>
            </div>



        </div>
    </main>
</section>

<script>
    const swiper = new Swiper('.swiper', {
        // Optional parameters
        direction: 'horizontal',
        loop: true,

        // If we need pagination
        pagination: {
            el: '.swiper-pagination',
        },

        // Navigation arrows
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },

        // And if we need scrollbar
        scrollbar: {
            el: '.swiper-scrollbar',
        },
    });
</script>

<?php include 'includes/footer.php'; ?>
<?php
include 'includes/header.php';
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

$user_id = $_SESSION['user_id'];
$userListings = $listing->getListingsByUser($user_id);
$images = $listing->getImagesByListing($listing_id);

$listingDetails['images'] = $images;

?>

<main class="main-content main">
    <?php include 'includes/topbar.php'; ?>
    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20" id="about">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div>
                <div class="mb-6">
                    <h1 class="text-3xl font-bold mb-2"><?= htmlspecialchars($landlord["property_name"]); ?></h1>
                    <p class="text-muted-foreground"><?= htmlspecialchars($listingDetails['address']); ?></p>
                </div>
                <div class="mb-6">
                    <h2 class="text-xl font-bold mb-2">Landlord</h2>
                    <p class="text-muted-foreground"><?= htmlspecialchars($fullName) ?></p>
                    <p class="text-muted-foreground">Phone : <?= htmlspecialchars($landlord['phone_number']) ?></p>
                </div>
                <div class="mb-6">
                    <h2 class="text-xl font-bold mb-2">Amenities</h2>
                    <ul class="grid grid-cols-2 gap-4  capitalize">
                        <?php
                        $amenities = json_decode($listingDetails['amenities'], true);
                        foreach ($amenities as $amenity): ?>
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
                                <span><?= htmlspecialchars($amenity) ?></span>
                            </li>
                        <?php endforeach; ?>

                    </ul>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <?php if (isset($listingDetails['images']) && is_array($listingDetails['images'])): ?>
                    <?php $maxImages = 4; // Adjust this as needed 
                    ?>
                    <?php $count = 0; ?>
                    <?php foreach ($listingDetails['images'] as $image): ?>
                        <?php if ($count >= $maxImages) break; ?>
                        <img
                            src="<?= htmlspecialchars("Controllers/" . $image); ?>"
                            alt="Apartment Image"
                            width="300"
                            height="200"
                            class="rounded-lg object-cover shadow-lg"
                            style="aspect-ratio: 300 / 200; object-fit: cover;" />
                        <?php $count++; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No images available.</p>
                <?php endif; ?>

            </div>


        </div>
        <div class="swiper mt-4 h-[400px] md:h-[800px] w-full">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <?php if (isset($listingDetails['images']) && is_array($listingDetails['images'])): ?>

                    <?php foreach ($listingDetails['images'] as $image): ?>

                        <div class="swiper-slide">
                            <img
                                src="<?= htmlspecialchars("Controllers/" . $image); ?>"
                                alt="Apartment Image"
                                class="rounded-lg object-cover shadow-lg w-full h-full" />
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No images available.</p>
                <?php endif; ?>
            </div>
            <!-- If we need pagination -->

            <!-- If we need navigation buttons -->
            <div class="swiper-button-prev" style="color: #C1C549"></div>
            <div class="swiper-button-next" style="color: #C1C549"></div>

            <!-- If we need scrollbar -->
            <div class="swiper-scrollbar"></div>
        </div>
    </main>
    <!-- Slider main container -->

</main>
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
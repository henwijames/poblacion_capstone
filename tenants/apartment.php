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

$user_id = $_SESSION['user_id'];
$userListings = $listing->getListingsByUser($user_id);
$landlord = $landlords->findById($_SESSION['user_id']);
if (!$landlord) {
    echo "Landlord not found.";
    exit;
}
$images = $listing->getImagesByListing($listing_id);

$listingDetails['images'] = $images;
?>

<section class="bg-background" id="apartment">
    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20" id="about">


        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div>
                <div class="mb-6">
                    <div class="flex items-center gap-4 mb-2">
                        <a href="index" class="rounded-full w-10 h-10 hover:bg-primary hover:text-white flex items-center justify-center transition-colors ease-in duration-100  hover:shadow-md"><i class="fa-solid fa-chevron-left" </i></a></i>
                        <h1 class="text-3xl font-bold"><?= htmlspecialchars($landlord['property_name']); ?></h1>
                    </div>
                </div>
                <div class="mb-6">
                    <h2 class="text-xl font-bold mb-2">Landlord</h2>
                    <p class="text-muted-foreground"><?= htmlspecialchars($fullName) ?></p>
                    <p class="text-muted-foreground"><?= htmlspecialchars($listingDetails['address']); ?></p>
                    <p class="text-muted-foreground">Phone : <?= htmlspecialchars($landlord['phone_number']) ?></p>
                </div>
                <div class="mb-6">
                    <h2 class="text-xl font-bold mb-2">Rooms</h2>
                    <div>
                        <p class="text-muted-foreground mb-2"><?= htmlspecialchars($listingDetails['sqft']); ?> sqft | <?= htmlspecialchars($listingDetails['bedrooms']); ?> Bed | <?= htmlspecialchars($listingDetails['bathrooms']); ?> Bathrooms</p>
                    </div>

                </div>
                <div class="mb-6">
                    <h2 class="text-xl font-bold mb-2">Amenities</h2>
                    <ul class="grid grid-cols-2 gap-4 capitalize">
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
                                    <span><?= htmlspecialchars($amenity) ?></span>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li>No amenities available.</li>
                        <?php endif; ?>
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
                            src="<?= htmlspecialchars("../landlords/Controllers/" . $image); ?>"
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
        <div class="grid gird-cols-1 lg:grid-cols-2 gap-8">

            <div class="mt-4">
                <p class="text-muted-foreground"><?= htmlspecialchars($listingDetails['description']); ?></p>
            </div>
            <div class="swiper mt-2 h-[300px] md:h-[400px] w-full">
                <!-- Additional required wrapper -->
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
                <!-- If we need pagination -->

                <!-- If we need navigation buttons -->
                <div class="swiper-button-prev" style="color: #C1C549"></div>
                <div class="swiper-button-next" style="color: #C1C549"></div>

                <!-- If we need scrollbar -->
                <div class="swiper-scrollbar"></div>
            </div>

        </div>
        <div class="max-w-6xl mx-auto flex flex-col justify-center py-12 sm:py-16 lg:py-20">
            <hr>
            <div class="my-10">
                <div class=" flex items-center mb-6">
                    <svg class="w-6 h-6 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    <span class="text-3xl font-bold">4.71</span>
                    <span class="text-gray-600 ml-2">· 181 reviews</span>
                </div>

                <div class="w-full grid grid-cols-2 md:grid-cols-6 gap-4 mb-8">
                    <div class="flex flex-col">
                        <span class="text-gray-700">Cleanliness</span>
                        <div class="flex items-center">
                            <span class="text-xl font-semibold mr-2">4.7</span>
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-gray-700">Accuracy</span>
                        <div class="flex items-center">
                            <span class="text-xl font-semibold mr-2">4.8</span>
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-gray-700">Check-in</span>
                        <div class="flex items-center">
                            <span class="text-xl font-semibold mr-2">4.8</span>
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-gray-700">Communication</span>
                        <div class="flex items-center">
                            <span class="text-xl font-semibold mr-2">4.8</span>
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-gray-700">Location</span>
                        <div class="flex items-center">
                            <span class="text-xl font-semibold mr-2">4.9</span>
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-gray-700">Value</span>
                        <div class="flex items-center">
                            <span class="text-xl font-semibold mr-2">4.8</span>
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="space-y-8 mt-10">
                <div class="flex">
                    <img src="../assets/img/image_placeholder.png" alt="Marco" class="w-12 h-12 rounded-full mr-4">
                    <div>
                        <h3 class="font-semibold">Lovelita De Ramos</h3>
                        <p class="text-gray-600 text-sm">5 years on Airbnb</p>
                        <div class="flex items-center mt-1">
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <span class="text-gray-600 text-sm ml-2">March 2020</span>
                        </div>
                        <p class="mt-2">So love this place. When we arrived, we saw free cookies for us in the table. Also some coffee vouchers. For the coffee vouchers we just left it in the table since we were not able to...</p>
                        <button class="text-blue-600 hover:underline mt-1">Show more</button>
                    </div>
                </div>

                <div class="flex">
                    <img src="../assets/img/image_placeholder.png" alt="Marco" class="w-12 h-12 rounded-full mr-4">
                    <div>
                        <h3 class="font-semibold">Kharen Brosoto</h3>
                        <p class="text-gray-600 text-sm">5 years on Airbnb</p>
                        <div class="flex items-center mt-1">
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <span class="text-gray-600 text-sm ml-2">March 2020</span>
                        </div>
                        <p class="mt-2">You will not be dissapointed. Good location, great service, great place. Will book here again if I come back.</p>
                    </div>
                </div>
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
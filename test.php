<!DOCTYPE html>
<?php
// session_start();
// include 'session.php';
?>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PoblacionEase</title>

    <link rel="stylesheet" href="assets/css/style.css">

    <!-- FontAwesome CDN -->
    <script src="https://kit.fontawesome.com/f284e8c7c2.js" crossorigin="anonymous"></script>
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- JQuery File -->
    <script src="../assets/js/jquery-3.7.1.min.js"></script>
</head>

<body>

    <div class="fixed left-0 top-0 w-64 h-full bg-background p-4 z-50 sidebar-menu transition-transform shadow-md">
        <a href="#" class="flex justify-center items-center pb-4 border-b border-b-black">
            <img src="../assets/img/poblacionease.png" alt="" class="w-36 object-cover">
        </a>
        <ul class="mt-4">
            <li class="mb-1 group  <?php echo ($page == 'index') ? 'active' : ''; ?>">
                <a href="index" class=" flex items-center py-2 px-3 rounded-md hover:text-white hover:bg-primary group-[.active]:bg-primary group-[.active]:text-white group-[.selected]:bg-primary group-[.selected]:text-white ">
                    <i class="fa-solid fa-house mr-3 text-lg"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="mb-1 group <?php echo ($page == 'listings') ? 'active' : ''; ?>">
                <a href="#" class="flex items-center py-2 px-3 rounded-md hover:text-white hover:bg-primary group-[.active]:bg-primary group-[.active]:text-white sidebar-dropdown-toggle group-[.selected]:bg-primary group-[.selected]:text-white">
                    <i class="fa-solid fa-sign-hanging mr-3 text-lg"></i>
                    <span>Listings</span>
                    <i class="fa-solid fa-chevron-right ml-auto group-[.selected]:rotate-90"></i>
                </a>
                <ul class="pl-7 mt-2 hidden group-[.selected]:block ">
                    <li class="mb-4">
                        <a href="add-listings" class="text-sm flex items-center dot hover:text-primary">Add Listings</a>
                    </li>
                    <li class="mb-4">
                        <a href="listings" class="text-sm flex items-center dot hover:text-primary">Active Listings</a>
                    </li>
                </ul>
            </li>
            <li class="mb-1 group <?php echo ($page == 'tenants' || $page == 'rents') ? 'active' : ''; ?>">
                <a href="#" class="flex items-center py-2 px-3 rounded-md hover:text-white hover:bg-primary group-[.active]:bg-primary group-[.active]:text-white sidebar-dropdown-toggle group-[.selected]:bg-primary group-[.selected]:text-white">
                    <i class="fa-solid fa-key mr-3 text-lg"></i>
                    <span>Rent</span>
                    <i class="fa-solid fa-chevron-right ml-auto group-[.selected]:rotate-90"></i>
                </a>
                <ul class="pl-7 mt-2 hidden group-[.selected]:block">
                    <li class="mb-4">
                        <a href="rents" class="text-sm flex items-center dot hover:text-primary">Rents</a>
                    </li>
                    <li class="mb-4">
                        <a href="tenants" class="text-sm flex items-center dot hover:text-primary">Tenants</a>
                    </li>
                </ul>
            </li>
            <li class="mb-1 group">
                <a href="#" class="flex items-center py-2 px-3 rounded-md hover:text-white hover:bg-primary group-[.active]:bg-primary group-[.active]:text-white group-[.selected]:bg-primary group-[.selected]:text-white sidebar-dropdown-toggle">
                    <i class="fa-solid fa-money-bill mr-3 text-lg"></i>
                    <span>Payment</span>
                    <i class="fa-solid fa-chevron-right ml-auto group-[.selected]:rotate-90"></i>

                </a>
                <ul class="pl-7 mt-2 hidden group-[.selected]:block">
                    <li class="mb-4">
                        <a href="#" class="text-sm flex items-center dot hover:text-primary">Transactions</a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="text-sm flex items-center dot hover:text-primary">Tenants Balance</a>
                    </li>
                </ul>
            </li>
            <li class="mb-1 group">
                <a href="#" class="flex items-center py-2 px-3 rounded-md hover:text-white hover:bg-primary group-[.active]:bg-primary group-[.active]:text-white group-[.selected]:bg-primary group-[.selected]:text-white">
                    <i class="fa-solid fa-gears mr-3 text-lg"></i>
                    <span>Settings</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="fixed top-0 left-0 w-full h-full bg-black/50 md:hidden z-40 sidebar-overlay"></div>
    <main class="main main-content">
        <div class="py-2 px-4 flex items-center shadow-md shadow-black/5 sticky top-0 left-0  z-40 bg-white">
            <button type="button" class="text-lg sidebar-toggle">
                <i class="fa-solid fa-bars z-50"></i>
            </button>
            <ul class="ml-auto flex items-center ">
                <li class="mr-1 dropdown relative flex items-center gap-4">

                    <span class="hidden md:flex text-gray-400"><?php echo htmlspecialchars($userName); ?></span>
                    <button type="button" class="dropdown-toggle text-gray-400 w-8 h-8 rounded flex items-center justify-center hover:bg-gray-50 hover:text-gray-600">

                        <i class="fa-solid fa-user mr-2"></i>
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>
                    <ul class="dropdown-menu hidden shadow-md py-1.5 rounded-md bg-white border-gray-100 w-[140px] font-medium absolute top-full right-4 mt-2 z-10">
                        <li>
                            <a href="profile" class="flex items-center text-[13px] py-1.5 px-4 hover:bg-gray-100">Profile</a>
                        </li>
                        <li>
                            <a href="settings" class="flex items-center text-[13px] py-1.5 px-4 hover:bg-gray-100">Settings</a>
                        </li>
                        <li>
                            <a href="logout" id="logout-btn" class="flex items-center text-[13px] py-1.5 px-4 hover:bg-gray-100">Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </main>
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

        </div>

    </main>
    <?php include 'includes/header.php'; ?>
    <?php
    $listing_id = $_GET['id'] ?? null;

    if ($listing_id) {
        $database = new Database();
        $db = $database->getConnection();
        $listing = new Listing($db);

        // Fetch listing details
        $listingDetails = $listing->getListingById($listing_id);
        $images = $listing->getImagesByListing($listing_id);
    } else {
        echo "Listing not found.";
        exit;
    }
    $user_id = $_SESSION['user_id'];
    $userListings = $listing->getListingsByUser($user_id);
    $images = $listing->getImagesByListing($listing_id);

    $listingDetails['images'] = $images;

    $errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
    $formData = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];
    unset($_SESSION['errors']);
    unset($_SESSION['form_data']);
    ?>

    <main class="main-content main">
        <?php include 'includes/topbar.php'; ?>
        <div class="container mx-auto px-4 sm:px-6 md:px-8 py-12">
            <h1 class="text-3xl font-bold mb-8">Edit Listing</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <form class="space-y-6" action="Controllers/ListingController.php?id=<?= htmlspecialchars($listing_id); ?>" method="POST" enctype="multipart/form-data">
                        <?php if (!empty($errors)): ?>
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                <strong class="font-bold">Error!</strong>
                                <ul class="list-disc pl-5 mt-2">
                                    <?php foreach ($errors as $field => $error): ?>
                                        <li><?php echo htmlspecialchars($error); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <div>
                            <h3 class="text-lg font-medium text-gray-700">Property Type*</h3>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="property_type" value="apartment" class="rounded border-gray-300 text-primary focus:ring-primary" <?php if ($listingDetails['property_type'] == 'apartment') echo 'checked'; ?> onchange="toggleRooms()">
                                    <span class="ml-2 text-sm text-gray-700">Apartment</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="property_type" value="business establishment" class="rounded border-gray-300 text-primary focus:ring-primary" <?php if ($listingDetails['property_type'] == 'business') echo 'checked'; ?> onchange="toggleRooms()">
                                    <span class="ml-2 text-sm text-gray-700">Business Establishment</span>
                                </label>
                            </div>
                            <?php if (isset($errors['property_type'])): ?>
                                <p class="text-red-500 text-sm"><?php echo htmlspecialchars($errors['property_type']); ?></p>
                            <?php endif; ?>
                        </div>
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">Address*</label>
                            <input type="text" id="address" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm" name="address" value="<?= htmlspecialchars($listingDetails['address']); ?>" />
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div id="bedroom-container">
                                <label for="bedrooms" class="block text-sm font-medium text-gray-700">Bedrooms*</label>
                                <input id="bedrooms" type="number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm" placeholder="2" name="bedrooms" value="<?= htmlspecialchars($listingDetails['bedrooms']); ?>" />
                            </div>
                            <div>
                                <label for="bathrooms" class="block text-sm font-medium text-gray-700">Bathrooms*</label>
                                <input id="bathrooms" type="number" name="bathrooms" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm" placeholder="1" value="<?= htmlspecialchars($listingDetails['bathrooms']); ?>" />
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-700">Amenities</h3>
                            <div class="grid grid-cols-2 gap-4 mt-2">
                                <?php
                                // Decode the amenities from JSON if it's in string format
                                $amenitiesArray = json_decode($listingDetails['amenities'], true) ?? [];
                                ?>

                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="amenities[]" value="gym" class="rounded border-gray-300 text-primary focus:ring-primary" <?php echo in_array("gym", $amenitiesArray) ? 'checked' : ''; ?>>
                                        <span class="ml-2 text-sm text-gray-700">Gym</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="amenities[]" value="balcony" class="rounded border-gray-300 text-primary focus:ring-primary" <?php echo in_array("balcony", $amenitiesArray) ? 'checked' : ''; ?>>
                                        <span class="ml-2 text-sm text-gray-700">Balcony</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="amenities[]" value="swimming pool" class="rounded border-gray-300 text-primary focus:ring-primary" <?php echo in_array("swimming pool", $amenitiesArray) ? 'checked' : ''; ?>>
                                        <span class="ml-2 text-sm text-gray-700">Swimming Pool</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="amenities[]" value="airconditioned" class="rounded border-gray-300 text-primary focus:ring-primary" <?php echo in_array("airconditioned", $amenitiesArray) ? 'checked' : ''; ?>>
                                        <span class="ml-2 text-sm text-gray-700">Air-Conditioned</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="amenities[]" value="parking" class="rounded border-gray-300 text-primary focus:ring-primary" <?php echo in_array("parking", $amenitiesArray) ? 'checked' : ''; ?>>
                                        <span class="ml-2 text-sm text-gray-700">Parking</span>
                                    </label>
                                </div>
                                <!-- Add more checkboxes for additional amenities as needed -->
                            </div>
                        </div>
                        <div>
                            <label for="sqft" class="block text-sm font-medium text-gray-700">Square Meters*</label>
                            <input id="sqft" type="number" name="sqft" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm" placeholder="1200" value="<?= htmlspecialchars($listingDetails['sqft']); ?>" />
                        </div>
                        <div>
                            <label for="rent" class="block text-sm font-medium text-gray-700">Rent Price*</label>
                            <input id="rent" type="number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm" placeholder="1500" name="rent" value="<?= htmlspecialchars($listingDetails['rent']); ?>" />
                        </div>
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description*</label>
                            <textarea id="description" name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm" placeholder="Describe the property details..."><?= htmlspecialchars($listingDetails['description']); ?></textarea>
                        </div>
                        <div>

                            <h1 class="mb-2">Current Property Images</h1>
                            <div class="grid grid-cols-3 gap-4 mb-3">

                                <?php if (isset($listingDetails['images']) && is_array($listingDetails['images'])): ?>
                                    <?php $maxImages = 5; // Adjust this as needed 
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
                            <h1 class="block font-medium mb-2 text-gray-700">Upload Images of the Property</h1>
                            <div class="mb-2">
                                <label class="block">
                                    <span class="sr-only">Choose a property image</span>
                                    <input type="file" accept="image/*" id="file-upload-1" name="file-upload[]" class="block w-full text-sm text-slate-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-primary 
                                hover:file:bg-slate-100 transition-colors ease-in-out duration-150  cursor-pointer
                                " onchange="previewImage(event, 1)" />
                                </label>
                            </div>
                            <div class="mb-2">
                                <label class="block">
                                    <span class="sr-only">Choose a property image</span>
                                    <input type="file" accept="image/*" id="file-upload-2" name="file-upload[]" class="block w-full text-sm text-slate-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-primary 
                                hover:file:bg-slate-100
                                "
                                        onchange="previewImage(event, 2)" />
                                </label>
                            </div>
                            <div class="mb-2">
                                <label class="block">
                                    <span class="sr-only">Choose a property image</span>
                                    <input type="file" accept="image/*" id="file-upload-3" name="file-upload[]" class="block w-full text-sm text-slate-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-primary 
                                hover:file:bg-slate-100
                                "
                                        onchange="previewImage(event, 3)" />
                                </label>
                            </div>

                            <div class="mb-2">
                                <label class="block">
                                    <span class="sr-only">Choose a property image</span>
                                    <input type="file" accept="image/*" id="file-upload-4" name="file-upload[]" class="block w-full text-sm text-slate-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-primary 
                                hover:file:bg-slate-100
                                "
                                        onchange="previewImage(event, 4)" />
                                </label>
                            </div>
                            <div class="mb-2">
                                <label class="block">
                                    <span class="sr-only">Choose a property image</span>
                                    <input type="file" accept="image/*" id="file-upload-5" name="file-upload[]" class="block w-full text-sm text-slate-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-primary 
                                hover:file:bg-slate-100
                                "
                                        onchange="previewImage(event, 5)" />
                                </label>
                            </div>
                            <!-- Image Preview Container -->
                            <div id="image-preview-container" class="grid grid-cols-2 gap-4 mt-4">
                                <!-- Images will be displayed here -->

                            </div>

                            <div class="flex justify-end">
                                <button type="submit" name="update_listing" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                    Update Listing
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script>
        function previewImage(event, index) {
            const file = event.target.files[0]; // Get the first selected file
            if (!file) return; // If no file is selected, do nothing

            const imagePreviewContainer = document.getElementById('image-preview-container');

            // Check if an image preview for this index already exists
            let existingImage = document.getElementById(`image-preview-${index}`);
            if (existingImage) {
                existingImage.remove(); // Remove the previous preview if it exists
            }

            // Only create a preview for image files
            if (file.type.startsWith('image/')) {
                const imageElement = document.createElement('img');
                imageElement.id = `image-preview-${index}`;
                imageElement.src = URL.createObjectURL(file); // Create a URL for the file
                imageElement.classList.add('w-full', 'h-48', 'object-cover', 'rounded-lg', 'border', 'border-gray-200', 'shadow-sm');
                imageElement.onload = () => {
                    URL.revokeObjectURL(imageElement.src); // Release memory once the image is loaded
                };

                // Append the image element to the preview container
                imagePreviewContainer.appendChild(imageElement);
            } else {
                alert("Please select a valid image file.");
            }
        }

        function toggleRooms() {
            const businessRadio = document.querySelector('input[name="property_type"][value="business establishment"]');
            const bedroomContainer = document.getElementById('bedroom-container');

            if (businessRadio.checked) {
                bedroomContainer.style.display = 'none';
            } else {
                bedroomContainer.style.display = 'block';
            }
        }

        window.onload = function() {
            toggleRooms();
        }
    </script>
    <?php include 'includes/footer.php'; ?>
    <script>
        //Start Sidebar
        const sidebarToggle = document.querySelector(".sidebar-toggle");
        const sidebarOverlay = document.querySelector(".sidebar-overlay");
        const sidebarMenu = document.querySelector(".sidebar-menu");
        const main = document.querySelector(".main");

        sidebarToggle.addEventListener("click", (e) => {
            e.preventDefault();
            main.classList.toggle("active");
            sidebarOverlay.classList.toggle("hidden");
            sidebarMenu.classList.toggle("-translate-x-full");
        });

        sidebarOverlay.addEventListener("click", (e) => {
            e.preventDefault();
            main.classList.add("active");
            sidebarOverlay.classList.toggle("hidden");
            sidebarMenu.classList.toggle("-translate-x-full");
        });

        document.querySelectorAll(".sidebar-dropdown-toggle").forEach((item) => {
            item.addEventListener("click", (e) => {
                e.preventDefault();
                const parent = item.closest(".group");
                if (parent.classList.contains("selected")) {
                    parent.classList.remove("selected");
                } else {
                    document.querySelectorAll(".sidebar-dropdown-toggle").forEach((item) => {
                        item.closest(".group").classList.remove("selected");
                    });
                    parent.classList.add("selected");
                }
                parent.classList.add("selected");
            });
        });

        document.querySelectorAll(".dropdown-toggle").forEach((button) => {
            button.addEventListener("click", () => {
                const dropdownMenu = button.nextElementSibling;

                // Toggle the hidden class to show/hide the dropdown
                dropdownMenu.classList.toggle("hidden");

                // Close any other open dropdowns
                document.querySelectorAll(".dropdown-menu").forEach((menu) => {
                    if (menu !== dropdownMenu) {
                        menu.classList.add("hidden");
                    }
                });
            });
        });

        // Optional: Close the dropdown if clicked outside
        document.addEventListener("click", (e) => {
            const isDropdown =
                e.target.matches(".dropdown-toggle") || e.target.closest(".dropdown");
            if (!isDropdown) {
                document.querySelectorAll(".dropdown-menu").forEach((menu) => {
                    menu.classList.add("hidden");
                });
            }
        });

        //End Sidebar

        document.addEventListener("DOMContentLoaded", function() {
            const breadCrumb = document.getElementById("breadcrumb");
            const pageLinks = document.querySelectorAll("a[href]");

            pageLinks.forEach((link) => {
                link.addEventListener("click", function(event) {
                    const pageName = this.textContent.trim();

                    // Prevent duplicate "Dashboard / Dashboard" entries

                    breadCrumb.textContent = `${pageName}`;

                    // Store the breadcrumb in localStorage
                    localStorage.setItem("breadcrumb", breadCrumb.textContent);
                });
            });

            // On page load, restore the breadcrumb from localStorage
            const savedBreadcrumb = localStorage.getItem("breadcrumb");
            if (savedBreadcrumb) {
                breadCrumb.textContent = savedBreadcrumb;
            } else {
                breadCrumb.textContent = "Dashboard";
            }
        });
    </script>

</body>

</html>
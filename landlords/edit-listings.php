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
        <form class="space-y-6" action="Controllers/ListingController.php?id=<?= htmlspecialchars($listing_id); ?>" method="POST" enctype="multipart/form-data">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>

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
                                <input type="radio" name="property_type" value="apartment" class="radio" <?php if ($listingDetails['property_type'] == 'apartment') echo 'checked'; ?> onchange="toggleRooms()">
                                <span class="ml-2 text-sm text-gray-700">Apartment</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="property_type" value="business establishment" class="radio" <?php if ($listingDetails['property_type'] == 'business') echo 'checked'; ?> onchange="toggleRooms()">
                                <span class="ml-2 text-sm text-gray-700">Business Establishment</span>
                            </label>
                        </div>
                        <?php if (isset($errors['property_type'])): ?>
                            <p class="text-red-500 text-sm"><?php echo htmlspecialchars($errors['property_type']); ?></p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-700">Payment Options</h3>
                        <div class="grid grid-cols-2 gap-4 mt-2">
                            <?php
                            $payment_options = json_decode($listingDetails['payment_options'], true) ?? [];
                            ?>
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="payment_options[]" value="one month deposit" class="checkbox checkbox-sm" <?php echo in_array("one month deposit", $payment_options) ? 'checked' : ''; ?>>
                                    <span class="ml-2 text-sm text-gray-700">One Month Deposit</span>
                                </label>
                            </div>
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="payment_options[]" value="one month advance" class="checkbox checkbox-sm" <?php echo in_array("one month advance", $payment_options) ? 'checked' : ''; ?>>
                                    <span class="ml-2 text-sm text-gray-700">One Month Advance</span>
                                </label>
                            </div>
                        </div>
                        <?php if (isset($errors['payment_options'])): ?>
                            <p class="text-red-500 text-sm"><?php echo htmlspecialchars($errors['payment_options']); ?></p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">Property Name</label>
                        <input type="text" id="address" class="input input-bordered w-full" name="listing_name" value="<?= htmlspecialchars($listingDetails['listing_name']); ?>" />
                    </div>
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                        <input type="text" id="address" class="input input-bordered w-full" name="address" value="<?= htmlspecialchars($listingDetails['address']); ?>" />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div id="bedroom-container">
                            <label for="bedrooms" class="block text-sm font-medium text-gray-700">Bedrooms</label>
                            <input id="bedrooms" type="number" class="input input-bordered w-full" placeholder="2" name="bedrooms" value="<?= htmlspecialchars($listingDetails['bedrooms']); ?>" />
                        </div>
                        <div>
                            <label for="bathrooms" class="block text-sm font-medium text-gray-700">Bathrooms</label>
                            <input id="bathrooms" type="number" name="bathrooms" class="input input-bordered w-full" placeholder="1" value="<?= htmlspecialchars($listingDetails['bathrooms']); ?>" />
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-700">Utilities</h3>
                        <div class="grid grid-cols-2 gap-4 mt-2">

                            <?php
                            // Decode the amenities from JSON if it's in string format
                            $utilitiesArray = json_decode($listingDetails['utilities'], true) ?? [];
                            ?>
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="utilities[]" value="electric bill" class="checkbox" <?php echo in_array("electric bill", $utilitiesArray) ? 'checked' : ''; ?>>
                                    <span class="ml-2 text-sm text-gray-700">Electric Bill</span>
                                </label>
                            </div>
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="utilities[]" value="water" class="checkbox" <?php echo in_array("water", $utilitiesArray) ? 'checked' : ''; ?>>
                                    <span class="ml-2 text-sm text-gray-700">Water</span>
                                </label>
                            </div>
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="utilities[]" value="wifi" class="checkbox" <?php echo in_array("wifi", $utilitiesArray) ? 'checked' : ''; ?>>
                                    <span class="ml-2 text-sm text-gray-700">Wifi</span>
                                </label>
                            </div>

                            <!-- Add more checkboxes for additional amenities as needed -->
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
                        <label for="sqft" class="block text-sm font-medium text-gray-700">Square Meters</label>
                        <input id="sqft" type="number" name="sqft" class="input input-bordered w-full" placeholder="1200" value="<?= htmlspecialchars($listingDetails['sqft']); ?>" />
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="description" name="description" rows="3" class="textarea textarea-bordered  w-full" placeholder="Describe the property details..."><?= htmlspecialchars($listingDetails['description']); ?></textarea>
                    </div>
                </div>
                <div>
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
                        <h1 class="block font-medium mb-2 text-gray-700">Update Images of the Property (Please upload 5 images*)</h1>
                        <div class="mb-2">
                            <label class="block">
                                <span class="sr-only">Choose a property image</span>
                                <input type="file" accept="image/*" id="file-upload-1" name="file-upload[]" class="block w-full text-sm text-slate-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-primary 
                                cursor-pointer
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
                                
                                "
                                    onchange="previewImage(event, 5)" />
                            </label>
                        </div>
                        <!-- Image Preview Container -->
                        <div id="image-preview-container" class="grid grid-cols-2 gap-4 mt-4">
                            <!-- Images will be displayed here -->

                        </div>

                        <div class="flex justify-end gap-1">
                            <a href="listings" class="btn">
                                Cancel
                            </a>
                            <button type="submit" name="update_listing" class="btn bg-primary text-white">
                                Update Listing
                            </button>
                        </div>
                    </div>
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
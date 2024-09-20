<?php include 'includes/header.php';

$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
$formData = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];

// Clear errors and form data from the session after displaying them
unset($_SESSION['errors']);
unset($_SESSION['form_data']);

error_reporting(E_ALL);
ini_set('display_errors', 1);

?>
<main class="main-content main">
    <?php include 'includes/topbar.php'; ?>
    <div class="container mx-auto px-4 sm:px-6 md:px-8 py-12">
        <h1 class="text-3xl font-bold mb-8">Add New Listing</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <form class="space-y-6" action="Controllers/ListingController.php" method="POST" enctype="multipart/form-data">
                    <?php if (!empty($errors)): ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Error!</strong>
                            <ul class="list-disc pl-5 mt-2">
                                <?php foreach ($errors as $field => $error): ?>
                                    <?php
                                    // Check if $error is an array and handle it
                                    if (is_array($error)) {
                                        foreach ($error as $subError) {
                                            echo '<li>' . htmlspecialchars($subError) . '</li>';
                                        }
                                    } else {
                                        echo '<li>' . htmlspecialchars($error) . '</li>';
                                    }
                                    ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <div>
                        <h3 class="text-lg font-medium text-gray-700">Property Type*</h3>
                        <div class="flex gap-4 mt-2">
                            <label class="inline-flex items-center">
                                <input type="radio" name="property_type" value="apartment" class="rounded border-gray-300 text-primary focus:ring-primary" <?php if (isset($_POST['property_type']) && $_POST['property_type'] == 'Apartment') echo 'checked'; ?> onchange="toggleRooms()">
                                <span class="ml-2 text-sm text-gray-700">Apartment</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="property_type" value="business establishment" class="rounded border-gray-300 text-primary focus:ring-primary" <?php if (isset($_POST['property_type']) && $_POST['property_type'] == 'Business Establishment') echo 'checked'; ?> onchange="toggleRooms()">
                                <span class="ml-2 text-sm text-gray-700">Business Establishment</span>
                            </label>
                        </div>
                        <?php if (isset($errors['property_type'])): ?>
                            <p class="text-red-500 text-sm"><?php echo htmlspecialchars($errors['property_type']); ?></p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">
                            Address*
                        </label>
                        <input
                            type="text"
                            id="address"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"
                            name="address"
                            placeholder="123 Main St, Anytown USA" />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div id="bedroom-container">
                            <label for="bedrooms" class="block text-sm font-medium text-gray-700">
                                Bedrooms*
                            </label>
                            <input
                                id="bedrooms"
                                type="number"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"
                                placeholder="2"
                                name="bedrooms" />
                        </div>
                        <div>
                            <label for="bathrooms" class="block text-sm font-medium text-gray-700">
                                Bathrooms*
                            </label>
                            <input
                                id="bathrooms"
                                type="number"
                                name="bathrooms"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"
                                placeholder="1" />
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-700">Amenities</h3>
                        <div class="grid grid-cols-2 gap-4 mt-2">


                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="amenities[]" value="gym" class="rounded border-gray-300 text-primary focus:ring-primary">
                                    <span class="ml-2 text-sm text-gray-700">Gym</span>
                                </label>
                            </div>
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="amenities[]" value="balcony" class="rounded border-gray-300 text-primary focus:ring-primary">
                                    <span class="ml-2 text-sm text-gray-700">Balcony</span>
                                </label>
                            </div>
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="amenities[]" value="swimming pool" class="rounded border-gray-300 text-primary focus:ring-primary">
                                    <span class="ml-2 text-sm text-gray-700">Swimming Pool</span>
                                </label>
                            </div>
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="amenities[]" value="airconditioned" class="rounded border-gray-300 text-primary focus:ring-primary">
                                    <span class="ml-2 text-sm text-gray-700">Air-Conditioned</span>
                                </label>
                            </div>
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="amenities[]" value="parking" class="rounded border-gray-300 text-primary focus:ring-primary">
                                    <span class="ml-2 text-sm text-gray-700">Parking</span>
                                </label>
                            </div>
                            <!-- Add more checkboxes for additional amenities as needed -->
                        </div>
                    </div>
                    <div>
                        <label for="sqft" class="block text-sm font-medium text-gray-700">
                            Square Meters*
                        </label>
                        <input
                            id="sqft"
                            type="number"
                            name="sqft"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"
                            placeholder="1200" />
                    </div>
                    <div>
                        <label for="rent" class="block text-sm font-medium text-gray-700">
                            Rent Price*
                        </label>
                        <input
                            id="rent"
                            type="number"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"
                            placeholder="1500"
                            name="rent" />
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">
                            Description*
                        </label>
                        <textarea
                            id="description"
                            name="description"
                            rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"
                            placeholder="Describe the property details..."></textarea>
                    </div>
                    <div>
                        <h1 class="block text-sm font-medium mb-2 text-gray-700">Upload Images of the Property</h1>
                        <div class="mb-2">
                            <label class="block">
                                <span class="sr-only">Choose a property image</span>
                                <input type="file" accept="image/*" id="file-upload-1" name="file-upload[]" class="block w-full text-sm text-slate-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-primary 
                                hover:file:bg-slate-100t-100
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
                    </div>




                    <div class="flex justify-center">
                        <button
                            type="submit"
                            name="add_listing"
                            class="inline-flex justify-center rounded-md border border-transparent bg-primary py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                            Save Listing
                        </button>
                    </div>
                </form>
            </div>
            <div>
                <h2 class="text-2xl font-bold mb-4">Your Listings</h2>
                <div class="space-y-4">
                    <div class="bg-white rounded-lg shadow-md p-4">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="text-lg font-medium">123 Main St, Anytown USA</h3>
                            <div class="flex gap-2">
                                <button class="text-primary hover:text-primary-dark">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <button class="text-red-500 hover:text-red-700">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <p class="text-gray-500 mb-2">2 bedrooms, 1 bathroom</p>
                        <p class="text-gray-500 mb-2">1200 sq ft</p>
                        <p class="text-gray-500 mb-2">$1500/month</p>
                    </div>
                    <div class="bg-white rounded-lg shadow-md p-4">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="text-lg font-medium">456 Oak St, Anytown USA</h3>
                            <div class="flex gap-2">
                                <button class="text-primary hover:text-primary-dark">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <button class="text-red-500 hover:text-red-700">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <p class="text-gray-500 mb-2">3 bedrooms, 2 bathrooms</p>
                    </div>
                </div>
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
<?php include 'includes/footer.php';  ?>
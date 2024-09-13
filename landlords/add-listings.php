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
                                    <li><?php echo htmlspecialchars($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <div>
                        <h3 class="text-lg font-medium text-gray-700">Property Type*</h3>
                        <div class="flex gap-4 mt-2">
                            <label class="inline-flex items-center">
                                <input type="radio" name="property_type" value="apartment" class="rounded border-gray-300 text-primary focus:ring-primary" <?php if (isset($_POST['property_type']) && $_POST['property_type'] == 'Apartment') echo 'checked'; ?>>
                                <span class="ml-2 text-sm text-gray-700">Apartment</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="property_type" value="business" class="rounded border-gray-300 text-primary focus:ring-primary" <?php if (isset($_POST['property_type']) && $_POST['property_type'] == 'Business Establishment') echo 'checked'; ?>>
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
                        <div>
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
                                    <input type="checkbox" name="amenities[]" value="water" class="rounded border-gray-300 text-primary focus:ring-primary">
                                    <span class="ml-2 text-sm text-gray-700">Water</span>
                                </label>
                            </div>
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="amenities[]" value="electricity" class="rounded border-gray-300 text-primary focus:ring-primary">
                                    <span class="ml-2 text-sm text-gray-700">Electricity</span>
                                </label>
                            </div>
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="amenities[]" value="wifi" class="rounded border-gray-300 text-primary focus:ring-primary">
                                    <span class="ml-2 text-sm text-gray-700">Wi-Fi</span>
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
                        <label class="block text-sm font-medium text-gray-700">Upload Images of the Property</label>
                        <p class="block text-xs font-medium text-red-500">*Select 5 images in your gallery</p>
                        <div class="mt-1 flex justify-center rounded-md border-2 border-dashed border-gray-300 px-6 pt-5 pb-6">
                            <div class="space-y-1 text-center">
                                <svg
                                    class="mx-auto h-12 w-12 text-gray-400"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 48 48"
                                    aria-hidden="true">
                                    <path
                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label
                                        for="file-upload"
                                        class="relative cursor-pointer rounded-md bg-white font-medium text-primary focus-within:outline-none focus-within:ring-2 focus-within:ring-primary focus-within:ring-offset-2 hover:text-primary-dark">
                                        <span>Upload files</span>
                                        <input id="file-upload" class="sr-only" type="file" name="file-upload[]" accept="image/jpeg, image/png, image/jpg" multiple />
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB each</p>
                            </div>
                            <?php if (isset($errors['file-upload'])): ?>
                                <p class="text-red-500 text-sm"><?php echo htmlspecialchars($errors['file-upload']); ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Five Image Preview Container -->
                        <div id="file-preview" class="grid grid-cols-5 gap-4 mt-4">
                            <!-- Placeholder containers for images -->
                            <div class="image-container w-full h-32 bg-gray-100 rounded-md flex items-center justify-center">
                                <p class="text-sm text-gray-500">Image 1</p>
                            </div>
                            <div class="image-container w-full h-32 bg-gray-100 rounded-md flex items-center justify-center">
                                <p class="text-sm text-gray-500">Image 2</p>
                            </div>
                            <div class="image-container w-full h-32 bg-gray-100 rounded-md flex items-center justify-center">
                                <p class="text-sm text-gray-500">Image 3</p>
                            </div>
                            <div class="image-container w-full h-32 bg-gray-100 rounded-md flex items-center justify-center">
                                <p class="text-sm text-gray-500">Image 4</p>
                            </div>
                            <div class="image-container w-full h-32 bg-gray-100 rounded-md flex items-center justify-center">
                                <p class="text-sm text-gray-500">Image 5</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-center">
                        <button
                            type="submit"
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
    const fileInput = document.getElementById('file-upload');
    const filePreview = document.getElementById('file-preview');
    const maxFiles = 5;

    fileInput.addEventListener('change', (e) => {
        handleFiles(e.target.files);
    });

    function handleFiles(files) {
        const fileArray = Array.from(files).slice(0, maxFiles); // Limit to maxFiles (5)
        const previewContainers = document.querySelectorAll('.image-container'); // Get the 5 containers

        // Clear previous content in all containers
        previewContainers.forEach(container => {
            container.innerHTML = `<p class="text-sm text-gray-500">Image ${Array.from(previewContainers).indexOf(container) + 1}</p>`;
        });

        // Assign each image to a container
        fileArray.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('object-cover', 'w-full', 'h-full', 'rounded-md');
                previewContainers[index].innerHTML = ''; // Clear placeholder text
                previewContainers[index].appendChild(img); // Add image
            };
            reader.readAsDataURL(file);
        });
    }
</script>
<?php include 'includes/footer.php';  ?>
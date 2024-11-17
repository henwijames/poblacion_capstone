<?php include 'includes/header.php';

$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
$formData = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];

// Clear errors and form data from the session after displaying them
unset($_SESSION['errors']);
unset($_SESSION['form_data']);

if (isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'landlord') {
    $landlordId = $_SESSION['user_id'];
    $landlord = new Landlords($db);
    $landlordDetails = $landlord->findById($landlordId);

    // Redirect if tenant is not verified
    if ($landlordDetails['email_verified'] != 1 || $landlordDetails['mobile_verified'] != 1 || $landlordDetails['account_status'] != 'verified') {
        echo "
            <script>
                Swal.fire({
                    title: 'Verification Required',
                    text: 'You must verify your account to add listings.',
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
                        window.location.href = 'index';
                    }
                });
            </script>
        ";
        exit;
    }

    if ($landlordDetails['account_status'] === 'banned') {
        echo "
            <script>
                Swal.fire({
                    title: 'Your Account is Banned',
                    text: 'You must have not any access in the system',
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
                        window.location.href = 'index';
                    }
                });
            </script>
        ";
        exit;
    }
}

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

                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-700">Property Type*</h3>
                        <div class="flex gap-4 mt-2">
                            <label class="inline-flex items-center">
                                <input type="radio" name="property_type" value="apartment" class="radio" <?php if (isset($_POST['property_type']) && $_POST['property_type'] == 'Apartment') echo 'checked'; ?> onchange="toggleRooms()">
                                <span class="ml-2 text-sm text-gray-700">Apartment</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="property_type" value="business establishment" class="radio" <?php if (isset($_POST['property_type']) && $_POST['property_type'] == 'Business Establishment') echo 'checked'; ?> onchange="toggleRooms()">
                                <span class="ml-2 text-sm text-gray-700">Business Establishment</span>
                            </label>
                        </div>
                        <?php if (isset($errors['property_type'])): ?>
                            <p class="text-red-500 text-sm"><?php echo htmlspecialchars($errors['property_type']); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-700">Payment Options</h3>
                        <div class="grid grid-cols-2 gap-4 mt-2">
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="payment_options[]" value="one month deposit" class="checkbox checkbox-md">
                                    <span class="ml-2 text-sm text-gray-700">One Month Deposit</span>
                                </label>
                            </div>
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="payment_options[]" value="one month advance" class="checkbox">
                                    <span class="ml-2 text-sm text-gray-700">One Month Advance</span>
                                </label>
                            </div>
                        </div>
                        <?php if (isset($errors['payment_options'])): ?>
                            <p class="text-red-500 text-sm"><?php echo htmlspecialchars($errors['payment_options']); ?></p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label for="listing_name" class="block text-lg font-medium text-gray-700">
                            Property Name*
                        </label>
                        <input
                            type="text"
                            id="listing_name"
                            class="input input-bordered w-full"
                            name="listing_name"
                            placeholder="House 1" />
                    </div>
                    <div>
                        <label for="address" class="block text-lg font-medium text-gray-700">
                            Address*
                        </label>
                        <input
                            type="text"
                            id="address"
                            class="input input-bordered w-full"
                            name="address"
                            placeholder="Poblacion, Taal, Batangas" />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div id="bedroom-container">
                            <label for="bedrooms" class="block text-lg font-medium text-gray-700">
                                Bedrooms*
                            </label>
                            <input
                                id="bedrooms"
                                type="number"
                                class="input input-bordered w-full"
                                placeholder="2"
                                name="bedrooms" />
                        </div>
                        <div>
                            <label for="bathrooms" class="block text-lg font-medium text-gray-700">
                                Bathrooms*
                            </label>
                            <input
                                id="bathrooms"
                                type="number"
                                name="bathrooms"
                                class="input input-bordered w-full"
                                placeholder="1" />
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-700">Utilities</h3>
                        <div class="grid grid-cols-2 gap-4 mt-2">


                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="utilities[]" value="electric bill" class="checkbox">
                                    <span class="ml-2 text-sm text-gray-700">Electric Bill</span>
                                </label>
                            </div>
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="utilities[]" value="water" class="checkbox">
                                    <span class="ml-2 text-sm text-gray-700">Water</span>
                                </label>
                            </div>
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="utilities[]" value="wifi" class="checkbox">
                                    <span class="ml-2 text-sm text-gray-700">Wifi</span>
                                </label>
                            </div>

                            <!-- Add more checkboxes for additional amenities as needed -->
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-700">Amenities</h3>
                        <div class="grid grid-cols-2 gap-4 mt-2">
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="amenities[]" value="gym" class="checkbox">
                                    <span class="ml-2 text-sm text-gray-700">Gym</span>
                                </label>
                            </div>
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="amenities[]" value="balcony" class="checkbox">
                                    <span class="ml-2 text-sm text-gray-700">Balcony</span>
                                </label>
                            </div>
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="amenities[]" value="swimming pool" class="checkbox">
                                    <span class="ml-2 text-sm text-gray-700">Swimming Pool</span>
                                </label>
                            </div>
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="amenities[]" value="airconditioned" class="checkbox">
                                    <span class="ml-2 text-sm text-gray-700">Air-Conditioned</span>
                                </label>
                            </div>
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="amenities[]" value="parking" class="checkbox">
                                    <span class="ml-2 text-sm text-gray-700">Parking</span>
                                </label>
                            </div>
                            <!-- Add more checkboxes for additional amenities as needed -->
                        </div>
                    </div>
                    <div>
                        <label for="sqft" class="block text-lg font-medium text-gray-700">
                            Square Meters*
                        </label>
                        <input
                            id="sqft"
                            type="number"
                            name="sqft"
                            class="input input-bordered w-full"
                            placeholder="1200" />
                    </div>
                    <div>
                        <label for="rent" class="block text-lg font-medium text-gray-700">
                            Rent Price*
                        </label>
                        <input
                            id="rent"
                            type="number"
                            class="input input-bordered w-full"
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
                            class="textarea textarea-bordered w-full"
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
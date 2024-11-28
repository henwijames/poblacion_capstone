<?php include 'includes/header.php'; ?>
<main class="main-content main">
    <?php require 'includes/topbar.php'; ?>
    <div class="p-6">
        <div class="bg-white rounded-lg overflow-hidden">

            <div class="relative px-4 py-6">

                <h1 class="text-3xl font-bold text-gray-800 mb-8">Edit Profile</h1>
                <!-- Check for success or error in the URL and trigger SweetAlert -->
                <?php if (isset($_GET['success'])): ?>
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Profile updated successfully!',
                            confirmButtonColor: '#C1C549',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'profile.php'; // Redirect to the same page to clear the query string
                            }
                        });
                    </script>
                <?php elseif (isset($_GET['error'])): ?>
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong! Please try again.',
                            confirmButtonColor: '#C1C549',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'edit-profile.php'; // Redirect to the same page to clear the query string
                            }
                        });
                    </script>
                <?php endif; ?>
                <form class="space-y-6" method="POST" action="Controllers/LandlordsController.php" enctype="multipart/form-data">
                    <div class="flex items-center space-x-6">
                        <div class="shrink-0">
                            <img id="profilePhoto" class="h-16 w-16 object-cover rounded-full" src="<?php echo !empty($landlord['profile_picture']) ? 'Controllers/' . htmlspecialchars($landlord['profile_picture']) : '../assets/img/me.jpg'; ?>" alt="Current profile photo" />
                        </div>
                        <label class="block">
                            <span class="sr-only">Choose profile photo</span>
                            <input type="file" name="profile_photo" class="block w-full cursor-pointer text-sm text-slate-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-violet-50 file:text-primary
                            hover:file:bg-accent
                            "
                                onchange="previewProfilePhoto(event)" />
                        </label>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="propertyName" class="block text-sm font-medium text-gray-700">Property Name</label>
                            <input type="text" id="propertyName" name="propertyName" value="<?php echo htmlspecialchars($landlord['property_name']); ?>" class="input input-bordered w-full">
                        </div>
                        <div>
                            <label for="firstName" class="block text-sm font-medium text-gray-700">First Name</label>
                            <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($landlord['first_name']); ?>" class="input input-bordered w-full">
                        </div>
                        <div>
                            <label for="middleName" class="block text-sm font-medium text-gray-700">Middle Name</label>
                            <input type="text" id="middleName" name="middleName" value="<?php echo htmlspecialchars($landlord['middle_name']); ?>" class="input input-bordered w-full">
                        </div>
                        <div>
                            <label for="lastName" class="block text-sm font-medium text-gray-700">Last Name</label>
                            <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($landlord['last_name']); ?>" class="input input-bordered w-full">
                        </div>
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($landlord['address']); ?>" class="input input-bordered w-full">
                        </div>
                    </div>
                    <div class="flex justify-end space-x-4">
                        <a href="profile" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            Cancel
                        </a>
                        <button type="submit" name="update-profile" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-accent ">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<script>
    function previewProfilePhoto(event) {
        const reader = new FileReader();
        const fileInput = event.target;

        reader.onload = function() {
            const imageElement = document.getElementById('profilePhoto');
            imageElement.src = reader.result; // Set the new image source to the uploaded file
        };

        if (fileInput.files[0]) {
            reader.readAsDataURL(fileInput.files[0]); // Read the selected file and convert to a data URL
        }
    }
</script>
<?php include 'includes/footer.php'; ?>
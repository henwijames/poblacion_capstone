<?php
require 'includes/header.php';
require 'includes/sidebar.php';
?>

<main class="main-content main">
    <?php require 'includes/topbar.php'; ?>
    <div class="p-6">
        <div class="bg-white rounded-lg overflow-hidden">

            <div class="relative px-4 py-6">

                <h1 class="text-3xl font-bold text-gray-800 mb-8">Edit Profile</h1>
                <form class="space-y-6" method="POST" action="Controller/TenantController.php" enctype="multipart/form-data">
                    <div class="flex items-center space-x-6">
                        <div class="shrink-0">
                            <img class="h-16 w-16 object-cover rounded-full" src="https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1361&q=80" alt="Current profile photo" />
                        </div>
                        <label class="block">
                            <span class="sr-only">Choose profile photo</span>
                            <input type="file" class="block w-full cursor-pointer text-sm text-slate-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-violet-50 file:text-primary
                            hover:file:bg-accent
                            " />
                        </label>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="firstName" class="block text-sm font-medium text-gray-700">First Name</label>
                            <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($tenant['first_name']); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label for="middleName" class="block text-sm font-medium text-gray-700">Middle Name</label>
                            <input type="text" id="middleName" name="middleName" value="<?php echo htmlspecialchars($tenant['middle_name']); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label for="lastName" class="block text-sm font-medium text-gray-700">Last Name</label>
                            <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($tenant['last_name']); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($tenant['address']); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label for="phoneNumber" class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="tel" id="phoneNumber" name="phoneNumber" value="<?php echo htmlspecialchars($tenant['phone_number']); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($tenant['email']); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                    </div>
                    <div class="flex justify-end space-x-4">
                        <a href="profile" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            Cancel
                        </a>
                        <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-accent ">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<?php require 'includes/footer.php'; ?>
<?php include 'includes/header.php'; ?>
<main class="main-content main">
    <?php include 'includes/topbar.php'; ?>
    <div class="p-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">Listings</h1>
            <a href="add-listing.php" class="bg-primary text-white py-2 px-4 rounded-md hover:bg-accent transition-all">Add Listing</a>
        </div>
        <div class="mt-4">
            <table class="w-full border border-gray-200 rounded-md">
                <thead class="bg-gray-50">
                    <tr class="bg-slate-100">
                        <th class="py-2 px-4 border-r border-gray-200">House Name</th>
                        <th class="py-2 px-4 border-r border-gray-200">Location</th>
                        <th class="py-2 px-4 border-r border-gray-200">Price</th>
                        <th class="py-2 px-4 border-r border-gray-200">Status</th>
                        <th class="py-2 px-4 border-r border-gray-200">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b">
                        <td class="py-2 px-4 border-r border-gray-200">La Zanti</td>
                        <td class="py-2 px-4 border-r border-gray-200">Poblacion, Taal, Batangas</td>
                        <td class="py-2 px-4 border-r border-gray-200">P4,000/month</td>
                        <td class="py-2 px-4 border-r border-gray-200">Occupied</td>
                        <td class="py-2 px-4 border-r border-gray-200 text-center">
                            <a href="edit-listings" class="inline-block px-4 py-1 rounded-md text-sm bg-blue-400 text-white">
                                Edit
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="py-2 px-4 border-r border-gray-200">Bahay Kubo</td>
                        <td class="py-2 px-4 border-r border-gray-200">Zone 13, Taal, Batangas</td>
                        <td class="py-2 px-4 border-r border-gray-200">₱3,500/month</td>
                        <td class="py-2 px-4 border-r border-gray-200">Not Occupied</td>
                        <td class="py-2 px-4 border-r border-gray-200 text-center">
                            <a href="edit-listings" class="inline-block px-4 py-1 rounded-md text-sm bg-blue-400 text-white">
                                Edit
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</main>
<?php include 'includes/footer.php'; ?>
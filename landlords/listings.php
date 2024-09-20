<?php
include 'includes/header.php';

$database = new Database();
$db = $database->getConnection();
$listing = new Listing($db);
$landlords = new Landlords($db);

$user_id = $_SESSION['user_id'];
$userListings = $listing->getListingsByUser($user_id);

?>
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
                        <th class="py-2 px-4 border-r border-gray-200">Property</th>
                        <th class="py-2 px-4 border-r border-gray-200">Type</th>
                        <th class="py-2 px-4 border-r border-gray-200">Location</th>
                        <th class="py-2 px-4 border-r border-gray-200">Price</th>
                        <th class="py-2 px-4 border-r border-gray-200">Status</th>
                        <th class="py-2 px-4 border-r border-gray-200">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($userListings)): ?>
                        <?php foreach ($userListings as $userListing): ?>
                            <tr class="border-b">
                                <td class="py-2 px-4 border-r border-gray-200"><?= htmlspecialchars($landlord['property_name']) ?></td>
                                <td class="py-2 px-4 border-r border-gray-200 capitalize"><?= htmlspecialchars($userListing['property_type']) ?></td>
                                <td class="py-2 px-4 border-r border-gray-200"><?= htmlspecialchars($userListing['address']) ?></td>
                                <td class="py-2 px-4 border-r border-gray-200">₱<?= number_format($userListing['rent']) ?>/month</td>
                                <td class="py-2 px-4 border-r border-gray-200 capitalize"><?= htmlspecialchars($userListing['status']) ?></td>
                                <td class="py-2 px-4 border-r border-gray-200 text-center">
                                    <a href="edit-listings.php?id=<?= $userListing['id'] ?>" class="inline-block px-4 py-1 rounded-md text-sm bg-blue-400 text-white">
                                        Edit
                                    </a>
                                    <a href="view-listings.php?id=<?= $userListing['id'] ?>" class="inline-block px-4 py-1 rounded-md text-sm bg-blue-400 text-white">
                                        View
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="py-4 text-center">No listings found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
<?php include 'includes/footer.php'; ?>
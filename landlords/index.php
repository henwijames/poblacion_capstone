<?php
include 'includes/header.php';

function getCounts($db, $user_id)
{
    $counts = [
        'activeListings' => 0,
        'tenants' => 0,
        'rents' => 0
    ];

    // Fetch active listings for this user
    $query = "SELECT COUNT(*) as activeListings FROM listings WHERE status = 'not occupied' AND user_id = :user_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $counts['activeListings'] = $stmt->fetch(PDO::FETCH_ASSOC)['activeListings'];



    return $counts;
}

// Initialize DB connection
$database = new Database();
$db = $database->getConnection();
$user_id = $_SESSION['user_id']; // Ensure this session variable is set correctly

// Get the counts for the logged-in user
$counts = getCounts($db, $user_id);

$listing = new Listing($db);
$userListings = $listing->getListingsByUser($user_id) ?? [];
?>

<main class="main-content main">
    <?php include 'includes/topbar.php'; ?>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            <div class=" rounded-md shadow-md border border-gray-100 p-6">
                <div class="flex justify-between">
                    <div>
                        <div class="text-2xl font-semibold mb-1"><?php echo htmlspecialchars($counts['activeListings']); ?></div>
                        <div class="text-sm font-medium text-gray-400">Active Listings</div>
                    </div>
                    <div class="text-[40px]">
                        <i class="fa-solid fa-sign-hanging"></i>
                    </div>
                </div>


            </div>
            <div class=" rounded-md shadow-md border border-gray-100 p-6">
                <div class="flex justify-between">
                    <div>
                        <div class="text-2xl font-semibold mb-1">0</div>
                        <div class="text-sm font-medium text-gray-400">Tenants</div>
                    </div>
                    <div class="text-[40px]">
                        <i class="fa-solid fa-person"></i>
                    </div>
                </div>

            </div>
            <div class=" rounded-md shadow-md border border-gray-100 p-6">
                <div class="flex justify-between">
                    <div>
                        <div class="text-2xl font-semibold mb-1">0</div>
                        <div class="text-sm font-medium text-gray-400">Rents</div>
                    </div>
                    <div class="text-[40px]">
                        <i class="fa-solid fa-key"></i>
                    </div>
                </div>

            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-background border border-gray-100 shadow-md shadow-black/10 p-6 rounded-md">
                <div class="mb-4 flex justify-between items-start">
                    <div class="font-medium">Tenant</div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[540px] table-auto border-collapse shadow-lg">
                        <thead class="bg-slate-100">
                            <tr>
                                <th class="text-[12px] uppercase tracking-wide font-semibold py-3 px-4 text-left text-slate-700">Name</th>
                                <th class="text-[12px] uppercase tracking-wide font-semibold py-3 px-4 text-left text-slate-700">House Rented</th>
                                <th class="text-[12px] uppercase tracking-wide font-semibold py-3 px-4 text-left text-slate-700">Monthly Rate</th>
                                <th class="text-[12px] uppercase tracking-wide font-semibold py-3 px-4 text-left text-slate-700 rounded-tr-md">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b hover:bg-slate-50 transition-colors">
                                <td class="py-3 px-4 text-[13px] text-slate-600 font-medium">Henry James Ribano</td>
                                <td class="py-3 px-4 text-[13px] text-slate-600 font-medium text-center">House 5</td>
                                <td class="py-3 px-4 text-[13px] text-slate-600 font-medium text-center">P2,500</td>
                                <td class="py-3 px-4">
                                    <span class="inline-block px-4 py-1 rounded-full text-sm bg-yellow-400 text-white">Pending</span>
                                </td>
                            </tr>
                            <tr class="bg-white border-b hover:bg-slate-50 transition-colors">
                                <td class="py-3 px-4 text-[13px] text-slate-600 font-medium">Juan Lorenzo Aguilar</td>
                                <td class="py-3 px-4 text-[13px] text-slate-600 font-medium text-center">House 2</td>
                                <td class="py-3 px-4 text-[13px] text-slate-600 font-medium text-center">P2,800</td>
                                <td class="py-3 px-4">
                                    <span class="inline-block px-4 py-1 rounded-full text-sm bg-green-400 text-white">Verified</span>
                                </td>
                            </tr>
                            <tr class="bg-white hover:bg-slate-50 transition-colors">
                                <td class="py-3 px-4 text-[13px] text-slate-600 font-medium">John Michael Castor</td>
                                <td class="py-3 px-4 text-[13px] text-slate-600 font-medium text-center">House 1</td>
                                <td class="py-3 px-4 text-[13px] text-slate-600 font-medium text-center">P2,100</td>
                                <td class="py-3 px-4">
                                    <span class="inline-block w-24 px-4 py-1 rounded-full text-xs bg-red-400 text-white">Not Paid</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
            <div class="bg-background border border-gray-100 shadow-md shadow-black/10 p-6 rounded-md">
                <div class="mb-4 flex justify-between items-start">
                    <div class="font-medium">Listings</div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[540px] table-auto border-collapse shadow-lg">
                        <thead class="bg-slate-100">
                            <tr>
                                <th class="text-[12px] uppercase tracking-wide font-semibold py-3 px-4 text-left text-slate-700">House</th>
                                <th class="text-[12px] uppercase tracking-wide font-semibold py-3 px-4 text-left text-slate-700">Monthly Rent</th>
                                <th class="text-[12px] uppercase tracking-wide font-semibold py-3 px-4 text-left text-slate-700">House Type</th>
                                <th class="text-[12px] uppercase tracking-wide font-semibold py-3 px-4 text-left text-slate-700 rounded-tr-md">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($userListings)): ?>
                                <?php foreach ($userListings as $userListing): ?>
                                    <tr class="bg-white border-b hover:bg-slate-50 transition-colors">
                                        <td class="py-3 px-4 text-[13px] text-slate-600 font-medium"><?= htmlspecialchars($landlord['property_name']) ?></td>
                                        <td class="py-3 px-4 text-[13px] text-slate-600 font-medium text-center">₱<?= number_format($userListing['rent']) ?></td>
                                        <td class="py-3 px-4 text-[13px] text-slate-600 font-medium text-center capitalize"><?= htmlspecialchars($userListing['property_type']) ?></td>
                                        <td class="py-3 px-4 flex gap-2">
                                            <button class="inline-block px-4 py-1 rounded-md text-sm bg-blue-400 text-white">
                                                Edit
                                            </button>
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
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
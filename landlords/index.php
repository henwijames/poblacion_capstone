<?php
include 'includes/header.php';

$landlord_id = $_SESSION['user_id'];

function getCounts($db, $user_id)
{
    $counts = [
        'activeListings' => 0,
        'tenants' => 0,
        'inquiries' => 0
    ];

    // Fetch active listings for this user
    $query = "SELECT COUNT(*) as activeListings FROM listings WHERE status = 'not occupied' AND user_id = :user_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $counts['activeListings'] = $stmt->fetch(PDO::FETCH_ASSOC)['activeListings'];


    $inqQuery = "SELECT COUNT(*) as inquiries FROM bookings JOIN tenants ON bookings.user_id = tenants.id 
                      WHERE bookings.landlord_id = :landlord_id";
    $inqStmt = $db->prepare($inqQuery);
    $inqStmt->bindParam(':landlord_id', $user_id);
    $inqStmt->execute();
    $counts['inquiries'] = $inqStmt->fetch(PDO::FETCH_ASSOC)['inquiries'];

    $tenantQuery = "SELECT COUNT(*) as tenants FROM rent JOIN 
            tenants 
        ON 
            rent.user_id = tenants.id 
        JOIN 
            listings 
        ON 
            rent.listing_id = listings.id  
        WHERE 
            rent.landlord_id = :landlord_id
        GROUP BY 
            tenants.id";
    $tenantStmt = $db->prepare($tenantQuery);
    $tenantStmt->bindParam(':landlord_id', $user_id);
    $tenantStmt->execute();
    if ($tenantStmt->execute()) {
        $result = $tenantStmt->fetch(PDO::FETCH_ASSOC);
        $counts['tenants'] = $result ? $result['tenants'] : 0; // Default to 0 if no rows
    } else {
        // Handle execution failure
        $counts['tenants'] = 0;
        error_log("Query failed: " . implode(", ", $tenantStmt->errorInfo()));
    }


    return $counts;
}



// Initialize DB connection
$database = new Database();
$db = $database->getConnection();
$user_id = $_SESSION['user_id']; // Ensure this session variable is set correctly

// Get the counts for the logged-in user
$counts = getCounts($db, $user_id);

$listing = new Listing($db);
$landlords = new Landlords($db);
$tenantList = $landlords->getTenantsByLandlordId($landlord_id);  // Custom method to fetch tenants based on landlord ID
$userListings = $listing->getListingsByLandlord($user_id) ?? [];
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
                        <div class="text-2xl font-semibold mb-1"><?php echo htmlspecialchars($counts['tenants']); ?></div>
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
                        <div class="text-2xl font-semibold mb-1"><?php echo htmlspecialchars($counts['inquiries']); ?></div>
                        <div class="text-sm font-medium text-gray-400">Inquiries</div>
                    </div>
                    <div class="text-[40px]">
                        <i class="fa-solid fa-paper-plane"></i>
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
                    <table class="table table-zebra bg-white">
                        <thead class="bg-slate-100">
                            <tr>
                                <th class="text-[12px] uppercase tracking-wide font-semibold py-3 px-4 text-left text-slate-700">Full Name</th>
                                <th class="text-[12px] uppercase tracking-wide font-semibold py-3 px-4 text-left text-slate-700">House Name</th>
                                <th class="text-[12px] uppercase tracking-wide font-semibold py-3 px-4 text-left text-slate-700">Address</th>
                                <th class="text-[12px] uppercase tracking-wide font-semibold py-3 px-4 text-left text-slate-700">Phone Number</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($tenantList)) : ?>
                                <?php
                                // Limit tenant list to 5
                                $tenantListLimited = array_slice($tenantList, 0, 5);
                                ?>
                                <?php foreach ($tenantListLimited as $tenant) : ?>
                                    <tr class="border-b">
                                        <td class="py-2 px-4 border-r border-gray-200"><?php echo htmlspecialchars($tenant['tenants_name']); ?></td>
                                        <td class="py-2 px-4 border-r border-gray-200"><?php echo htmlspecialchars($tenant['listing_name']); ?></td>
                                        <td class="py-2 px-4 border-r border-gray-200"><?php echo htmlspecialchars($tenant['address']); ?></td>
                                        <td class="py-2 px-4 border-r border-gray-200"><?php echo htmlspecialchars($tenant['phone_number']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="5" class="text-center py-2 px-4">No tenants found for this landlord.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Listings Table -->
            <div class="bg-background border border-gray-100 shadow-md shadow-black/10 p-6 rounded-md">
                <div class="mb-4 flex justify-between items-start">
                    <div class="font-medium">Listings</div>
                </div>
                <div class="overflow-x-auto">
                    <table class="table table-zebra bg-white">
                        <thead class="bg-slate-100">
                            <tr>
                                <th class="text-[12px] uppercase tracking-wide font-semibold py-3 px-4 text-left text-slate-700">House</th>
                                <th class="text-[12px] uppercase tracking-wide font-semibold py-3 px-4 text-left text-slate-700">Monthly Rent</th>
                                <th class="text-[12px] uppercase tracking-wide font-semibold py-3 px-4 text-left text-slate-700">House Type</th>
                                <th class="text-[12px] uppercase tracking-wide font-semibold py-3 px-4 text-left text-slate-700">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($userListings)): ?>
                                <?php
                                // Limit listings to 5
                                $userListingsLimited = array_slice($userListings, 0, 5);
                                ?>
                                <?php foreach ($userListingsLimited as $userListing): ?>
                                    <tr class="bg-white border-b hover:bg-slate-50 transition-colors">
                                        <td class="py-2 px-4 border-r border-gray-200"><?= htmlspecialchars($userListing['listing_name']) ?></td>
                                        <td class="py-2 px-4 border-r border-gray-200 text-center">₱<?= number_format($userListing['rent']) ?></td>
                                        <td class="py-2 px-4 border-r border-gray-200 text-center capitalize"><?= htmlspecialchars($userListing['property_type']) ?></td>
                                        <td class="py-2 px-4 border-r border-gray-200 text-center capitalize">
                                            <!-- Add DaisyUI badge based on status -->
                                            <?php if ($userListing['status'] === 'occupied'): ?>
                                                <span class="badge badge-success ml-2 text-white">Occupied</span>
                                            <?php elseif ($userListing['status'] === 'not occupied'): ?>
                                                <span class="badge badge-error ml-2">Not Occupied</span>
                                            <?php endif; ?>
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
<?php
include 'includes/header.php';

$database  = new  Database();
$db =  $database->getConnection();
$landlords = new Landlords($db);
$tenants = new Tenants($db);

try {
    $query =  "SELECT COUNT(*) AS total_landlords FROM landlords";
    $stmt =  $db->prepare($query);
    $stmt->execute();

    $result  = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_landlords =  $result['total_landlords'];
} catch (PDOException $e) {
    echo 'Error:  ' . $e->getMessage();
}

try {
    $query =  "SELECT COUNT(*) AS total_tenants FROM tenants";
    $stmt =  $db->prepare($query);
    $stmt->execute();

    $result  = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_tenants =  $result['total_tenants'];
} catch (PDOException $e) {
    echo 'Error:  ' . $e->getMessage();
}
$landlordsList = $landlords->getAllLandlords();
$tenantsList = $tenants->getAllTenants();

// Get the listings limited to 5
try {
    $query = "SELECT * FROM listings LIMIT 5"; // Limit the results to 5
    $stmt = $db->prepare($query);
    $stmt->execute();

    $listingsData = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all listings
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>

<main class="main-content main">
    <?php include 'includes/topbar.php'; ?>

    <div class="p-6">
        <h1 class="text-2xl md:text-4xl mb-6 text-center md:text-start">Welcome back, <span class="font-bold"><?php echo htmlspecialchars($username);  ?>!</span></h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 mb-6">
            <div class="bg-background rounded-md shadow-md border border-gray-100 p-6">
                <div class="flex justify-between">
                    <div>
                        <div class="text-2xl font-semibold mb-1"><?php echo htmlspecialchars($total_landlords); ?></div>
                        <div class="text-sm font-medium text-gray-400">Landlords</div>
                    </div>
                    <div class="text-[40px]">
                        <i class="fa-solid fa-sign-hanging"></i>
                    </div>
                </div>


            </div>
            <div class="bg-background rounded-md shadow-md border border-gray-100 p-6">
                <div class="flex justify-between">
                    <div>
                        <div class="text-2xl font-semibold mb-1"><?php echo htmlspecialchars($total_tenants); ?></div>
                        <div class="text-sm font-medium text-gray-400">Tenants</div>
                    </div>
                    <div class="text-[40px]">
                        <i class="fa-solid fa-person"></i>
                    </div>
                </div>

            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-background border border-gray-100 shadow-md shadow-black/10 p-6 rounded-md">
                <div class="mb-4 flex justify-between items-start">
                    <div class="font-medium">Landlords</div>
                </div>
                <div class="overflow-x-auto">
                    <table class="table table-zebra  bg-white">
                        <thead class="bg-slate-100">
                            <tr>
                                <th class="py-2 px-4 border-r border-gray-200">Name</th>
                                <th class="py-2 px-4 border-r border-gray-200">Status</th>
                                <th class="py-2 px-4 border-r border-gray-200">Business Permit</th>
                                <th class="py-2 px-4 border-r border-gray-200">Phone Number</th>
                                <th class="py-2 px-4 border-r border-gray-200">Email Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($landlordsList)) :  ?>
                                <?php
                                $landlordsLimited = array_slice($landlordsList, 0, 5);
                                ?>
                                <?php foreach ($landlordsLimited as $landlord): ?>
                                    <tr class="border-b">
                                        <td class="py-2 px-4 border-r border-gray-200"><?= htmlspecialchars($landlord['first_name'] . " " . $landlord['middle_name'] . " " . $landlord['last_name']); ?></td>
                                        <td class="py-2 px-4 border-r border-gray-200">
                                            <span class="badge text-sm inline-flex items-center capitalize text-white
                                    <?= ($landlord['account_status'] == 'pending') ? 'badge-warning' : ''; ?>
                                    <?= ($landlord['account_status'] == 'verified') ? 'badge-success' : ''; ?>
                                    <?= ($landlord['account_status'] == 'declined') ? 'badge-error' : ''; ?>">
                                                <?= htmlspecialchars($landlord['account_status']); ?>
                                            </span>
                                        </td>
                                        <td class="py-2 px-4 border-r border-gray-200">
                                            <button class="btn btn-sm bg-primary text-white" onclick="document.getElementById('modal_<?= $landlord['id']; ?>').showModal()">View Business Permit</button>
                                            <dialog id="modal_<?= $landlord['id']; ?>" class="modal modal-bottom sm:modal-middle">
                                                <div class="modal-box">
                                                    <form method="dialog">
                                                        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                                                    </form>
                                                    <h3 class="text-lg font-bold mb-4"><?= htmlspecialchars($landlord['first_name'] . "'s Business Permit") ?></h3>
                                                    <?php
                                                    if ($landlord['permit']) {
                                                        echo "<img src='../landlords/Controllers/uploads/" . htmlspecialchars($landlord['permit']) . "' alt='permit' class='object-cover rounded-lg shadow-lg'>";
                                                    } else {
                                                        echo "<h1 class='text-4xl text-center p-6 text-red-500 uppercase font-bold'>No Business permit uploaded</h1>";
                                                    }
                                                    ?>
                                                </div>
                                            </dialog>
                                        </td>
                                        <td class="py-2 px-4 border-r border-gray-200 text-center"><?= htmlspecialchars($landlord['phone_number']); ?></td>
                                        <td class="py-2 px-4 border-r border-gray-200 text-center"><?= htmlspecialchars($landlord['email']); ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="5" class="text-center py-2 px-4">No landlods found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                </div>
            </div>
            <div class="bg-background border border-gray-100 shadow-md shadow-black/10 p-6 rounded-md">
                <div class="mb-4 flex justify-between items-start">
                    <div class="font-medium">Tenants</div>
                </div>
                <div class="overflow-x-auto">
                    <table class="table table-zebra bg-white">
                        <thead class="bg-slate-100">
                            <tr>
                                <th class="py-2 px-4 border-r border-gray-200">Name</th>
                                <th class="py-2 px-4 border-r border-gray-200">Status</th>
                                <th class="py-2 px-4 border-r border-gray-200">Valid ID</th>
                                <th class="py-2 px-4 border-r border-gray-200">Phone Number</th>
                                <th class="py-2 px-4 border-r border-gray-200">Email Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($tenantsList) > 0): ?>
                                <?php
                                $tenantsLimited =  array_slice($tenantsList, 0, 5);
                                ?>
                                <?php foreach ($tenantsLimited as $tenant):   ?>
                                    <tr class="border-b">
                                        <td class="py-2 px-4 border-r border-gray-200"><?= htmlspecialchars($tenant['tenant_name']); ?></td>
                                        <td class="py-2 px-4 border-r border-gray-200">
                                            <span class=" badge text-sm inline-flex items-center capitalize text-white
                                                <?php echo ($tenant['account_status'] == 'pending') ? 'badge-warning' : ''; ?>
                                                <?php echo ($tenant['account_status'] == 'verified') ? 'badge-success' : ''; ?>
                                                <?php echo ($tenant['account_status'] == 'declined') ? 'badge-error' : ''; ?>
                                                <?php echo ($tenant['account_status'] == 'banned') ? 'badge-error' : ''; ?>">
                                                <?php echo htmlspecialchars($tenant['account_status']); ?>
                                            </span>
                                        </td>
                                        <td class="py-2 px-4 border-r border-gray-200">
                                            <button class="btn btn-sm bg-primary text-white" onclick="document.getElementById('modal_<?= $tenant['id']; ?>').showModal()">View Valid ID</button>
                                            <dialog id="modal_<?= $tenant['id']; ?>" class="modal">
                                                <div class="modal-box">
                                                    <form method="dialog">
                                                        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                                                    </form>
                                                    <h3 class="text-lg font-bold"><?= htmlspecialchars($tenant['first_name'] . "'s Valid ID") ?></h3>
                                                    <?php
                                                    if ($tenant['validid']) {
                                                        echo "<img src='../tenants/Controller/uploads/" . htmlspecialchars($tenant['validid']) . "' alt='permit' class='object-cover rounded-lg shadow-lg'>";
                                                    } else {
                                                        echo "<h1 class='text-4xl text-center p-6 text-red-500 uppercase font-bold'>No Valid ID uploaded</h1>";
                                                    }
                                                    ?>

                                                </div>
                                            </dialog>
                                        </td>
                                        <td class="py-2 px-4 border-r border-gray-200 capitalize text-center"><?= htmlspecialchars($tenant['phone_number']); ?></td>
                                        <td class="py-2 px-4 border-r border-gray-200 text-center"><?= htmlspecialchars($tenant['email']); ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        No tenants found.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                </div>
            </div>
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
                                <th class="text-[12px] uppercase tracking-wide font-semibold py-3 px-4 text-left text-slate-700 rounded-tr-md">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($listingsData as $listing): ?>
                                <tr>
                                    <td class="py-2 px-4"><?= htmlspecialchars($listing['listing_name']); ?></td>
                                    <td class="py-2 px-4"><?= htmlspecialchars($listing['rent']); ?></td>
                                    <td class="py-2 px-4 capitalize"><?= htmlspecialchars($listing['property_type']); ?></td>
                                    <td class="py-2 px-4">
                                        <span class=" badge text-sm inline-flex items-center capitalize text-white
                                <?php echo ($listing['status'] == 'not occupied') ? 'badge-error' : ''; ?>
                                <?php echo ($listing['status'] == 'occupied') ? 'badge-success' : ''; ?>
                                <?php echo ($listing['status'] == 'pending') ? 'badge-warning' : ''; ?>">
                                            <?php echo htmlspecialchars($listing['status']); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
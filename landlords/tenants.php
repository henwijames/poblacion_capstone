<?php
include 'includes/header.php';
require_once '../Models/Tenants.php';
require_once '../Models/Landlords.php';

// Get the landlord ID from session or URL (if the landlord is logged in)
$landlord_id = $_SESSION['user_id'];  // Assuming the landlord is logged in and their user ID is stored in session

$database = new Database();
$db = $database->getConnection();

// Fetch tenants for this landlord
$landlords = new Landlords($db);
$tenantList = $landlords->getTenantsByLandlordId($landlord_id);  // Custom method to fetch tenants based on landlord ID
?>

<main class="main-content main">
    <?php include 'includes/topbar.php'; ?>
    <div class="p-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">Tenants</h1>
            <a href="rents.php" class="bg-primary text-white py-2 px-4 rounded-md hover:bg-accent transition-all">Rents</a>
        </div>
        <div class="mt-4 overflow-x-auto">
            <table class="w-full border border-gray-200 rounded-md">
                <thead class="bg-gray-50">
                    <tr class="bg-slate-100">
                        <th class="py-2 px-4 border-r border-gray-200">Full Name</th>
                        <th class="py-2 px-4 border-r border-gray-200">House Name</th>
                        <th class="py-2 px-4 border-r border-gray-200">Address</th>
                        <th class="py-2 px-4 border-r border-gray-200">Phone Number</th>
                        <th class="py-2 px-4 border-r border-gray-200">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($tenantList)) : ?>
                        <?php foreach ($tenantList as $tenant) : ?>
                            <tr class="border-b">
                                <td class="py-2 px-4 border-r border-gray-200"><?php echo htmlspecialchars($tenant['tenants_name']); ?></td>
                                <td class="py-2 px-4 border-r border-gray-200"><?php echo htmlspecialchars($tenant['listing_name']); ?></td>
                                <td class="py-2 px-4 border-r border-gray-200"><?php echo htmlspecialchars($tenant['address']); ?></td>
                                <td class="py-2 px-4 border-r border-gray-200"><?php echo htmlspecialchars($tenant['phone_number']); ?></td>
                                <td class="py-2 px-4 border-r border-gray-200 text-center">
                                    <a href="tenants-profile?id=<?php echo $tenant['id']; ?>" class="btn btn-info btn-sm text-sm text-white">Profile</a>
                                    <a href="tenants-complaint?id=<?php echo $tenant['id']; ?>" class="btn btn-info btn-sm text-sm text-white">Complaints</a>
                                    <a href="tenant-transaction.php?id=<?php echo $tenant['id']; ?>" class="btn bg-primary btn-sm text-white">View Transactions</a>
                                    <a href="delete-tenant.php?id=<?php echo $tenant['id']; ?>" class="btn btn-warning btn-sm text-white">Block</a>
                                </td>
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
</main>

<?php include 'includes/footer.php'; ?>
<?php
include 'includes/header.php';

$database = new Database();
$db = $database->getConnection();

// Get tenant_id from GET parameter
$tenant_id = $_GET['id'] ?? null; // Default to null if not provided
$landlord_id = $_SESSION['user_id'];

if (!$tenant_id) {
    echo "Tenant ID is required.";
    exit();
}

// Prepare the SQL query to get tenant details and listing_name
$query = "
    SELECT 
        r.listing_id,
        l.listing_name,
        l.rent,
        t.id AS tenant_user_id
    FROM rent r
    JOIN listings l ON r.listing_id = l.id
    JOIN tenants t ON r.user_id = t.id
    WHERE r.user_id = :tenant_id;
";

$stmt = $db->prepare($query);
$stmt->bindParam(':tenant_id', $tenant_id, PDO::PARAM_INT);
$stmt->execute();

// Fetch results
$tenantList = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="main-content main">
    <?php include 'includes/topbar.php'; ?>
    <div class="p-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">Tenant Rents</h1>
            <a href="rents.php" class="bg-primary text-white py-2 px-4 rounded-md hover:bg-accent transition-all">Rents</a>
        </div>
        <div class="mt-4 overflow-x-auto">
            <table class="w-full border border-gray-200 rounded-md">
                <thead class="bg-gray-50">
                    <tr class="bg-slate-100">
                        <th class="py-2 px-4 border-r border-gray-200">Listing Name</th>
                        <th class="py-2 px-4 border-r border-gray-200">Rent Price</th>
                        <th class="py-2 px-4 border-r border-gray-200">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($tenantList)) : ?>
                        <?php foreach ($tenantList as $tenant) : ?>
                            <tr class="border-b">
                                <td class="py-2 px-4 border-r border-gray-200"><?php echo htmlspecialchars($tenant['listing_name']); ?></td>
                                <td class="py-2 px-4 border-r border-gray-200">₱<?php echo htmlspecialchars($tenant['rent']); ?></td>
                                <td class="py-2 px-4 border-r border-gray-200 text-center">
                                    <a href="tenants-profile?id=<?php echo $tenant['tenant_user_id']; ?>" class="btn btn-info btn-sm text-sm text-white">Profile</a>
                                    <a href="tenants-complaint?id=<?php echo $tenant['tenant_user_id']; ?>" class="btn btn-success btn-sm text-sm text-white">Complaints</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="text-center py-2 px-4">No listings found for this tenant and landlord.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
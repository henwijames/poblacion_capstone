<?php
include 'includes/header.php';
require_once '../Models/Complaints.php';
require_once '../Models/Tenants.php';

// Get tenant ID from the URL
$tenant_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$tenant_id) {
    die("Invalid tenant ID.");
}

$database = new Database();
$db = $database->getConnection();

// Fetch tenant details
$tenants = new Tenants($db);
$tenant = $tenants->findById($tenant_id);
if (!$tenant) {
    die("Tenant not found.");
}

// Fetch complaints for this tenant
$complaints = new Complaints($db);
$complaintList = $complaints->getComplaintsByTenant($tenant_id);
?>

<main class="main-content main">
    <?php include 'includes/topbar.php'; ?>

    <div class="p-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">Complaints for <?php echo htmlspecialchars($tenant['first_name'] . " " . $tenant['last_name']); ?></h1>
            <a href="tenants" class="btn btn-sm bg-primary text-white">Back</a>
        </div>

        <div class="mt-6 space-y-6">
            <?php if (!empty($complaintList)) : ?>
                <?php foreach ($complaintList as $complaint) : ?>
                    <div class="bg-white p-4 rounded-lg shadow-md border border-gray-200">
                        <div class="flex items-center mb-4">
                            <div class="mr-4">
                                <img
                                    src="<?php echo htmlspecialchars($tenant['profile_picture'] ? '../tenants/Controller/uploads/' . $tenant['profile_picture'] : '../assets/img/me.jpg'); ?>"
                                    alt="Tenant Avatar"
                                    class="w-12 h-12 rounded-full object-contain">
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold">
                                    <?php echo htmlspecialchars($tenant['first_name'] . " " . $tenant['last_name']); ?>
                                </h2>
                                <span class="text-gray-500 text-sm">
                                    <?php echo htmlspecialchars($complaint['created_at']); ?>
                                </span>
                            </div>
                        </div>
                        <p class="text-gray-700">
                            <?php echo nl2br(htmlspecialchars($complaint['message'])); ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p class="text-center text-gray-500">No complaints have been submitted by this tenant.</p>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
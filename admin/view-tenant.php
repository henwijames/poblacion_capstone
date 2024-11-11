<?php
include 'includes/header.php';

$database = new Database();
$db = $database->getConnection();
$tenants = new Tenants($db);

$tenantId = $_GET['id'] ?? null;

if ($tenantId) {
    $tenant = $tenants->findById($tenantId);
} else {
    die('Tenant ID not specified');
}
?>
<main class="main-content main">
    <?php include 'includes/topbar.php'; ?>
    <div class="p-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Profile</h1>
            <a href="landlords" class="bg-primary text-white py-2 px-4 rounded-md hover:bg-accent transition-all">Back</a>
        </div>
        <section class="w-full overflow-hidden bg-background">
            <div class="flex flex-col">
                <!-- Cover Image -->
                <img src="../assets/img/volcano.jpg" alt="User Cover"
                    class="w-full h-auto max-h-[10rem] object-cover" />

                <!-- Profile Image and Name -->
                <div class="sm:w-[80%] xs:w-[90%] mx-auto flex flex-col items-center -mt-16">
                    <img src="<?php echo !empty($tenant['profile_picture']) ? '../tenants/Controller/uploads/' . htmlspecialchars($tenant['profile_picture']) : '../assets/img/me.jpg'; ?>" alt="User Profile"
                        class="rounded-full w-28 h-28 sm:w-32 sm:h-32 lg:w-48 lg:h-48 relative object-cover" />

                    <h1 class="w-full text-center  md:my-2 my-6 text-primary font-bold text-2xl sm:text-3xl lg:text-4xl">
                        <div class="flex flex-col sm:flex-row justify-center items-center gap-4 my-6">
                            <h1 class="text-center text-primary text-2xl sm:text-3xl lg:text-4xl">
                                <?php echo htmlspecialchars($tenant['first_name']) . " " . htmlspecialchars($tenant['middle_name']) . " " . htmlspecialchars($tenant['last_name']) ?>
                            </h1>

                            <span class=" badge text-sm inline-flex items-center capitalize text-white
                                <?php echo ($tenant['account_status'] == 'pending') ? 'badge-warning' : ''; ?>
                                <?php echo ($tenant['account_status'] == 'verified') ? 'badge-success' : ''; ?>
                                <?php echo ($tenant['account_status'] == 'not verified') ? 'badge-error' : ''; ?>">
                                <?php echo htmlspecialchars($tenant['account_status']); ?>
                            </span>
                        </div>
                    </h1>
                </div>

                <!-- Details Section -->
                <div class="w-full px-4 md:px-6 lg:px-0 xl:w-[80%] lg:w-[90%] mx-auto flex flex-col gap-4 items-center relative -mt-4">

                    <!-- Detail -->
                    <div class="w-full my-auto py-6 flex flex-col md:flex-row gap-4 justify-center">
                        <div class="w-full">
                            <dl class="text-gray-900 divide-y divide-gray-200  ">
                                <div class="flex flex-col pb-3">
                                    <dt class="mb-1 text-gray-500 text-md md:text-lg dark:text-gray-400">First Name</dt>
                                    <dd class="text-lg font-semibold"><?php echo htmlspecialchars($tenant['first_name']); ?></dd>
                                </div>
                                <div class="flex flex-col pb-3">
                                    <dt class="mb-1 text-gray-500 text-md md:text-lg dark:text-gray-400">Middle Name</dt>
                                    <dd class="text-lg font-semibold"><?php echo htmlspecialchars($tenant["middle_name"]); ?></dd>
                                </div>
                                <div class="flex flex-col py-3">
                                    <dt class="mb-1 text-gray-500 text-md md:text-lg dark:text-gray-400">Last Name</dt>
                                    <dd class="text-lg font-semibold"><?php echo htmlspecialchars($tenant['last_name']); ?></dd>
                                </div>
                            </dl>
                        </div>
                        <div class="w-full">
                            <dl class="text-gray-900 divide-y divide-gray-200 ">
                                <div class="flex flex-col pb-3">
                                    <dt class="mb-1 text-gray-500 text-md md:text-lg dark:text-gray-400">Address</dt>
                                    <dd class="text-lg font-semibold"><?php echo htmlspecialchars($tenant["address"]) ?></dd>
                                </div>
                                <div class="flex flex-col pt-3">
                                    <dt class="mb-1 text-gray-500 text-md md:text-lg dark:text-gray-400">Phone Number</dt>
                                    <div class="flex items-center gap-2">
                                        <dd class="text-lg font-semibold"><?php echo htmlspecialchars($tenant["phone_number"]); ?></dd>
                                        <span class="badge text-sm inline-flex items-center capitalize text-white
                                            <?php echo ($tenant['mobile_verified'] == '1') ? 'badge-success' : ''; ?>
                                            <?php echo ($tenant['mobile_verified'] == '0') ? 'badge-error' : ''; ?>">
                                            <?php echo (!$tenant['mobile_verified'] == '1') ? 'Not verified' : 'Verified'; ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex flex-col pt-3">
                                    <dt class="mb-1 text-gray-500 text-md md:text-lg dark:text-gray-400">Email</dt>
                                    <div class="flex items-center gap-2">

                                        <dd class="text-lg font-semibold"><?php echo htmlspecialchars($tenant["email"]); ?></dd>
                                        <span class="badge text-sm inline-flex items-center capitalize text-white
                                            <?php echo ($tenant['email_verified'] == '1') ? 'badge-success' : ''; ?>
                                            <?php echo ($tenant['email_verified'] == '0') ? 'badge-error' : ''; ?>">
                                            <?php echo (!$tenant['email_verified'] == '1') ? 'Not verified' : 'Verified'; ?>
                                        </span>
                                    </div>
                            </dl>
                        </div>
                    </div>
                </div>

                <!-- Edit Profile Button -->
                <div class="flex justify-center mt-4 mb-4">
                    <a href="tenants" class="bg-primary text-white py-2 px-4 rounded-md hover:bg-accent transition-all">Back</a>
                </div>
            </div>
        </section>
    </div>
</main>

<?php include 'includes/footer.php';  ?>
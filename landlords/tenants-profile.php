<?php
include 'includes/header.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    $database = new Database();
    $db = $database->getConnection();

    // Fetch tenant details
    $stmt = $db->prepare("SELECT first_name, middle_name, last_name, address, phone_number, email, profile_picture, validid
                          FROM tenants
                          WHERE id = :user_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $tenant = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($tenant) {
        // Prepare full name and profile picture path
        $fullName = $tenant['first_name'] . ' ' . $tenant['middle_name'] . ' ' . $tenant['last_name'];
        $profilePicture = $tenant['profile_picture'];
    } else {
        echo "<p>Tenant profile not found.</p>";
        exit;
    }
} else {
    echo "<p>No tenant specified.</p>";
    exit;
}
?>
<main class="main-content main">
    <?php include 'includes/topbar.php'; ?>
    <div class="p-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Tenant's Profile</h1>
            <a href="tenants" class="bg-primary text-white py-2 px-4 rounded-md hover:bg-accent transition-all">Back</a>
        </div>
        <section class="w-full overflow-hidden bg-background">
            <div class="flex flex-col">
                <!-- Cover Image -->
                <img src="../assets/img/volcano.jpg" alt="User Cover" class="w-full h-auto max-h-[20rem] object-cover" />

                <!-- Profile Image and Name -->
                <div class="sm:w-[80%] xs:w-[90%] mx-auto flex flex-col items-center -mt-16">
                    <img src="<?php echo !empty($tenant['profile_picture']) ? '../tenants/Controller/uploads/' . htmlspecialchars($tenant['profile_picture']) : '../assets/img/me.jpg'; ?>" alt="User Profile" class="rounded-full w-28 h-28 sm:w-32 sm:h-32 lg:w-48 lg:h-48 relative object-cover" />

                    <h1 class="w-full text-center md:my-2 my-6 text-primary font-bold text-2xl sm:text-3xl lg:text-4xl">
                        <?php echo htmlspecialchars($fullName); ?>
                    </h1>
                </div>

                <!-- Details Section -->
                <div class="w-full px-4 md:px-6 lg:px-0 xl:w-[80%] lg:w-[90%] mx-auto flex flex-col gap-4 items-center relative -mt-4">
                    <!-- Detail -->
                    <div class="w-full my-auto py-6 flex flex-col md:flex-row gap-4 justify-center">
                        <div class="w-full">
                            <dl class="text-gray-900 divide-y divide-gray-200">
                                <div class="flex flex-col pb-3">
                                    <dt class="mb-1 text-gray-500 text-md md:text-lg dark:text-gray-400">First Name</dt>
                                    <dd class="text-lg font-semibold"><?php echo htmlspecialchars($tenant['first_name']); ?></dd>
                                </div>
                                <div class="flex flex-col pb-3">
                                    <dt class="mb-1 text-gray-500 text-md md:text-lg dark:text-gray-400">Middle Name</dt>
                                    <dd class="text-lg font-semibold"><?php echo htmlspecialchars($tenant['middle_name']); ?></dd>
                                </div>
                                <div class="flex flex-col py-3">
                                    <dt class="mb-1 text-gray-500 text-md md:text-lg dark:text-gray-400">Last Name</dt>
                                    <dd class="text-lg font-semibold"><?php echo htmlspecialchars($tenant['last_name']); ?></dd>
                                </div>
                            </dl>
                        </div>
                        <div class="w-full">
                            <dl class="text-gray-900 divide-y divide-gray-200">
                                <div class="flex flex-col pb-3">
                                    <dt class="mb-1 text-gray-500 text-md md:text-lg dark:text-gray-400">Address</dt>
                                    <dd class="text-lg font-semibold"><?php echo htmlspecialchars($tenant['address']); ?></dd>
                                </div>
                                <div class="flex flex-col pt-3">
                                    <dt class="mb-1 text-gray-500 text-md md:text-lg dark:text-gray-400">Phone Number</dt>
                                    <dd class="text-lg font-semibold"><?php echo htmlspecialchars($tenant['phone_number']); ?></dd>
                                </div>
                                <div class="flex flex-col pt-3">
                                    <dt class="mb-1 text-gray-500 text-md md:text-lg dark:text-gray-400">Email</dt>
                                    <dd class="text-lg font-semibold"><?php echo htmlspecialchars($tenant['email']); ?></dd>
                                </div>
                            </dl>
                        </div>

                    </div>
                </div>
            </div>
            <div class="flex justify-center gap-2 py-2">
                <button class="btn bg-primary text-white" onclick="modal_1.showModal()">View Valid ID</button>
                <dialog id="modal_1" class="modal">
                    <div class="modal-box">
                        <form method="dialog">
                            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                        </form>
                        <h3 class="text-lg font-bold"><?= htmlspecialchars($tenant['first_name'] . "'s Valid ID") ?></h3>
                        <?php
                        if ($tenant['validid']) {
                            echo "<img src='../tenants/Controller/uploads/" . htmlspecialchars($tenant['validid']) . "' alt='Valid ID' class='object-cover rounded-lg shadow-lg'>";
                        } else {
                            echo "<h1 class='text-4xl text-center p-6 text-red-500 uppercase font-bold'>No Valid ID uploaded</h1>";
                        }
                        ?>

                    </div>
                </dialog>
            </div>
        </section>


    </div>
</main>
<?php include 'includes/footer.php'; ?>
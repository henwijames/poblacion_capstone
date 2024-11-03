<?php
include 'includes/header.php';
$database = new Database();
$db = $database->getConnection();
$landlords = new Landlords($db);
$listing = new Listing($db);

$landlordListings = $listing->getAllApartmentListings();

$landlordId  = $_GET['id'] ?? null;

if ($landlordId) {
    // Fetch landlord details using the ID
    $landlordDetails = $landlords->findById($landlordId);
} else {
    // Handle the case where ID is not provided
    die('Landlord ID not specified.');
}


$landlordFullName = $landlordDetails['first_name'] . ' ' . $landlordDetails['last_name'];

?>

<div class="flex flex-col">
    <main class="">
        <div class="flex flex-col">
            <!-- Cover Image -->
            <img src="../assets/img/volcano.jpg" alt="User Cover"
                class="w-full h-auto max-h-[20rem] object-cover" />

            <!-- Profile Image and Name -->
            <div class="sm:w-[80%] xs:w-[90%] mx-auto flex flex-col items-center -mt-16">
                <img src="<?php echo !empty($landlordDetails['profile_picture']) ? '../landlords/Controllers/' . htmlspecialchars($landlordDetails['profile_picture']) : '../assets/img/me.jpg'; ?>" alt="User Profile"
                    class="rounded-full w-28 h-28 sm:w-32 sm:h-32 lg:w-48 lg:h-48 outline outline-2 outline-offset-2 relative" />
                <div class="flex flex-col sm:flex-row justify-center items-center gap-4 my-6">
                    <h1 class="text-center text-primary text-2xl sm:text-3xl lg:text-4xl">
                        <?php echo $landlordFullName; ?>
                    </h1>
                    <span class="badge text-sm inline-flex items-center capitalize text-white 
                    <?php echo ($landlordDetails['account_status'] === 'pending') ? 'badge-warning' : ''; ?>
                    <?php echo ($landlordDetails['account_status'] === 'verified') ? 'badge-success' : ''; ?>
                    <?php echo ($landlordDetails['account_status'] === 'not verified') ? 'badge-error' : ''; ?>">
                        <?php echo htmlspecialchars($landlordDetails['account_status']); ?>
                    </span>
                </div>



            </div>

            <!-- Details Section -->
            <div class="w-full px-4 md:px-6 lg:px-0 xl:w-[80%] lg:w-[90%] mx-auto flex flex-col gap-4 items-center relative -mt-6">
                <!-- Detail -->
                <div class="w-full my-auto py-6 flex flex-col md:flex-row gap-4 justify-center">
                    <div class="w-full">
                        <dl class="text-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                            <div class="flex flex-col pb-3">
                                <dt class="mb-1 text-gray-500 text-md md:text-lg dark:text-gray-400">First Name</dt>
                                <dd class="text-lg font-semibold"><?php echo htmlspecialchars($landlordDetails['first_name']); ?></dd>
                            </div>
                            <div class="flex flex-col py-3">
                                <dt class="mb-1 text-gray-500 text-md md:text-lg dark:text-gray-400">Middle Name</dt>
                                <dd class="text-lg font-semibold"><?php echo htmlspecialchars($landlordDetails["middle_name"]); ?></dd>
                            </div>
                            <div class="flex flex-col py-3">
                                <dt class="mb-1 text-gray-500 text-md md:text-lg dark:text-gray-400">Last Name</dt>
                                <dd class="text-lg font-semibold"><?php echo htmlspecialchars($landlordDetails["last_name"]); ?></dd>
                            </div>
                        </dl>
                    </div>
                    <div class="w-full">
                        <dl class="text-gray-900 divide-y divide-gray-200  dark:divide-gray-700">
                            <div class="flex flex-col pb-3">
                                <dt class="mb-1 text-gray-500 text-md md:text-lg dark:text-gray-400">Address</dt>
                                <dd class="text-lg font-semibold"><?php echo htmlspecialchars($landlordDetails["address"]); ?></dd>
                            </div>
                            <div class="flex flex-col pt-3">
                                <dt class="mb-1 text-gray-500 text-md md:text-lg dark:text-gray-400">Phone Number</dt>
                                <dd class="text-lg font-semibold"><?php echo htmlspecialchars($landlordDetails["phone_number"]); ?></dd>
                            </div>
                            <div class="flex flex-col pt-3">
                                <dt class="mb-1 text-gray-500 text-md md:text-lg dark:text-gray-400">Email</dt>
                                <dd class="text-lg font-semibold"><?php echo htmlspecialchars($landlordDetails["email"]); ?></dd>
                            </div>
                        </dl>
                    </div>
                </div>
                <div class="flex justify-center gap-2 py-4">
                    <a href="landlord-properties.php?id=<?php echo $landlordDetails['id']; ?>"
                        class="bg-primary text-white py-2 px-4 rounded-md hover:bg-accent transition-all">
                        View Listings
                    </a>
                    <a href="landlord"
                        class="bg-primary text-white py-2 px-4 rounded-md hover:bg-accent transition-all">
                        Back
                    </a>
                </div>
            </div>
        </div>
    </main>
</div>



<?php include 'includes/footer.php'; ?>
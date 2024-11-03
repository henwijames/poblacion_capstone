<?php
include 'includes/header.php';
$database = new Database();
$db = $database->getConnection();
$listing = new Listing($db);
$landlords = new Landlords($db);

$landlordListings = $listing->getAllApartmentListings();
$allLandlords = $landlords->getAllLandlords();

$user_id = $_SESSION['user_id'];
$userListings = $listing->getListingsByUser($user_id);
?>


<div class="flex flex-col">
    <main class="flex-1 mx-auto py-8 px-6 md:px-8 lg:px-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <?php if (!empty($allLandlords)): ?>
            <?php foreach ($allLandlords as $landlord): ?>
                <div class="flex items-center justify-center">
                    <div class="w-64 rounded-lg border-2 border-primary bg-transparent p-4 text-center shadow-lg ">
                        <figure class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-secondary dark:bg-primary">

                            <img
                                src="<?php echo !empty($landlord['profile_picture']) ? '../landlords/Controllers/' . htmlspecialchars($landlord['profile_picture']) : '../assets/img/me.jpg'; ?>"
                                alt="Profile Picture"
                                class="h-16 w-16 rounded-full object-cover" />

                            <figcaption class="sr-only"><?php echo htmlspecialchars($landlord['first_name']); ?></figcaption>
                        </figure>
                        <h2 class="mt-4 text-xl font-bold text-primary"><?php echo htmlspecialchars($landlord['first_name']); ?></h2>
                        <p class="mb-4 text-gray-600 dark:text-gray-300"><?php echo htmlspecialchars($landlord['property_name']); ?></p>
                        <div class="flex items-center justify-center">
                            <a href="contact-landlord.php?id=<?php echo $landlord['id']; ?>" class="btn bg-primary">Contact</a>
                            <a href="landlord-properties.php?id=<?php echo $landlord['id']; ?>" class="ml-4 btn">Properties</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center text-gray-600 dark:text-gray-300">No landlords found.</p>
        <?php endif; ?>
    </main>
</div>



<?php include 'includes/footer.php'; ?>
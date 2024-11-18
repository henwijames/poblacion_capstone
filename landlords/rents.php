<?php
include 'includes/header.php';
include '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$landlord_id = $_SESSION['user_id']; // Assuming landlord_id is stored in the session

$database = new Database();
$db = $database->getConnection();

// Query to fetch rents for the landlord
$query = "
    SELECT 
        rent.*, 
        CONCAT(tenants.first_name, ' ', tenants.middle_name, ' ', tenants.last_name) AS tenant_name,
        tenants.email AS tenant_email,
        listings.listing_name, 
        listings.address,
        listings.rent
    FROM rent
    JOIN listings ON rent.listing_id = listings.id
    JOIN tenants ON rent.user_id = tenants.id
    WHERE listings.user_id = :landlord_id
";
$stmt = $db->prepare($query);
$stmt->bindParam(':landlord_id', $landlord_id, PDO::PARAM_INT);
$stmt->execute();
$rents = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<main class="main-content main">
    <?php include 'includes/topbar.php'; ?>

    <div class="p-6">
        <h2 class="text-2xl font-semibold mb-6">Rents</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if (!empty($rents)) : ?>
                <?php foreach ($rents as $rent) :
                    $daysToDue = (new DateTime($rent['due_month']))->diff(new DateTime())->days;
                ?>
                    <div class="bg-white shadow-md rounded-lg p-6">
                        <h3 class="text-lg font-semibold"><?php echo htmlspecialchars($rent['listing_name']); ?></h3>
                        <p class="text-gray-500"><?php echo htmlspecialchars($rent['address']); ?></p>
                        <p class="text-gray-600">Tenant: <span class="font-bold"><?php echo htmlspecialchars($rent['tenant_name']); ?></span></p>
                        <p class="text-gray-600">Rent Amount: <span class="font-bold"><?php echo htmlspecialchars($rent['rent']); ?></span></p>
                        <p class="text-gray-600">Due Date: <span class="font-bold"><?php echo date('F j, Y', strtotime($rent['due_month'])); ?></span></p>
                        <p class="text-gray-600">Days to Due Date: <span class="font-bold"><?php echo $daysToDue; ?></span></p>
                        <p class="text-gray-600">Status:
                            <span class="font-bold capitalize <?php echo $rent['rent_status'] === 'verified' ? 'text-green-500' : 'text-red-500'; ?>">
                                <?php echo htmlspecialchars($rent['rent_status']); ?>
                            </span>
                        </p>

                        <?php if ($daysToDue <= 9) : ?>
                            <form method="POST" action="notify_tenant.php">
                                <input type="hidden" name="tenant_email" value="<?php echo htmlspecialchars($rent['tenant_email']); ?>">
                                <input type="hidden" name="tenant_name" value="<?php echo htmlspecialchars($rent['tenant_name']); ?>">
                                <input type="hidden" name="listing_name" value="<?php echo htmlspecialchars($rent['listing_name']); ?>">
                                <button type="submit" class="btn bg-primary text-white w-full mt-4">Notify Tenant</button>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p class="text-center font-bold text-xl col-span-full">No rents found for your properties.</p>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
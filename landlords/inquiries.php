<?php
include 'includes/header.php';

$database = new Database();
$db = $database->getConnection();
$listing = new Listing($db);
$landlords = new Landlords($db);

// Get landlord ID from session
$landlord_id = $_SESSION['user_id'];

// Fetch bookings for the landlord
$stmt = $db->prepare("SELECT bookings.*, 
                             CONCAT(tenants.first_name, ' ', tenants.middle_name, ' ', tenants.last_name) AS tenant_name 
                      FROM bookings 
                      JOIN tenants ON bookings.user_id = tenants.id 
                      WHERE bookings.landlord_id = :landlord_id");

$stmt->bindParam(':landlord_id', $landlord_id, PDO::PARAM_INT);
$stmt->execute();
$inquiries = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<main class="main-content main">
    <?php include 'includes/topbar.php'; ?>
    <div class="p-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">Inquiries</h1>
        </div>

        <div class="mt-4 overflow-x-auto">
            <table class="table table-zebra">
                <thead class="bg-gray-50">
                    <tr class="text-left">
                        <th class="px-6 py-3 border-b">Name</th>
                        <th class="px-6 py-3 border-b">Check-In</th>
                        <th class="px-6 py-3 border-b">Total Amount</th>
                        <th class="px-6 py-3 border-b">Status</th>
                        <th class="px-6 py-3 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($inquiries)): ?>
                        <?php foreach ($inquiries as $inquiry): ?>
                            <tr>
                                <td class="px-6 py-3 border-b"><?php echo htmlspecialchars($inquiry['tenant_name']); ?></td>
                                <td class="px-6 py-3 border-b"><?php echo htmlspecialchars($inquiry['check_in']); ?></td>
                                <td class="px-6 py-3 border-b"><?php echo htmlspecialchars(number_format($inquiry['total_amount'], 2)); ?></td>
                                <td class="px-6 py-3 border-b">Pending</td>
                                <td class="px-6 py-3 border-b">
                                    <a href="tenants-profile?id=<?php echo $inquiry['user_id']; ?>" class="btn btn-info btn-sm text-sm text-white">Profile</a>
                                    <a href="approve.php?id=<?php echo $inquiry['id']; ?>" class="btn btn-sm text-sm bg-primary text-white">Approve</a>
                                    <a href="reject.php?id=<?php echo $inquiry['id']; ?>" class="btn btn-sm text-sm btn-error text-white">Reject</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr colspan="6" class="mt-4 text-3xl text-center text-gray-500 font-semibold">
                            <td colspan="6" class="py-4 text-center">No inquiries.</td>
                        </tr>

                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

</main>
<?php include 'includes/footer.php'; ?>
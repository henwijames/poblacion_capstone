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
    <div id="loader" class="hidden fixed inset-0 flex items-center justify-center bg-background bg-opacity-75 z-50">
        <span class="loading loading-dots loading-lg"></span>
    </div>
    <?php include 'includes/topbar.php'; ?>
    <div class="p-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">Inquiries</h1>
        </div>

        <div class="mt-4 overflow-x-auto">
            <table class="table table-zebra">
                <thead class="bg-gray-50">
                    <tr class="text-left">
                        <th class="px-6 py-3 border-b">Tenant Name</th>
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
                                <td class="px-6 py-3 border-b capitalize"><?php echo htmlspecialchars($inquiry['booking_status']) ?></td>
                                <td class="px-6 py-3 border-b">
                                    <a href="tenants-profile?id=<?php echo $inquiry['user_id']; ?>" class="btn btn-info btn-sm text-sm text-white">Profile</a>
                                    <?php
                                    if ($inquiry['booking_status'] !== 'verified') {
                                        echo '<button id="verifyButton_' . $inquiry['id'] . '" onclick="verifyInquiry(' . $inquiry['id'] . ')" class="btn btn-sm bg-primary text-white">Verify</button>';
                                        echo '<button id="declineButton_' . $inquiry['id'] . '" onclick="declineInquiry(' . $inquiry['id'] . ')" class="btn btn-sm btn-error text-white">Decline</button>';
                                    } else {
                                        echo '<button onclick="blockTenant(' . $inquiry['user_id'] . ')" class="btn btn-sm btn-warning text-white">Block</button>';
                                    }
                                    ?>
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
<script>
    function verifyInquiry(inquiryId) {
        const verifyButton = document.querySelector(`#verifyButton_${inquiryId}`);
        verifyButton.disabled = true;
        Swal.fire({
            title: "Are you sure?",
            text: "Do you want to verify this inquiry?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#C1C549",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, verify it!"
        }).then((result => {
            if (result.isConfirmed) {
                document.getElementById('loader').classList.remove('hidden');
                // Send AJAX request to verify account
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "Controllers/verifyInquiry.php?id=" + inquiryId, true);
                xhr.onload = function() {
                    document.getElementById('loader').classList.add('hidden');
                    if (xhr.status === 200) {
                        try {
                            var response = JSON.parse(xhr.responseText);
                            if (response.status === "success") {
                                Swal.fire(
                                    "Verified!",
                                    response.message,
                                    "success"
                                ).then(() => {
                                    window.location.href = "inquiries.php"; // Adjust the URL if needed
                                });
                            } else {
                                Swal.fire("Error", response.message, "error");
                            }
                        } catch (e) {
                            console.error("Error parsing JSON:", e);
                            console.log("Server Response:", xhr.responseText); // Log the invalid response for debugging
                            Swal.fire("Error", "Failed to parse the response from the server.", "error");
                        }
                    } else {
                        console.error("Request failed with status", xhr.status);
                        Swal.fire("Error", "Failed to send verification request.", "error");
                    }
                };
                xhr.send();
            } else {
                verifyButton.disabled = false;
            }
        }))
    }
</script>
<?php include 'includes/footer.php'; ?>
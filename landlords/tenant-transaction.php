<?php
include 'includes/header.php';

$database = new Database();
$db = $database->getConnection();

// Get tenant_id from GET parameter
$tenant_id = $_GET['id'] ?? null; // If id is not set in GET, use null
$landlord_id =  $_SESSION['user_id'];

if (!$tenant_id) {
    echo "Tenant ID is required.";
    exit();
}

$landlords = new Landlords($db);

// Fetch tenant transactions based on tenant_id from GET
$tenantTransactions = $landlords->getTransactionsByTenantId($tenant_id, $landlord_id);

?>

<main class="main-content main">
    <?php include 'includes/topbar.php'; ?>
    <div class="p-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">Tenant Transactions</h1>
        </div>
        <div class="mt-4">
            <table class="w-full border border-gray-200 rounded-md">
                <thead class="bg-gray-50">
                    <tr class="bg-slate-100">
                        <th class="py-2 px-4 border-r border-gray-200">House Name</th>
                        <th class="py-2 px-4 border-r border-gray-200">Amount</th>
                        <th class="py-2 px-4 border-r border-gray-200">Reference Number</th>
                        <th class="py-2 px-4 border-r border-gray-200">Transaction Date</th>
                        <th class="py-2 px-4 border-r border-gray-200">Status</th>
                        <th class="py-2 px-4 border-r border-gray-200">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($tenantTransactions)): ?>
                        <tr class="border-b">
                            <td colspan="5" class="py-2 px-4 text-center">No transactions found</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($tenantTransactions as $transaction): ?>
                            <tr class="border-b">
                                <td class="py-2 px-4 border-r border-gray-200"><?php echo htmlspecialchars($transaction['listing_name']); ?></td>
                                <td class="py-2 px-4 border-r border-gray-200"><?php echo htmlspecialchars($transaction['amount']); ?></td>
                                <td class="py-2 px-4 border-r border-gray-200"><?php echo htmlspecialchars($transaction['reference_number']); ?></td>
                                <td class="py-2 px-4 border-r border-gray-200"><?php echo date('F j, Y', strtotime($transaction['transaction_date'])); ?></td>
                                <td class="py-2 px-4 border-r border-gray-200"><?php echo htmlspecialchars($transaction['transaction_status']); ?></td>
                                <td class="py-2 px-4 border-r border-gray-200 text-center">
                                    <?php if ($transaction['transaction_status'] === 'pending'): ?>
                                        <button
                                            class="btn bg-primary btn-sm text-white"
                                            onclick="confirmAction('verify', <?php echo $transaction['transaction_id']; ?>)">
                                            Verify
                                        </button>
                                        <button
                                            class="btn btn-error btn-sm text-white"
                                            onclick="confirmAction('decline', <?php echo $transaction['transaction_id']; ?>)">
                                            Decline
                                        </button>
                                    <?php else: ?>
                                        <span class="text-gray-500">No actions available</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
<script>
    function confirmAction(action, transactionId) {
        const actionText = action === 'verify' ? 'Verify' : 'Decline';
        const actionColor = action === 'verify' ? '#4CAF50' : '#F44336'; // Green for Verify, Red for Decline

        Swal.fire({
            title: `Are you sure you want to ${actionText.toLowerCase()} this transaction?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: actionColor,
            cancelButtonColor: '#d33',
            confirmButtonText: `Yes, ${actionText}!`
        }).then((result) => {
            if (result.isConfirmed) {
                // Create a form dynamically and submit it
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'process_transaction.php';

                const actionInput = document.createElement('input');
                actionInput.type = 'hidden';
                actionInput.name = 'action';
                actionInput.value = action;

                const idInput = document.createElement('input');
                idInput.type = 'hidden';
                idInput.name = 'transaction_id';
                idInput.value = transactionId;

                form.appendChild(actionInput);
                form.appendChild(idInput);
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>

<?php include 'includes/footer.php'; ?>
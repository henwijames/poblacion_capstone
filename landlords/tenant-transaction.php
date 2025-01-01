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
$tenantPendingTransactions = $landlords->getPendingTransactionsByTenantId($tenant_id, $landlord_id);
$tenantCompletedTransactions = $landlords->getCompletedTransactionsByTenantId($tenant_id, $landlord_id);
$tenantDeclinedTransactions = $landlords->getDeclinedTransactionsByTenantId($tenant_id, $landlord_id);

?>

<main class="main-content main">
    <?php include 'includes/topbar.php'; ?>
    <div class="p-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">Tenant Transactions</h1>
            <a href="tenants" class="btn btn-sm bg-primary text-white">Back</a>
        </div>

        <div role="tablist" class="tabs tabs-lifted mt-4 overflow-x-auto">
            <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="Pending" checked="checked" />
            <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">
                <div class="mt-4 overflow-x-auto">
                    <table class="w-full border border-gray-200 rounded-md">
                        <thead class="bg-gray-50">
                            <tr class="bg-slate-100">
                                <th class="py-2 px-4 border-r border-gray-200">House Name</th>
                                <th class="py-2 px-4 border-r border-gray-200">Amount</th>
                                <th class="py-2 px-4 border-r border-gray-200">Transaction Screenshot</th>
                                <th class="py-2 px-4 border-r border-gray-200">Transaction Date</th>
                                <th class="py-2 px-4 border-r border-gray-200">Status</th>
                                <th class="py-2 px-4 border-r border-gray-200">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($tenantPendingTransactions)): ?>
                                <tr class="border-b">
                                    <td colspan="5" class="py-2 px-4 text-center">No transactions found</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($tenantPendingTransactions as $transaction): ?>
                                    <tr class="border-b">
                                        <td class="py-2 px-4 border-r border-gray-200"><?php echo htmlspecialchars($transaction['listing_name']); ?></td>
                                        <td class="py-2 px-4 border-r border-gray-200"><?php echo htmlspecialchars($transaction['amount']); ?></td>
                                        <td class="py-2 px-4 border-r border-gray-200 text-center">
                                            <button class="btn bg-primary text-white" onclick="document.getElementById('modal_<?= $transaction['screenshot']; ?>').showModal()">View Valid ID</button>
                                            <dialog id="modal_<?= $transaction['screenshot']; ?>" class="modal">
                                                <div class="modal-box">
                                                    <form method="dialog">
                                                        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                                                    </form>
                                                    <?php
                                                    if ($transaction['screenshot']) {
                                                        echo "<img src='../tenants/Controller/uploads/" . htmlspecialchars($transaction['screenshot']) . "' alt='transaction screenshot' class='object-cover rounded-lg shadow-lg'>";
                                                    } else {
                                                        echo "<h1 class='text-4xl text-center p-6 text-red-500 uppercase font-bold'>No Valid ID uploaded</h1>";
                                                    }
                                                    ?>

                                                </div>
                                            </dialog>
                                        </td>
                                        <td class="py-2 px-4 border-r border-gray-200"><?php echo date('F j, Y', strtotime($transaction['transaction_date'])); ?></td>
                                        <td class="py-2 px-4 border-r border-gray-200 capitalize"><?php echo htmlspecialchars($transaction['transaction_status']); ?></td>
                                        <td class="py-2 px-4 border-r border-gray-200 text-center">
                                            <?php if ($transaction['transaction_status'] === 'pending'): ?>
                                                <button
                                                    class="btn bg-primary btn-sm text-white"
                                                    onclick="confirmAction('verify', <?php echo $transaction['transaction_id']; ?>)">
                                                    Verify
                                                </button>
                                                <button
                                                    class="btn btn-error btn-sm text-white"
                                                    onclick="confirmAction('declined', <?php echo $transaction['transaction_id']; ?>)">
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

            <input
                type="radio"
                name="my_tabs_2"
                role="tab"
                class="tab "
                aria-label="Completed" />
            <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">
                <div class="mt-4 overflow-x-auto">
                    <table class="w-full border border-gray-200 rounded-md">
                        <thead class="bg-gray-50">
                            <tr class="bg-slate-100">
                                <th class="py-2 px-4 border-r border-gray-200">House Name</th>
                                <th class="py-2 px-4 border-r border-gray-200">Amount</th>
                                <th class="py-2 px-4 border-r border-gray-200">Transaction Screenshot</th>
                                <th class="py-2 px-4 border-r border-gray-200">Transaction Date</th>
                                <th class="py-2 px-4 border-r border-gray-200">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($tenantCompletedTransactions)): ?>
                                <tr class="border-b">
                                    <td colspan="5" class="py-2 px-4 text-center">No transactions found</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($tenantCompletedTransactions as $transaction): ?>
                                    <tr class="border-b">
                                        <td class="py-2 px-4 border-r border-gray-200"><?php echo htmlspecialchars($transaction['listing_name']); ?></td>
                                        <td class="py-2 px-4 border-r border-gray-200"><?php echo htmlspecialchars($transaction['amount']); ?></td>
                                        <td class="py-2 px-4 border-r border-gray-200 text-center">
                                            <button class="btn bg-primary text-white" onclick="document.getElementById('modal_<?= $transaction['screenshot']; ?>').showModal()">View Valid ID</button>
                                            <dialog id="modal_<?= $transaction['screenshot']; ?>" class="modal">
                                                <div class="modal-box">
                                                    <form method="dialog">
                                                        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                                                    </form>
                                                    <?php
                                                    if ($transaction['screenshot']) {
                                                        echo "<img src='../tenants/Controller/uploads/" . htmlspecialchars($transaction['screenshot']) . "' alt='transaction screenshot' class='object-cover rounded-lg shadow-lg'>";
                                                    } else {
                                                        echo "<h1 class='text-4xl text-center p-6 text-red-500 uppercase font-bold'>No Valid ID uploaded</h1>";
                                                    }
                                                    ?>

                                                </div>
                                            </dialog>
                                        </td>
                                        <td class="py-2 px-4 border-r border-gray-200"><?php echo date('F j, Y', strtotime($transaction['transaction_date'])); ?></td>
                                        <td class="py-2 px-4 border-r border-gray-200 capitalize">
                                            <!-- Add DaisyUI badge based on status -->
                                            <?php if ($transaction['transaction_status'] === 'completed'): ?>
                                                <span class="badge badge-success ml-2 text-white">Completed</span>
                                            <?php endif; ?>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <input type="radio" name="my_tabs_2" role="tab " class="tab" aria-label="Declined" />
            <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">
                <div class="mt-4 overflow-x-auto">
                    <table class="w-full border border-gray-200 rounded-md">
                        <thead class="bg-gray-50">
                            <tr class="bg-slate-100">
                                <th class="py-2 px-4 border-r border-gray-200">House Name</th>
                                <th class="py-2 px-4 border-r border-gray-200">Amount</th>
                                <th class="py-2 px-4 border-r border-gray-200">Transaction Screenshot</th>
                                <th class="py-2 px-4 border-r border-gray-200">Transaction Date</th>
                                <th class="py-2 px-4 border-r border-gray-200">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($tenantDeclinedTransactions)): ?>
                                <tr class="border-b">
                                    <td colspan="5" class="py-2 px-4 text-center">No transactions found</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($tenantDeclinedTransactions as $transaction): ?>
                                    <tr class="border-b">
                                        <td class="py-2 px-4 border-r border-gray-200"><?php echo htmlspecialchars($transaction['listing_name']); ?></td>
                                        <td class="py-2 px-4 border-r border-gray-200"><?php echo htmlspecialchars($transaction['amount']); ?></td>
                                        <td class="py-2 px-4 border-r border-gray-200 text-center">
                                            <button class="btn bg-primary text-white" onclick="document.getElementById('modal_<?= $transaction['screenshot']; ?>').showModal()">View Valid ID</button>
                                            <dialog id="modal_<?= $transaction['screenshot']; ?>" class="modal">
                                                <div class="modal-box">
                                                    <form method="dialog">
                                                        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                                                    </form>
                                                    <?php
                                                    if ($transaction['screenshot']) {
                                                        echo "<img src='../tenants/Controller/uploads/" . htmlspecialchars($transaction['screenshot']) . "' alt='transaction screenshot' class='object-cover rounded-lg shadow-lg'>";
                                                    } else {
                                                        echo "<h1 class='text-4xl text-center p-6 text-red-500 uppercase font-bold'>No Valid ID uploaded</h1>";
                                                    }
                                                    ?>

                                                </div>
                                            </dialog>
                                        </td>
                                        <td class="py-2 px-4 border-r border-gray-200"><?php echo date('F j, Y', strtotime($transaction['transaction_date'])); ?></td>
                                        <td class="py-2 px-4 border-r border-gray-200 capitalize">
                                            <!-- Add DaisyUI badge based on status -->
                                            <?php if ($transaction['transaction_status'] === 'declined'): ?>
                                                <span class="badge badge-error ml-2 text-white">Declined</span>
                                            <?php endif; ?>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</main>
<script>
    function confirmAction(action, transactionId) {
        const actionText = action === 'verify' ? 'verify' : 'declined';
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
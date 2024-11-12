<?php
include '../../Controllers/Database.php';
require_once '../../Models/Tenants.php';

$database = new Database();
$db = $database->getConnection();
$tenants = new Tenants($db);

// Get the search term from the query string
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Call the function to fetch filtered landlords based on the search term
$tenantsList = $tenants->searchTenants($searchTerm);

if (count($tenantsList) > 0):
    foreach ($tenantsList as $tenant):
?>

        <tr class="border-b">
            <td class="py-2 px-4 border-r border-gray-200"><?= htmlspecialchars($tenant['first_name'] . " " . $tenant['middle_name'] . " " . $tenant['last_name']); ?></td>

            <td class="py-2 px-4 border-r border-gray-200">
                <span class="badge text-sm inline-flex items-center capitalize text-white
                    <?= ($tenant['account_status'] == 'pending') ? 'badge-warning' : ''; ?>
                    <?= ($tenant['account_status'] == 'verified') ? 'badge-success' : ''; ?>
                    <?= ($tenant['account_status'] == 'not verified') ? 'badge-error' : ''; ?>">
                    <?= htmlspecialchars($tenant['account_status']); ?>
                </span>
            </td>
            <td class="py-2 px-4 border-r border-gray-200">
                <button class="btn bg-primary text-white" onclick="document.getElementById('modal_<?= $tenant['id']; ?>').showModal()">View Valid ID</button>
                <dialog id="modal_<?= $tenant['id']; ?>" class="modal modal-bottom sm:modal-middle">
                    <div class="modal-box">
                        <form method="dialog">
                            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                        </form>
                        <h3 class="text-lg font-bold"><?= htmlspecialchars($tenant['first_name'] . "'s Valid ID") ?></h3>
                        <?php
                        if ($tenant['validid']) {
                            echo "<img src='../tenants/Controller/uploads/" . htmlspecialchars($tenant['permit']) . "' alt='permit' class='object-cover'>";
                        } else {
                            echo "<h1 class='text-4xl text-red-500'>No Business permit uploaded</h1>";
                        }
                        ?>
                    </div>
                </dialog>
            </td>
            <td class="py-2 px-4 border-r border-gray-200 capitalize text-center"><?= htmlspecialchars($tenant['phone_number']); ?></td>
            <td class="py-2 px-4 border-r border-gray-200 text-center"><?= htmlspecialchars($tenant['email']); ?></td>
            <td class="py-2 px-4 border-r border-gray-200 text-center">
                <a href="edit-listings.php?id=<?= $tenant['id'] ?>" class="btn btn-sm bg-primary text-white">Verify</a>
                <a href="view-tenant.php?id=<?= $tenant['id'] ?>" class="inline-block px-4 py-1 rounded-md text-sm bg-blue-400 text-white">View</a>
                <a href="view-listings.php?id=<?= $tenant['id'] ?>" class="btn btn-sm btn-error text-white">Decline</a>
            </td>
        </tr>
    <?php
    endforeach;
else:
    ?>
    <tr>
        <td colspan="6" class="text-center py-4">No landlords found.</td>
    </tr>
<?php
endif;
?>
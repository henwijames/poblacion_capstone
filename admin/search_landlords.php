<?php
include 'includes/header.php';

$database = new Database();
$db = $database->getConnection();
$landlords = new Landlords($db);

// Get the search term from the query string
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Call the function to fetch filtered landlords based on the search term
$landlordsList = $landlords->searchLandlords($searchTerm);

if (count($landlordsList) > 0):
    foreach ($landlordsList as $landlord):
?>
        <tr class="border-b">
            <td class="py-2 px-4 border-r border-gray-200"><?= htmlspecialchars($landlord['first_name'] . " " . $landlord['middle_name'] . " " . $landlord['last_name']); ?></td>
            <td class="py-2 px-4 border-r border-gray-200 capitalize"><?= htmlspecialchars($landlord['address']); ?></td>
            <td class="py-2 px-4 border-r border-gray-200">
                <span class="badge text-sm inline-flex items-center capitalize text-white
                    <?= ($landlord['account_status'] == 'pending') ? 'badge-warning' : ''; ?>
                    <?= ($landlord['account_status'] == 'verified') ? 'badge-success' : ''; ?>
                    <?= ($landlord['account_status'] == 'not verified') ? 'badge-error' : ''; ?>">
                    <?= htmlspecialchars($landlord['account_status']); ?>
                </span>
            </td>
            <td class="py-2 px-4 border-r border-gray-200">
                <button class="btn bg-primary text-white" onclick="document.getElementById('modal_<?= $landlord['id']; ?>').showModal()">View Valid ID</button>
                <dialog id="modal_<?= $landlord['id']; ?>" class="modal modal-bottom sm:modal-middle">
                    <div class="modal-box">
                        <form method="dialog">
                            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                        </form>
                        <h3 class="text-lg font-bold"><?= htmlspecialchars($landlord['first_name'] . "'s Valid ID") ?></h3>
                        <?php
                        if ($landlord['permit']) {
                            echo "<img src='../landlords/Controllers/uploads/" . htmlspecialchars($landlord['permit']) . "' alt='permit' class='object-cover'>";
                        } else {
                            echo "<h1 class='text-4xl text-red-500'>No Business permit uploaded</h1>";
                        }
                        ?>
                    </div>
                </dialog>
            </td>
            <td class="py-2 px-4 border-r border-gray-200 capitalize text-center"><?= htmlspecialchars($landlord['phone_number']); ?></td>
            <td class="py-2 px-4 border-r border-gray-200 text-center">
                <a href="edit-listings.php?id=<?= $landlord['id'] ?>" class="btn btn-sm bg-primary text-white">Verify</a>
                <a href="view-tenant.php?id=<?= $landlord['id'] ?>" class="inline-block px-4 py-1 rounded-md text-sm bg-blue-400 text-white">View</a>
                <a href="view-listings.php?id=<?= $landlord['id'] ?>" class="btn btn-sm btn-error text-white">Decline</a>
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
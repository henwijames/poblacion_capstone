<?php
include 'includes/header.php';

$database = new Database();
$db = $database->getConnection();
$tenants = new Tenants($db);

$tenantsList = $tenants->getAllTenants();

?>
<main class="main-content main">
    <div id="loader" class="hidden fixed inset-0 flex items-center justify-center bg-background bg-opacity-75 z-50">
        <span class="loading loading-dots loading-lg"></span>
    </div>

    <?php include "includes/topbar.php";  ?>
    <div class="p-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">Tenants</h1>
            <input type="text" id="search" class="input input-bordered" placeholder="Search Landlords...">
        </div>
        <div class="mt-4 overflow-x-auto">
            <table class="table table-zebra">
                <thead class="bg-gray-50">
                    <tr class="bg-slate-100">
                        <th class="py-2 px-4 border-r border-gray-200">Name</th>
                        <th class="py-2 px-4 border-r border-gray-200">Status</th>
                        <th class="py-2 px-4 border-r border-gray-200">Valid ID</th>
                        <th class="py-2 px-4 border-r border-gray-200">Phone Number</th>
                        <th class="py-2 px-4 border-r border-gray-200">Email Address</th>
                        <th class="py-2 px-4 border-r border-gray-200">Actions</th>
                    </tr>
                </thead>
                <tbody id="tenantsList">
                    <?php if (count($tenantsList) > 0): ?>
                        <?php foreach ($tenantsList as $tenant):   ?>
                            <tr class="border-b">
                                <td class="py-2 px-4 border-r border-gray-200"><?= htmlspecialchars($tenant['tenant_name']); ?></td>
                                <td class="py-2 px-4 border-r border-gray-200">
                                    <span class=" badge text-sm inline-flex items-center capitalize text-white
                                <?php echo ($tenant['account_status'] == 'pending') ? 'badge-warning' : ''; ?>
                                <?php echo ($tenant['account_status'] == 'verified') ? 'badge-success' : ''; ?>
                                <?php echo ($tenant['account_status'] == 'declined') ? 'badge-error' : ''; ?>
                                <?php echo ($tenant['account_status'] == 'banned') ? 'badge-error' : ''; ?>">
                                        <?php echo htmlspecialchars($tenant['account_status']); ?>
                                    </span>
                                </td>
                                <td class="py-2 px-4 border-r border-gray-200">
                                    <button class="btn bg-primary text-white" onclick="document.getElementById('modal_<?= $tenant['id']; ?>').showModal()">View Valid ID</button>
                                    <dialog id="modal_<?= $tenant['id']; ?>" class="modal">
                                        <div class="modal-box">
                                            <form method="dialog">
                                                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                                            </form>
                                            <h3 class="text-lg font-bold"><?= htmlspecialchars($tenant['first_name'] . "'s Valid ID") ?></h3>
                                            <?php
                                            if ($tenant['validid']) {
                                                echo "<img src='../tenants/Controller/uploads/" . htmlspecialchars($tenant['validid']) . "' alt='permit' class='object-cover rounded-lg shadow-lg'>";
                                            } else {
                                                echo "<h1 class='text-4xl text-center p-6 text-red-500 uppercase font-bold'>No Valid ID uploaded</h1>";
                                            }
                                            ?>

                                        </div>
                                    </dialog>
                                </td>
                                <td class="py-2 px-4 border-r border-gray-200 capitalize text-center"><?= htmlspecialchars($tenant['phone_number']); ?></td>
                                <td class="py-2 px-4 border-r border-gray-200 text-center"><?= htmlspecialchars($tenant['email']); ?></td>
                                <td class="py-2 px-4 border-r border-gray-200 text-center">
                                    <a href="view-tenant.php?id=<?= $tenant['id'] ?>" class="inline-block px-4 py-1 rounded-md text-sm bg-blue-400 text-white">View</a>
                                    <?php
                                    if ($tenant['account_status'] !== 'verified') {
                                        echo '<button onclick="verifyTenant(' . $tenant['id'] . ')" class="btn btn-sm bg-primary text-white">Verify</button>';
                                        echo '<button id="declineButton_' . $tenant['id'] . '" onclick="declineTenant(' . $tenant['id'] . ')" class="btn btn-sm btn-error text-white">Decline</button>';
                                    } else {
                                        echo '<button id="blockButton_' . $tenant['id'] . '" onclick="blockTenant(' . $tenant['id'] . ')" class="btn btn-sm btn-warning text-white">Block</button>';
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                No tenants found.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
<script>
    window.addEventListener('DOMContentLoaded', (event) => {
        document.getElementById('search').addEventListener('input', function() {
            var searchTerm = this.value;
            fetchTenants(searchTerm);
        });

        function fetchTenants(searchTerm) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'Controllers/search_tenants.php?search=' + searchTerm, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    document.getElementById('tenantsList').innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }
    });

    function verifyTenant(tenantId) {
        Swal.fire({
            title: "Are you sure?",
            text: "Do you want to verify this account?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#C1C549",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, verify it!"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('loader').classList.remove('hidden');
                // Send AJAX request to verify account
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "verifyTenants.php?id=" + tenantId, true);
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
                                    window.location.href = "tenants.php"; // Adjust the URL if needed
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
            }
        });
    }

    function declineTenant(tenantId) {
        const declineButton = document.querySelector(`#declineButton_${tenantId}`);

        declineButton.disabled = true;
        Swal.fire({
            title: "Are you sure?",
            text: "The provided documents are unclear and not authentic. Do you want to decline the application of this account? ",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#C1C549",
            cancelButtonColor: "#d33",
            confirmButtonText: "Decline"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('loader').classList.remove('hidden');
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "Controllers/declineTenants.php?id=" + tenantId, true);
                xhr.onload = function() {
                    document.getElementById('loader').classList.add('hidden');
                    if (xhr.status === 200) {
                        try {
                            var response = JSON.parse(xhr.responseText);
                            if (response.status === "success") {
                                Swal.fire(
                                    "Declined!",
                                    response.message,
                                    "success"
                                ).then(() => {
                                    window.location.href = "tenants.php"; // Adjust the URL if needed
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
                declineButton.disabled = false;
            }
        })
    }

    function blockTenant(tenantId) {
        const blockButton = document.querySelector(`#blockButton_${tenantId}`);

        blockButton.disabled = true;
        Swal.fire({
            title: "Are you sure?",
            text: "Do you want to block this account?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#C1C549",
            cancelButtonColor: "#d33",
            confirmButtonText: "Block"
        }).then((result) => {

            if (result.isConfirmed) {

                document.getElementById('loader').classList.remove('hidden');
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "Controllers/blockTenants.php?id=" + tenantId, true);
                xhr.onload = function() {
                    document.getElementById('loader').classList.add('hidden');
                    if (xhr.status === 200) {
                        try {
                            var response = JSON.parse(xhr.responseText);
                            if (response.status === "success") {
                                Swal.fire(
                                    "Banned!",
                                    response.message,
                                    "success"
                                ).then(() => {
                                    window.location.href = "tenants.php"; // Adjust the URL if needed
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
                blockButton.disabled = false;
            }
        })
    }
</script>
<?php include 'includes/footer.php';  ?>
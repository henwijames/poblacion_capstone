<!DOCTYPE html>
<?php
session_start();
include 'session.php';
include '../Controllers/Database.php';
include '../Models/Listing.php';
include '../Models/Landlords.php';

$user_id = $_SESSION['user_id'];
$defaultProfilePicture = "../assets/img/me.jpg"; //Default profile picture

if (isset($_SESSION['user_id']) && isset($_SESSION['user_role'])) {
    require_once '../Models/Tenants.php';
    require_once '../Models/Landlords.php';


    $database = new Database();
    $db = $database->getConnection();

    if ($_SESSION['user_role'] == 'tenant') {
        $tenants = new Tenants($db);
        $tenant = $tenants->findById($_SESSION['user_id']);
        $fullName = $tenant['first_name'] . " " . $tenant['middle_name'] . " " . $tenant['last_name']; // Full name of the tenant
        $userName = $tenant['first_name']; // Replace 'first_name' with the actual column name
        if (empty($tenant['profile_picture'])) {
            $profilePicture = $defaultProfilePicture;
        } else {
            $profilePicture = $tenant['profile_picture']; // Assuming 'profile_picture' is the column name for the profile picture
        }
    } elseif ($_SESSION['user_role'] == 'landlord') {
        $landlords = new Landlords($db);
        $landlord = $landlords->findById($_SESSION['user_id']);
        $userName = $landlord['name']; // Replace 'name' with the actual column name
        $profilePicture = $landlord['profile_picture']; // Replace 'profile_picture' with the actual column name
    }
}

// Fetch rents with last payment date
$query = "
    SELECT 
        rent.*, 
        rent.due_month,
        landlords.property_name, 
        CONCAT(landlords.first_name, ' ', landlords.middle_name, ' ', landlords.last_name) AS landlords_name,
        landlords.qr_payment,
        landlords.mode_of_payment,
        listings.rent,
        listings.address
    FROM rent
    LEFT JOIN listings ON rent.listing_id = listings.id
    LEFT JOIN landlords ON listings.user_id = landlords.id
    WHERE rent.user_id = :user_id
    GROUP BY rent.listing_id
";
$stmt = $db->prepare($query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$rents = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PoblacionEase</title>

    <link rel="stylesheet" href="../assets/css/style.css">

    <!-- FontAwesome CDN -->
    <script src="https://kit.fontawesome.com/f284e8c7c2.js" crossorigin="anonymous"></script>
    <!-- Swiper CSS -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- JQuery File -->
    <script src="../assets/js/jquery-3.7.1.min.js"></script>
    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Animate CSS -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>

<body class="font-custom">
    <?php require 'includes/sidebar.php'; ?>


    <main class="main-content main">
        <?php require 'includes/topbar.php'; ?>

        <div class="p-6">
            <h2 class="text-2xl font-semibold mb-6">Pay Rent</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php if (!empty($rents)) : ?>
                    <?php foreach ($rents as $rent) : ?>
                        <?php
                        ?>
                        <div class="bg-white shadow-md rounded-lg p-6">
                            <div class="mb-4">
                                <h3 class="text-lg font-semibold"><?php echo htmlspecialchars($rent['property_name']); ?></h3>
                                <p class="text-gray-500"><?php echo htmlspecialchars($rent['address']); ?></p>
                            </div>
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-gray-600">Rent:</span>
                                <span class="text-lg font-bold"><?php echo htmlspecialchars($rent['rent']); ?></span>
                            </div>
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-gray-600">Due Date:</span>
                                <span class="text-gray-700">
                                    <?php
                                    if ($rent['due_month'] !== null) {
                                        echo date('F j, Y', strtotime($rent['due_month']));
                                    } else {
                                        echo "<p class='text-sm text-red-500'>Wait for the approval of the  Landlord</p>"; // Show "None" if the due month is null
                                    }
                                    ?>
                                </span>
                            </div>
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-gray-600">Status:</span>
                                <span class="capitalize <?php echo $rent['rent_status'] === 'verified' ? 'text-green-500' : 'text-red-500'; ?>">
                                    <?php echo htmlspecialchars($rent['rent_status']); ?>
                                </span>
                            </div>

                            <div class="flex justify-between items-center mt-4">
                                <?php if ($rent['rent_status'] == 'paid') : ?>
                                    <button class="btn bg-primary text-white w-full" onclick="document.getElementById('modal_<?php echo $rent['id']; ?>').showModal()">
                                        Pay Rent
                                    </button>

                                    <dialog id="modal_<?php echo $rent['id']; ?>" class="modal modal-bottom sm:modal-middle">
                                        <div class="modal-box">
                                            <form method="dialog">
                                                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                                            </form>
                                            <h3 class="text-lg font-bold mb-4">
                                                <?php echo htmlspecialchars($rent['landlords_name']) . "'s QR Code"; ?>
                                            </h3>

                                            <?php if ($rent['qr_payment']) : ?>
                                                <img src="../landlords/Controllers/<?php echo htmlspecialchars($rent['qr_payment']); ?>"
                                                    alt="QR Code"
                                                    class="h-96 object-cover rounded-lg shadow-lg mb-4">
                                            <?php else : ?>
                                                <h1 class="text-4xl text-center p-6 text-red-500 uppercase font-bold">
                                                    No QR Code uploaded
                                                </h1>
                                            <?php endif; ?>

                                            <label for="reference_<?php echo $rent['id']; ?>" class="mt-4 text-xl">
                                                <?php echo htmlspecialchars($rent['mode_of_payment']); ?> Reference Number
                                            </label>
                                            <input type="text"
                                                id="reference_<?php echo $rent['id']; ?>"
                                                name="reference"
                                                pattern="^\d{13}$"
                                                title="Please enter exactly 13 digits"
                                                class="input input-bordered w-full"
                                                maxlength="13">

                                            <!-- Pay Rent button -->
                                            <button type="button"
                                                class="btn bg-primary text-white w-full mt-4"
                                                onclick="payRent(<?php echo $rent['id']; ?>, <?php echo $rent['rent']; ?>, '<?php echo date('F j, Y', strtotime($rent['due_month'])); ?>', document.getElementById('reference_<?php echo $rent['id']; ?>').value)">
                                                Pay Rent
                                            </button>
                                        </div>
                                    </dialog>
                                <?php else : ?>
                                    <h2 class="font-bold text-red-500">Wait for the landlord's approval</h2>
                                <?php endif; ?>
                            </div>

                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p class="text-center font-bold text-xl col-span-full">You don't have any rents yet.</p>
                <?php endif; ?>
            </div>
        </div>

    </main>
    <script>
        function payRent(rentId, rentAmount, dueMonth, referenceNumber) {
            console.log("Rent ID: ", rentId);
            console.log("Rent Amount: ", rentAmount);
            console.log("Due Month: ", dueMonth);
            console.log("Reference Number: ", referenceNumber);
            const modal = document.getElementById(`modal_${rentId}`);
            if (!referenceNumber) {
                modal.close();
                Swal.fire({
                    icon: 'warning',
                    title: 'Reference Number Required',
                    text: 'Please enter a reference number to proceed with the payment.'
                }).then(() => {
                    modal.showModal();
                });
                return;
            }
            modal.close();
            $.ajax({
                url: 'Controller/RentController.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    booking_id: rentId,
                    due_month: dueMonth,
                    rent_amount: rentAmount,
                    reference: referenceNumber
                },
                success: function(response) {
                    console.log("Server Response:", response); // Log the response
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Transaction Completed',
                            text: response.message
                        }).then(() => {
                            window.location.href = response.redirect_url;
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    console.log('Response Text:', xhr.responseText); // Log the raw response text
                    Swal.fire({
                        icon: 'error',
                        title: 'Request Failed',
                        text: 'There was an error processing your request.'
                    });
                }
            });

        }
    </script>

    <?php require 'includes/footer.php'; ?>
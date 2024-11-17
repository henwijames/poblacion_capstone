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

// Query to get the listings based on landlord's ID
// Query to get the listings the tenant inquired about (booked), including property_name from the landlords table
$query = "
    SELECT 
        rent.*, 
        landlords.property_name, 
        CONCAT(landlords.first_name, ' ', landlords.middle_name, ' ', landlords.last_name)
        AS landlords_name,
        landlords.qr_payment,
        landlords.mode_of_payment,
        listings.rent,
        listings.address 
    FROM rent
    LEFT JOIN listings ON rent.listing_id = listings.id
    LEFT JOIN landlords ON listings.user_id = landlords.id
    WHERE rent.user_id = :user_id
";
$stmt = $db->prepare($query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$rents = $stmt->fetchAll(PDO::FETCH_ASSOC);


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
    <?php
    if (isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'tenant') {
        $database = new Database();
        $db = $database->getConnection();
        $tenantId = $_SESSION['user_id'];
        $tenant = new Tenants($db);
        $tenantDetails = $tenant->findById($tenantId);

        if ($tenantDetails['account_status'] === 'banned') {
            echo "
            <script>
                Swal.fire({
                    title: 'Your Account is Banned',
                    text: 'You must pay your balance',
                    allowOutsideClick: false,
                    icon: 'warning',
                    confirmButtonColor: '#C1C549',
                    confirmButtonText: 'OK',
                    showClass: {
                    popup: `
      animate__animated
      animate__fadeInUp
      animate__faster
    `,
                },
                hideClass: {
                    popup: `
      animate__animated
      animate__fadeOutDown
      animate__faster
    `,
                },
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'pay-rent';
                    }
                });
            </script>
        ";
            exit;
        }
    }
    ?>
    <?php require 'includes/sidebar.php'; ?>


    <main class="main-content main">
        <?php require 'includes/topbar.php'; ?>

        <div class=" p-6">
            <h2 class="text-2xl font-semibold mb-4">My Rent</h2>

            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                        <tr class="text-left">
                            <th class="px-6 py-3 border-b">Property Name</th>
                            <th class="px-6 py-3 border-b">Address</th>
                            <th class="px-6 py-3 border-b">Rent</th>
                            <th class="px-6 py-3 border-b">Check-In Date</th>
                            <th class="px-6 py-3 border-b">Status</th>
                            <th class="px-6 py-3 border-b">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($rents)) : ?>
                            <?php foreach ($rents as $rent) : ?>
                                <tr>
                                    <td class="px-6 py-3 border-b"><?php echo htmlspecialchars($rent['property_name']); ?></td>
                                    <td class="px-6 py-3 border-b"><?php echo htmlspecialchars($rent['address']); ?></td>
                                    <td class="px-6 py-3 border-b font-bold"><?php echo htmlspecialchars($rent['rent']); ?></td>
                                    <td class="px-6 py-3 border-b"><?php echo htmlspecialchars($rent['rent_date']); ?></td>
                                    <td class="px-6 py-3 border-b capitalize">
                                        <?php echo htmlspecialchars($rent['rent_status']); ?>
                                    </td>
                                    <td class="px-6 py-3 border-b">
                                        <a href="rent-listing?id=<?php echo $rent['listing_id'] ?>" class="btn bg-primary text-white">View Rent</a>
                                        <button class="btn btn-warning text-white" onclick="document.getElementById('modal_<?= $rent['listing_id']; ?>').showModal()">Complain</button>
                                        <dialog id="modal_<?= $rent['listing_id']; ?>" class="modal modal-bottom sm:modal-middle">
                                            <div class="modal-box">
                                                <form method="dialog">
                                                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                                                </form>
                                                <h3 class="font-bold text-lg">Submit a Complaint</h3>
                                                <form id="complain-form-<?= $rent['listing_id']; ?>">
                                                    <input type="hidden" name="listing_id" value="<?= $rent['listing_id']; ?>">
                                                    <label class="form-control">
                                                        <div class="label">
                                                            <span class="label-text">Your Complaint</span>
                                                        </div>
                                                        <textarea name="complain_message" class="textarea textarea-bordered h-24" placeholder="Enter your complaint here..."></textarea>
                                                    </label>
                                                    <div class="modal-action">
                                                        <button type="submit" class="btn btn-sm bg-primary text-white">Submit</button>
                                                    </div>
                                                </form>

                                            </div>
                                        </dialog>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="6" class="px-6 py-3 border-b text-center font-bold text-xl">You don't have any rents yet.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <script>
        document.querySelectorAll('form[id^="complain-form-"]').forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent default form submission


                const formData = new FormData(this);
                const listingId = formData.get('listing_id');
                const complaintMessage = formData.get('complain_message').trim();
                const modal = document.getElementById(`modal_${listingId}`);
                modal.close()

                // Validate if the textarea is empty
                if (!complaintMessage) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Empty Complaint',
                        text: 'Please enter your complaint before submitting.',
                    }).then(() => {
                        modal.show();
                    })
                    modal.close()
                    return; // Do not proceed if validation fails
                }

                // AJAX Request to submit the complaint
                $.ajax({
                    url: '../Controllers/ComplaintController.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        response = JSON.parse(response);
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Complaint Submitted',
                                text: response.message,
                            }).then(() => {
                                modal.close(); // Close the modal
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Request Failed',
                            text: 'There was an error submitting your complaint.',
                        });
                    },
                });
            });
        });
    </script>

    <?php require 'includes/footer.php'; ?>
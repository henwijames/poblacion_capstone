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

    <!-- Style for Stars -->
    <style>
        .stars {
            display: flex;
            justify-content: space-between;
            width: 100%;
            max-width: 200px;
            margin-top: 10px;
        }

        .star-input {
            display: none;
        }

        .star {
            font-size: 30px;
            color: #ddd;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .star-input:checked~.star {
            color: gold;
        }

        .star:hover,
        .star-input:checked~.star:hover {
            color: gold;
        }
    </style>
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
                                        <button class="btn btn-error text-white" onclick="document.getElementById('review_modal_<?= $rent['listing_id']; ?>').showModal()">Leave</button>
                                        <dialog id="modal_<?= $rent['listing_id']; ?>" class="modal modal-bottom sm:modal-middle">
                                            <div class="modal-box">
                                                <form method="dialog">
                                                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                                                </form>
                                                <h3 class="font-bold text-lg">Submit a Maintenance Complaint</h3>
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
                                        <!-- Review Modal -->
                                        <dialog id="review_modal_<?= $rent['listing_id']; ?>" class="modal modal-bottom sm:modal-middle">
                                            <div class="modal-box bg-base-100 p-6 rounded-lg shadow-xl max-w-md mx-auto">
                                                <form method="dialog" class="absolute right-2 top-2">
                                                    <button class="btn btn-sm btn-circle btn-ghost hover:bg-base-200">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </form>
                                                <h3 class="font-bold text-2xl mb-6 text-center text-primary">Leave a Review</h3>
                                                <form id="review-form-<?= $rent['listing_id']; ?>" class="space-y-6">
                                                    <input type="hidden" name="listing_id" value="<?= $rent['listing_id']; ?>">

                                                    <!-- Star Rating -->
                                                    <div class="form-control">
                                                        <label class="label">
                                                            <span class="label-text text-lg font-semibold">Rating</span>
                                                        </label>
                                                        <select name="rating" id="rating-<?= $rent['listing_id']; ?>" class="select select-bordered w-full" required>
                                                            <option value="" disabled selected>Select your rating</option>
                                                            <option value="1">Very Dissatisfied</option>
                                                            <option value="2">Dissatisfied</option>
                                                            <option value="3">Neutral</option>
                                                            <option value="4">Satisfied</option>
                                                            <option value="5">Very Satisfied</option>
                                                        </select>
                                                    </div>

                                                    <!-- Review Text -->
                                                    <div class="form-control">
                                                        <label for="review_message_<?= $rent['listing_id']; ?>" class="label">
                                                            <span class="label-text text-lg font-semibold">Your Review</span>
                                                        </label>
                                                        <textarea
                                                            id="review_message_<?= $rent['listing_id']; ?>"
                                                            name="review_message"
                                                            class="textarea textarea-bordered h-32 w-full resize-none focus:ring-2 focus:ring-primary"
                                                            placeholder="Share your experience..."
                                                            required></textarea>
                                                    </div>

                                                    <div class="modal-action flex justify-end">
                                                        <button type="submit" class="btn btn-primary">
                                                            Submit Review
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                            </svg>
                                                        </button>
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
        document.querySelectorAll('form[id^="complain-form-"]').forEach((form) => {
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                const formData = new FormData(this);
                const listingId = formData.get('listing_id');
                const complaintMessage = formData.get('complain_message').trim();
                const modal = document.getElementById(`modal_${listingId}`);

                // Validate input
                if (!complaintMessage) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Empty Complaint',
                        text: 'Please enter your complaint before submitting.',
                    });
                    return;
                }
                modal.close();
                // AJAX request
                $.ajax({
                    url: '../Controllers/ComplaintController.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log('Raw Response:', response); // Log the raw response

                        // No need to parse, response is already an object
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Complaint Submitted',
                                text: response.message,
                            }).then(() => {
                                // Close the modal after successful submission
                                const modal = document.getElementById(`modal_${listingId}`);
                                modal.close();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX Error:', jqXHR, textStatus, errorThrown);
                        Swal.fire({
                            icon: 'error',
                            title: 'Request Failed',
                            text: 'There was an error submitting your complaint.',
                        }).then(() => {
                            // Close the modal after error
                            const modal = document.getElementById(`modal_${listingId}`);
                            if (modal) {
                                console.log(modal); // Check if modal is selected correctly
                                modal.close(); // Close the modal
                            }
                        });
                    },
                });
            });
        });

        document.querySelectorAll('form[id^="review-form-"]').forEach((form) => {
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                const formData = new FormData(this);
                const listingId = formData.get('listing_id');
                const reviewMessage = formData.get('review_message').trim();
                const rating = formData.get('rating'); // Now grabbing value from dropdown
                const modal = document.getElementById(`review_modal_${listingId}`);

                // Validate input
                if (!reviewMessage || !rating) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Incomplete Review',
                        text: 'Please provide a rating and a review message before submitting.',
                    });
                    return;
                }

                // Close the modal before sending the request
                if (modal) {
                    modal.close();
                }

                // AJAX request
                $.ajax({
                    url: '../Controllers/ReviewController.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json', // Ensure jQuery expects a JSON response
                    success: function(response) {
                        console.log('Raw Response:', response); // Log the response for debugging
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Review Submitted',
                                text: response.message,
                            }).then(() => location.reload()); // Reload page after success
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX Error:', jqXHR, textStatus, errorThrown);
                        Swal.fire({
                            icon: 'error',
                            title: 'Request Failed',
                            text: 'There was an issue submitting your review. Please try again.',
                        });
                    },
                });
            });
        });
    </script>

    <?php require 'includes/footer.php'; ?>
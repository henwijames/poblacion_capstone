<!DOCTYPE html>
<?php
// session_start();
// include 'session.php';
?>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PoblacionEase</title>

    <link rel="stylesheet" href="assets/css/style.css">

    <!-- FontAwesome CDN -->
    <script src="https://kit.fontawesome.com/f284e8c7c2.js" crossorigin="anonymous"></script>
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- JQuery File -->
    <script src="../assets/js/jquery-3.7.1.min.js"></script>
</head>

<body>

    <div class="fixed left-0 top-0 w-64 h-full bg-background p-4 z-50 sidebar-menu transition-transform ">
        <a href="#" class="flex justify-center items-center pb-4 border-b border-b-black">
            <img src="../assets/img/poblacionease.png" alt="" class="w-36 object-cover">
        </a>
        <ul class="mt-4">
            <li class="mb-1 group  <?php echo ($page == 'index') ? 'active' : ''; ?>">
                <a href="index" class=" flex items-center py-2 px-3 rounded-md hover:text-white hover:bg-primary group-[.active]:bg-primary group-[.active]:text-white group-[.selected]:bg-primary group-[.selected]:text-white ">
                    <i class="fa-solid fa-house mr-3 text-lg"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="mb-1 group <?php echo ($page == 'listings') ? 'active' : ''; ?>">
                <a href="#" class="flex items-center py-2 px-3 rounded-md hover:text-white hover:bg-primary group-[.active]:bg-primary group-[.active]:text-white sidebar-dropdown-toggle group-[.selected]:bg-primary group-[.selected]:text-white">
                    <i class="fa-solid fa-sign-hanging mr-3 text-lg"></i>
                    <span>Listings</span>
                    <i class="fa-solid fa-chevron-right ml-auto group-[.selected]:rotate-90"></i>
                </a>
                <ul class="pl-7 mt-2 hidden group-[.selected]:block ">
                    <li class="mb-4">
                        <a href="add-listings" class="text-sm flex items-center dot hover:text-primary">Add Listings</a>
                    </li>
                    <li class="mb-4">
                        <a href="listings" class="text-sm flex items-center dot hover:text-primary">Active Listings</a>
                    </li>
                </ul>
            </li>
            <li class="mb-1 group <?php echo ($page == 'tenants' || $page == 'rents') ? 'active' : ''; ?>">
                <a href="#" class="flex items-center py-2 px-3 rounded-md hover:text-white hover:bg-primary group-[.active]:bg-primary group-[.active]:text-white sidebar-dropdown-toggle group-[.selected]:bg-primary group-[.selected]:text-white">
                    <i class="fa-solid fa-key mr-3 text-lg"></i>
                    <span>Rent</span>
                    <i class="fa-solid fa-chevron-right ml-auto group-[.selected]:rotate-90"></i>
                </a>
                <ul class="pl-7 mt-2 hidden group-[.selected]:block">
                    <li class="mb-4">
                        <a href="rents" class="text-sm flex items-center dot hover:text-primary">Rents</a>
                    </li>
                    <li class="mb-4">
                        <a href="tenants" class="text-sm flex items-center dot hover:text-primary">Tenants</a>
                    </li>
                </ul>
            </li>
            <li class="mb-1 group">
                <a href="#" class="flex items-center py-2 px-3 rounded-md hover:text-white hover:bg-primary group-[.active]:bg-primary group-[.active]:text-white group-[.selected]:bg-primary group-[.selected]:text-white sidebar-dropdown-toggle">
                    <i class="fa-solid fa-money-bill mr-3 text-lg"></i>
                    <span>Payment</span>
                    <i class="fa-solid fa-chevron-right ml-auto group-[.selected]:rotate-90"></i>

                </a>
                <ul class="pl-7 mt-2 hidden group-[.selected]:block">
                    <li class="mb-4">
                        <a href="#" class="text-sm flex items-center dot hover:text-primary">Transactions</a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="text-sm flex items-center dot hover:text-primary">Tenants Balance</a>
                    </li>
                </ul>
            </li>
            <li class="mb-1 group">
                <a href="#" class="flex items-center py-2 px-3 rounded-md hover:text-white hover:bg-primary group-[.active]:bg-primary group-[.active]:text-white group-[.selected]:bg-primary group-[.selected]:text-white">
                    <i class="fa-solid fa-gears mr-3 text-lg"></i>
                    <span>Settings</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="fixed top-0 left-0 w-full h-full bg-black/50 md:hidden z-40 sidebar-overlay"></div>
    <main class="main-content main">
        <div class="py-2 px-4 flex items-center shadow-md shadow-black/5 sticky top-0 left-0  z-40 bg-white">
            <button type="button" class="text-lg sidebar-toggle">
                <i class="fa-solid fa-bars z-50"></i>
            </button>
            <ul class="flex items-center ml-4">
                <li class="mr-2">
                    <a id="breadcrumb" href="#" class="text-sm text-gray-600">Dashboard</a>
                </li>
            </ul>
            <ul class="ml-auto flex items-center ">
                <li class="mr-1 dropdown relative flex items-center gap-4">

                    <span class="hidden md:flex text-gray-400"><?php echo htmlspecialchars($userName); ?></span>
                    <button type="button" class="dropdown-toggle text-gray-400 w-8 h-8 rounded flex items-center justify-center hover:bg-gray-50 hover:text-gray-600">

                        <i class="fa-solid fa-user mr-2"></i>
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>
                    <ul class="dropdown-menu hidden shadow-md py-1.5 rounded-md bg-white border-gray-100 w-[140px] font-medium absolute top-full right-4 mt-2 z-10">
                        <li>
                            <a href="profile" class="flex items-center text-[13px] py-1.5 px-4 hover:bg-gray-100">Profile</a>
                        </li>
                        <li>
                            <a href="settings" class="flex items-center text-[13px] py-1.5 px-4 hover:bg-gray-100">Settings</a>
                        </li>
                        <li>
                            <a href="logout" class="flex items-center text-[13px] py-1.5 px-4 hover:bg-gray-100">Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="p-6">
            <div class="flex items-center justify-between h-full">
                <h1 class="text-2xl font-bold">Listings</h1>
                <a href="add-listing.php" class="bg-primary text-white py-2 px-4 rounded-md hover:bg-accent transition-all">Add Listing</a>
            </div>
            <div class="mt-4">
                <table class="w-full border border-gray-200 rounded-md">
                    <thead class="bg-gray-50">
                        <tr class="bg-slate-100">
                            <th class="py-2 px-4 border-r border-gray-200">Property</th>
                            <th class="py-2 px-4 border-r border-gray-200">Type</th>
                            <th class="py-2 px-4 border-r border-gray-200">Location</th>
                            <th class="py-2 px-4 border-r border-gray-200">Price</th>
                            <th class="py-2 px-4 border-r border-gray-200">Status</th>
                            <th class="py-2 px-4 border-r border-gray-200">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($userListings)): ?>
                            <?php foreach ($userListings as $userListing): ?>
                                <tr class="border-b">
                                    <td class="py-2 px-4 border-r border-gray-200"><?= htmlspecialchars($landlord['property_name']) ?></td>
                                    <td class="py-2 px-4 border-r border-gray-200 capitalize"><?= htmlspecialchars($userListing['property_type']) ?></td>
                                    <td class="py-2 px-4 border-r border-gray-200"><?= htmlspecialchars($userListing['address']) ?></td>
                                    <td class="py-2 px-4 border-r border-gray-200">₱<?= number_format($userListing['rent']) ?>/month</td>
                                    <td class="py-2 px-4 border-r border-gray-200"><?= htmlspecialchars($userListing['status']) ?></td>
                                    <td class="py-2 px-4 border-r border-gray-200 text-center">
                                        <a href="edit-listing.php?id=<?= $userListing['id'] ?>" class="inline-block px-4 py-1 rounded-md text-sm bg-blue-400 text-white">
                                            Edit
                                        </a>
                                        <a href="view-listings.php?id=<?= $userListing['id'] ?>" class="inline-block px-4 py-1 rounded-md text-sm bg-blue-400 text-white">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="py-4 text-center">No listings found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20" id="about">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div>
                    <div class="mb-6">
                        <h1 class="text-3xl font-bold mb-2"><?= htmlspecialchars($landlord["property_name"]); ?></h1>
                        <p class="text-muted-foreground"><?= htmlspecialchars($listingDetails['address']); ?></p>
                    </div>
                    <div class="mb-6">
                        <h2 class="text-xl font-bold mb-2">Landlord</h2>
                        <p class="text-muted-foreground"><?= htmlspecialchars($fullName) ?></p>
                        <p class="text-muted-foreground">Phone : <?= htmlspecialchars($landlord['phone_number']) ?></p>
                    </div>
                    <div class="mb-6">
                        <h2 class="text-xl font-bold mb-2">Amenities</h2>
                        <ul class="grid grid-cols-2 gap-4  capitalize">
                            <?php
                            $amenities = json_decode($listingDetails['amenities'], true);
                            foreach ($amenities as $amenity): ?>
                                <li class="flex items-center gap-2">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="w-5 h-5 text-primary">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="m9 12 2 2 4-4"></path>
                                    </svg>
                                    <span><?= htmlspecialchars($amenity) ?></span>
                                </li>
                            <?php endforeach; ?>

                        </ul>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <?php if (isset($listingDetails['images']) && is_array($listingDetails['images'])): ?>
                        <?php $maxImages = 4; // Adjust this as needed 
                        ?>
                        <?php $count = 0; ?>
                        <?php foreach ($listingDetails['images'] as $image): ?>
                            <?php if ($count >= $maxImages) break; ?>
                            <img
                                src="<?= htmlspecialchars("Controllers/" . $image); ?>"
                                alt="Apartment Image"
                                width="300"
                                height="200"
                                class="rounded-lg object-cover shadow-lg"
                                style="aspect-ratio: 300 / 200; object-fit: cover;" />
                            <?php $count++; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No images available.</p>
                    <?php endif; ?>

                </div>


            </div>
            <div class="swiper mt-4 h-[400px] md:h-[800px] w-full">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <?php if (isset($listingDetails['images']) && is_array($listingDetails['images'])): ?>

                        <?php foreach ($listingDetails['images'] as $image): ?>

                            <div class="swiper-slide">
                                <img
                                    src="<?= htmlspecialchars("Controllers/" . $image); ?>"
                                    alt="Apartment Image"
                                    class="rounded-lg object-cover shadow-lg w-full h-full" />
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No images available.</p>
                    <?php endif; ?>
                </div>
                <!-- If we need pagination -->
                <div class="swiper-pagination"></div>

                <!-- If we need navigation buttons -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>

                <!-- If we need scrollbar -->
                <div class="swiper-scrollbar"></div>
            </div>
        </main>
    </main>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            <div class="bg-background rounded-md shadow-md border border-gray-100 p-6">
                <div class="flex justify-between">
                    <div>
                        <div class="text-2xl font-semibold mb-1">10</div>
                        <div class="text-sm font-medium text-gray-400">Active Listings</div>
                    </div>
                    <div class="text-[40px]">
                        <i class="fa-solid fa-sign-hanging"></i>
                    </div>
                </div>


            </div>
            <div class="bg-background rounded-md shadow-md border border-gray-100 p-6">
                <div class="flex justify-between">
                    <div>
                        <div class="text-2xl font-semibold mb-1">40</div>
                        <div class="text-sm font-medium text-gray-400">Tenants</div>
                    </div>
                    <div class="text-[40px]">
                        <i class="fa-solid fa-person"></i>
                    </div>
                </div>

            </div>
            <div class="bg-background rounded-md shadow-md border border-gray-100 p-6">
                <div class="flex justify-between">
                    <div>
                        <div class="text-2xl font-semibold mb-1">23</div>
                        <div class="text-sm font-medium text-gray-400">Rents</div>
                    </div>
                    <div class="text-[40px]">
                        <i class="fa-solid fa-key"></i>
                    </div>
                </div>

            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-background border border-gray-100 shadow-md shadow-black/10 p-6 rounded-md">
                <div class="mb-4 flex justify-between items-start">
                    <div class="font-medium">Tenant</div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[540px] table-auto border-collapse shadow-lg">
                        <thead class="bg-slate-100">
                            <tr>
                                <th class="text-[12px] uppercase tracking-wide font-semibold py-3 px-4 text-left text-slate-700">Name</th>
                                <th class="text-[12px] uppercase tracking-wide font-semibold py-3 px-4 text-left text-slate-700">House Rented</th>
                                <th class="text-[12px] uppercase tracking-wide font-semibold py-3 px-4 text-left text-slate-700">Monthly Rate</th>
                                <th class="text-[12px] uppercase tracking-wide font-semibold py-3 px-4 text-left text-slate-700 rounded-tr-md">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b hover:bg-slate-50 transition-colors">
                                <td class="py-3 px-4 text-[13px] text-slate-600 font-medium">Henry James Ribano</td>
                                <td class="py-3 px-4 text-[13px] text-slate-600 font-medium text-center">House 5</td>
                                <td class="py-3 px-4 text-[13px] text-slate-600 font-medium text-center">P2,500</td>
                                <td class="py-3 px-4">
                                    <span class="inline-block px-4 py-1 rounded-full text-sm bg-yellow-400 text-white">Pending</span>
                                </td>
                            </tr>
                            <tr class="bg-white border-b hover:bg-slate-50 transition-colors">
                                <td class="py-3 px-4 text-[13px] text-slate-600 font-medium">Juan Lorenzo Aguilar</td>
                                <td class="py-3 px-4 text-[13px] text-slate-600 font-medium text-center">House 2</td>
                                <td class="py-3 px-4 text-[13px] text-slate-600 font-medium text-center">P2,800</td>
                                <td class="py-3 px-4">
                                    <span class="inline-block px-4 py-1 rounded-full text-sm bg-green-400 text-white">Verified</span>
                                </td>
                            </tr>
                            <tr class="bg-white hover:bg-slate-50 transition-colors">
                                <td class="py-3 px-4 text-[13px] text-slate-600 font-medium">John Michael Castor</td>
                                <td class="py-3 px-4 text-[13px] text-slate-600 font-medium text-center">House 1</td>
                                <td class="py-3 px-4 text-[13px] text-slate-600 font-medium text-center">P2,100</td>
                                <td class="py-3 px-4">
                                    <span class="inline-block w-24 px-4 py-1 rounded-full text-xs bg-red-400 text-white">Not Paid</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
            <div class="bg-background border border-gray-100 shadow-md shadow-black/10 p-6 rounded-md">
                <div class="mb-4 flex justify-between items-start">
                    <div class="font-medium">Listings</div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[540px] table-auto border-collapse shadow-lg">
                        <thead class="bg-slate-100">
                            <tr>
                                <th class="text-[12px] uppercase tracking-wide font-semibold py-3 px-4 text-left text-slate-700">House</th>
                                <th class="text-[12px] uppercase tracking-wide font-semibold py-3 px-4 text-left text-slate-700">Monthly Rent</th>
                                <th class="text-[12px] uppercase tracking-wide font-semibold py-3 px-4 text-left text-slate-700">House Type</th>
                                <th class="text-[12px] uppercase tracking-wide font-semibold py-3 px-4 text-left text-slate-700 rounded-tr-md">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b hover:bg-slate-50 transition-colors">
                                <td class="py-3 px-4 text-[13px] text-slate-600 font-medium">Bahay Kubo</td>
                                <td class="py-3 px-4 text-[13px] text-slate-600 font-medium text-center">P1,000</td>
                                <td class="py-3 px-4 text-[13px] text-slate-600 font-medium text-center">Apartment</td>
                                <td class="py-3 px-4 flex gap-2">
                                    <button class="inline-block px-4 py-1 rounded-md text-sm bg-blue-400 text-white">
                                        Edit
                                    </button>
                                    <button class="inline-block px-4 py-1 rounded-md text-sm bg-red-400 text-white">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                            <tr class="bg-white border-b hover:bg-slate-50 transition-colors">
                                <td class="py-3 px-4 text-[13px] text-slate-600 font-medium">La Zanti</td>
                                <td class="py-3 px-4 text-[13px] text-slate-600 font-medium text-center">P2,000</td>
                                <td class="py-3 px-4 text-[13px] text-slate-600 font-medium text-center">Apartment</td>
                                <td class="py-3 px-4 flex gap-2">
                                    <button class="inline-block px-4 py-1 rounded-md text-sm bg-blue-400 text-white">
                                        Edit
                                    </button>
                                    <button class="inline-block px-4 py-1 rounded-md text-sm bg-red-400 text-white">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                            <tr class="bg-white border-b hover:bg-slate-50 transition-colors">
                                <td class="py-3 px-4 text-[13px] text-slate-600 font-medium">Valentinos</td>
                                <td class="py-3 px-4 text-[13px] text-slate-600 font-medium text-center">P2,000</td>
                                <td class="py-3 px-4 text-[13px] text-slate-600 font-medium text-center">Apartment</td>
                                <td class="py-3 px-4 flex gap-2">
                                    <button class="inline-block px-4 py-1 rounded-md text-sm bg-blue-400 text-white">
                                        Edit
                                    </button>
                                    <button class="inline-block px-4 py-1 rounded-md text-sm bg-red-400 text-white">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    <div class="container mx-auto px-4 sm:px-6 md:px-8 py-12">
        <h1 class="text-3xl font-bold mb-8">Add New Listing</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <form class="space-y-6" action="Controllers/ListingController.php" method="POST" enctype="multipart/form-data">
                    <?php if (!empty($errors)): ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Error!</strong>
                            <ul class="list-disc pl-5 mt-2">
                                <?php foreach ($errors as $field => $error): ?>
                                    <li><?php echo htmlspecialchars($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <div>
                        <h3 class="text-lg font-medium text-gray-700">Property Type*</h3>
                        <div class="flex gap-4 mt-2">
                            <label class="inline-flex items-center">
                                <input type="radio" name="property_type" value="apartment" class="rounded border-gray-300 text-primary focus:ring-primary" <?php if (isset($_POST['property_type']) && $_POST['property_type'] == 'Apartment') echo 'checked'; ?>>
                                <span class="ml-2 text-sm text-gray-700">Apartment</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="property_type" value="business" class="rounded border-gray-300 text-primary focus:ring-primary" <?php if (isset($_POST['property_type']) && $_POST['property_type'] == 'Business Establishment') echo 'checked'; ?>>
                                <span class="ml-2 text-sm text-gray-700">Business Establishment</span>
                            </label>
                        </div>
                        <?php if (isset($errors['property_type'])): ?>
                            <p class="text-red-500 text-sm"><?php echo htmlspecialchars($errors['property_type']); ?></p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">
                            Address*
                        </label>
                        <input
                            type="text"
                            id="address"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"
                            name="address"
                            placeholder="123 Main St, Anytown USA" />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="bedrooms" class="block text-sm font-medium text-gray-700">
                                Bedrooms*
                            </label>
                            <input
                                id="bedrooms"
                                type="number"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"
                                placeholder="2"
                                name="bedrooms" />
                        </div>
                        <div>
                            <label for="bathrooms" class="block text-sm font-medium text-gray-700">
                                Bathrooms*
                            </label>
                            <input
                                id="bathrooms"
                                type="number"
                                name="bathrooms"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"
                                placeholder="1" />
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-700">Amenities</h3>
                        <div class="grid grid-cols-2 gap-4 mt-2">
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="amenities[]" value="water" class="rounded border-gray-300 text-primary focus:ring-primary">
                                    <span class="ml-2 text-sm text-gray-700">Water</span>
                                </label>
                            </div>
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="amenities[]" value="electricity" class="rounded border-gray-300 text-primary focus:ring-primary">
                                    <span class="ml-2 text-sm text-gray-700">Electricity</span>
                                </label>
                            </div>
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="amenities[]" value="wifi" class="rounded border-gray-300 text-primary focus:ring-primary">
                                    <span class="ml-2 text-sm text-gray-700">Wi-Fi</span>
                                </label>
                            </div>
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="amenities[]" value="parking" class="rounded border-gray-300 text-primary focus:ring-primary">
                                    <span class="ml-2 text-sm text-gray-700">Parking</span>
                                </label>
                            </div>
                            <!-- Add more checkboxes for additional amenities as needed -->
                        </div>
                    </div>
                    <div>
                        <label for="sqft" class="block text-sm font-medium text-gray-700">
                            Square Meters*
                        </label>
                        <input
                            id="sqft"
                            type="number"
                            name="sqft"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"
                            placeholder="1200" />
                    </div>
                    <div>
                        <label for="rent" class="block text-sm font-medium text-gray-700">
                            Rent Price*
                        </label>
                        <input
                            id="rent"
                            type="number"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"
                            placeholder="1500"
                            name="rent" />
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">
                            Description*
                        </label>
                        <textarea
                            id="description"
                            name="description"
                            rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"
                            placeholder="Describe the property details..."></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Upload Images of the Property</label>
                        <p class="block text-xs font-medium text-red-500">*Select 5 images in your gallery</p>
                        <div class="mt-1 flex justify-center rounded-md border-2 border-dashed border-gray-300 px-6 pt-5 pb-6">
                            <div class="space-y-1 text-center">
                                <svg
                                    class="mx-auto h-12 w-12 text-gray-400"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 48 48"
                                    aria-hidden="true">
                                    <path
                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label
                                        for="file-upload"
                                        class="relative cursor-pointer rounded-md bg-white font-medium text-primary focus-within:outline-none focus-within:ring-2 focus-within:ring-primary focus-within:ring-offset-2 hover:text-primary-dark">
                                        <span>Upload files</span>
                                        <input id="file-upload" class="sr-only" type="file" name="file-upload[]" accept="image/jpeg, image/png, image/jpg" multiple />
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB each</p>
                            </div>
                            <?php if (isset($errors['file-upload'])): ?>
                                <p class="text-red-500 text-sm"><?php echo htmlspecialchars($errors['file-upload']); ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Five Image Preview Container -->
                        <div id="file-preview" class="grid grid-cols-5 gap-4 mt-4">
                            <!-- Placeholder containers for images -->
                            <div class="image-container w-full h-32 bg-gray-100 rounded-md flex items-center justify-center">
                                <p class="text-sm text-gray-500">Image 1</p>
                            </div>
                            <div class="image-container w-full h-32 bg-gray-100 rounded-md flex items-center justify-center">
                                <p class="text-sm text-gray-500">Image 2</p>
                            </div>
                            <div class="image-container w-full h-32 bg-gray-100 rounded-md flex items-center justify-center">
                                <p class="text-sm text-gray-500">Image 3</p>
                            </div>
                            <div class="image-container w-full h-32 bg-gray-100 rounded-md flex items-center justify-center">
                                <p class="text-sm text-gray-500">Image 4</p>
                            </div>
                            <div class="image-container w-full h-32 bg-gray-100 rounded-md flex items-center justify-center">
                                <p class="text-sm text-gray-500">Image 5</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-center">
                        <button
                            type="submit"
                            class="inline-flex justify-center rounded-md border border-transparent bg-primary py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                            Save Listing
                        </button>
                    </div>
                </form>
            </div>
            <div>
                <h2 class="text-2xl font-bold mb-4 border-r-2">Your Listings</h2>
                <div class="space-y-4">
                    <div class="bg-white rounded-lg shadow-md p-4">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="text-lg font-medium">123 Main St, Anytown USA</h3>
                            <div class="flex gap-2">
                                <button class="text-primary hover:text-primary-dark">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <button class="text-red-500 hover:text-red-700">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <p class="text-gray-500 mb-2">2 bedrooms, 1 bathroom</p>
                        <p class="text-gray-500 mb-2">1200 sq ft</p>
                        <p class="text-gray-500 mb-2">$1500/month</p>
                    </div>
                    <div class="bg-white rounded-lg shadow-md p-4">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="text-lg font-medium">456 Oak St, Anytown USA</h3>
                            <div class="flex gap-2">
                                <button class="text-primary hover:text-primary-dark">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <button class="text-red-500 hover:text-red-700">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <p class="text-gray-500 mb-2">3 bedrooms, 2 bathrooms</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="max-w-4xl mx-auto py-8">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="h-48 bg-cover bg-center" style="background-image: url('https://source.unsplash.com/1600x900/?mountain,water')"></div>

            <h1 class="text-3xl font-bold text-center text-gray-800 mt-16 mb-8">Edit Profile</h1>
            <div class="flex items-center space-x-6">
                <div class="shrink-0">
                    <img class="h-16 w-16 object-cover rounded-full" src="https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1361&q=80" alt="Current profile photo" />
                </div>
                <label class="block">
                    <span class="sr-only">Choose profile photo</span>
                    <input type="file" class="block w-full cursor-pointer text-sm text-slate-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-violet-50 file:text-primary
                            hover:file:bg-accent
                            " />
                </label>
            </div>
            <form class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="firstName" class="block text-sm font-medium text-gray-700">First Name</label>
                        <input type="text" id="firstName" name="firstName" value="Henry James" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                    <div>
                        <label for="middleName" class="block text-sm font-medium text-gray-700">Middle Name</label>
                        <input type="text" id="middleName" name="middleName" value="Marcellana" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                    <div>
                        <label for="lastName" class="block text-sm font-medium text-gray-700">Last Name</label>
                        <input type="text" id="lastName" name="lastName" value="Ribano" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                        <input type="text" id="address" name="address" value="Ibaba" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                    <div>
                        <label for="phoneNumber" class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="tel" id="phoneNumber" name="phoneNumber" value="09691756860" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email" value="henryjamesribano27@gmail.com" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
    </div>
    <div class="flex flex-col z-10">
        <main class="flex-1 mx-auto py-8 px-6 md:px-8 lg:px-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            <div class="rounded-lg border bg-card text-card-foreground shadow-sm overflow-hidden bg-white">
                <img
                    src="../assets/img/1.jpg"
                    alt="Featured Listing 1"
                    width="400"
                    height="300"
                    class="rounded-t-md object-cover w-full h-60"
                    style="aspect-ratio: 400 / 300; object-fit: cover;" />
                <div class="p-4">
                    <h3 class="text-lg font-semibold">Luxury Penthouse in Downtown</h3>
                    <h3 class="text-base text-muted-foreground">Zone 14, Taal, Batangas</h3>
                    <p class="mt-2 text-muted-foreground">Hosted by Henry James</p>
                    <p class="text-muted-foreground mb-2">1,000 sq ft | 2 Bed | 2 Bath</p>
                    <p class="text-primary font-bold text-lg">4,000/month</p>
                    <div class="mt-4">
                        <a class="text-white bg-primary px-5 py-2 border border-[#C1C549] rounded-md hover:bg-accent ease transition-colors" href="apartment" rel="ugc">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        //Start Sidebar
        const sidebarToggle = document.querySelector(".sidebar-toggle");
        const sidebarOverlay = document.querySelector(".sidebar-overlay");
        const sidebarMenu = document.querySelector(".sidebar-menu");
        const main = document.querySelector(".main");

        sidebarToggle.addEventListener("click", (e) => {
            e.preventDefault();
            main.classList.toggle("active");
            sidebarOverlay.classList.toggle("hidden");
            sidebarMenu.classList.toggle("-translate-x-full");
        });

        sidebarOverlay.addEventListener("click", (e) => {
            e.preventDefault();
            main.classList.add("active");
            sidebarOverlay.classList.toggle("hidden");
            sidebarMenu.classList.toggle("-translate-x-full");
        });

        document.querySelectorAll(".sidebar-dropdown-toggle").forEach((item) => {
            item.addEventListener("click", (e) => {
                e.preventDefault();
                const parent = item.closest(".group");
                if (parent.classList.contains("selected")) {
                    parent.classList.remove("selected");
                } else {
                    document.querySelectorAll(".sidebar-dropdown-toggle").forEach((item) => {
                        item.closest(".group").classList.remove("selected");
                    });
                    parent.classList.add("selected");
                }
                parent.classList.add("selected");
            });
        });

        document.querySelectorAll(".dropdown-toggle").forEach((button) => {
            button.addEventListener("click", () => {
                const dropdownMenu = button.nextElementSibling;

                // Toggle the hidden class to show/hide the dropdown
                dropdownMenu.classList.toggle("hidden");

                // Close any other open dropdowns
                document.querySelectorAll(".dropdown-menu").forEach((menu) => {
                    if (menu !== dropdownMenu) {
                        menu.classList.add("hidden");
                    }
                });
            });
        });

        // Optional: Close the dropdown if clicked outside
        document.addEventListener("click", (e) => {
            const isDropdown =
                e.target.matches(".dropdown-toggle") || e.target.closest(".dropdown");
            if (!isDropdown) {
                document.querySelectorAll(".dropdown-menu").forEach((menu) => {
                    menu.classList.add("hidden");
                });
            }
        });

        //End Sidebar

        document.addEventListener("DOMContentLoaded", function() {
            const breadCrumb = document.getElementById("breadcrumb");
            const pageLinks = document.querySelectorAll("a[href]");

            pageLinks.forEach((link) => {
                link.addEventListener("click", function(event) {
                    const pageName = this.textContent.trim();

                    // Prevent duplicate "Dashboard / Dashboard" entries

                    breadCrumb.textContent = `${pageName}`;

                    // Store the breadcrumb in localStorage
                    localStorage.setItem("breadcrumb", breadCrumb.textContent);
                });
            });

            // On page load, restore the breadcrumb from localStorage
            const savedBreadcrumb = localStorage.getItem("breadcrumb");
            if (savedBreadcrumb) {
                breadCrumb.textContent = savedBreadcrumb;
            } else {
                breadCrumb.textContent = "Dashboard";
            }
        });
    </script>
</body>

</html>
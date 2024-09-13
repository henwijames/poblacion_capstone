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
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
    <link rel="stylesheet" href="assets/css/aos.css">
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
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            <div class=" rounded-md shadow-md border border-gray-100 p-6">
                <div class="flex justify-between">
                    <div>
                        <div class="text-2xl font-semibold mb-1"><?php echo htmlspecialchars($counts['activeListings']); ?></div>
                        <div class="text-sm font-medium text-gray-400">Active Listings</div>
                    </div>
                    <div class="text-[40px]">
                        <i class="fa-solid fa-sign-hanging"></i>
                    </div>
                </div>


            </div>
            <div class=" rounded-md shadow-md border border-gray-100 p-6">
                <div class="flex justify-between">
                    <div>
                        <div class="text-2xl font-semibold mb-1">0</div>
                        <div class="text-sm font-medium text-gray-400">Tenants</div>
                    </div>
                    <div class="text-[40px]">
                        <i class="fa-solid fa-person"></i>
                    </div>
                </div>

            </div>
            <div class=" rounded-md shadow-md border border-gray-100 p-6">
                <div class="flex justify-between">
                    <div>
                        <div class="text-2xl font-semibold mb-1">0</div>
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
                            <?php if (!empty($userListings)): ?>
                                <?php foreach ($userListings as $userListing): ?>
                                    <tr class="bg-white border-b hover:bg-slate-50 transition-colors">
                                        <td class="py-3 px-4 text-[13px] text-slate-600 font-medium"><?= htmlspecialchars($landlord['property_name']) ?></td>
                                        <td class="py-3 px-4 text-[13px] text-slate-600 font-medium text-center">₱<?= number_format($userListing['rent']) ?></td>
                                        <td class="py-3 px-4 text-[13px] text-slate-600 font-medium text-center capitalize"><?= htmlspecialchars($userListing['property_type']) ?></td>
                                        <td class="py-3 px-4 flex gap-2">
                                            <button class="inline-block px-4 py-1 rounded-md text-sm bg-blue-400 text-white">
                                                Edit
                                            </button>
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
        </div>
    </div>
</body>
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

</html>
<?php include 'includes/header.php'; ?>

<main class="main-content main">
    <?php include 'includes/topbar.php'; ?>
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
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
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
<?php include 'includes/footer.php'; ?>
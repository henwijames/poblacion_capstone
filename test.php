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

    <!-- JQuery File -->
    <script src="../assets/js/jquery-3.7.1.min.js"></script>
</head>

<body>
    <div class="fixed left-0 top-0 w-64 h-full bg-background p-4 z-50 sidebar-menu transition-transform ">
        <a href="#" class="flex justify-center items-center pb-4 border-b border-b-black">
            <img src="assets/img/poblacionease.png" alt="" class="w-36 object-cover">
        </a>
        <ul class="mt-4">
            <li class="mb-1 group active">
                <a href="#" class="flex items-center py-2 px-3 rounded-md hover:text-white hover:bg-primary group-[.active]:bg-primary group-[.active]:text-white group-[.selected]:bg-primary group-[.selected]:text-white">
                    <i class="fa-solid fa-house mr-3 text-lg"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="mb-1 group">
                <a href="#" class="flex items-center py-2 px-3 rounded-md hover:text-white hover:bg-primary group-[.active]:bg-primary group-[.active]:text-white sidebar-dropdown-toggle group-[.selected]:bg-primary group-[.selected]:text-white">
                    <i class="fa-solid fa-sign-hanging mr-3 text-lg"></i>
                    <span>Listings</span>
                    <i class="fa-solid fa-chevron-right ml-auto group-[.selected]:rotate-90"></i>
                </a>
                <ul class="pl-7 mt-2 hidden group-[.selected]:block">
                    <li class="mb-4">
                        <a href="#" class="text-sm flex items-center dot hover:text-primary">Add Listings</a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="text-sm flex items-center dot hover:text-primary">Active Listings</a>
                    </li>
                </ul>
            </li>
            <li class="mb-1 group">
                <a href="#" class="flex items-center py-2 px-3 rounded-md hover:text-white hover:bg-primary group-[.active]:bg-primary group-[.active]:text-white sidebar-dropdown-toggle group-[.selected]:bg-primary group-[.selected]:text-white">
                    <i class="fa-solid fa-key mr-3 text-lg"></i>
                    <span>Rent</span>
                    <i class="fa-solid fa-chevron-right ml-auto group-[.selected]:rotate-90"></i>
                </a>
                <ul class="pl-7 mt-2 hidden group-[.selected]:block">
                    <li class="mb-4">
                        <a href="#" class="text-sm flex items-center dot hover:text-primary">Rents</a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="text-sm flex items-center dot hover:text-primary">Tenants</a>
                    </li>
                </ul>
            </li>
            <li class="mb-1 group">
                <a href="#" class="flex items-center py-2 px-3 rounded-md hover:text-white hover:bg-primary group-[.active]:bg-primary group-[.active]:text-white group-[.selected]:bg-primary group-[.selected]:text-white">
                    <i class="fa-solid fa-money-bill mr-3 text-lg"></i>
                    <span>Payment</span>
                </a>
            </li>
            <li class="mb-1 group">
                <a href="#" class="flex items-center py-2 px-3 rounded-md hover:text-white hover:bg-primary group-[.active]:bg-primary group-[.active]:text-white group-[.selected]:bg-primary group-[.selected]:text-white">
                    <i class="fa-solid fa-gears mr-3 text-lg"></i>
                    <span>Settings</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="fixed top-0 left-0 w-full h-full bg-black/50 z-40 md:hidden sidebar-overlay"></div>
    <main class="w-full md:w-[calc(100%-256px)] md:ml-64 min-h-screen main transition-all main">
        <div class="py-2 px-4 flex items-center shadow-md shadow-black/5">
            <button type="button" class="text-lg sidebar-toggle">
                <i class="fa-solid fa-bars"></i>
            </button>
            <ul class="flex items-center ml-4">
                <li class="mr-2">
                    <a href="#" class="text-sm text-gray-600">Dashboard</a>
                </li>
            </ul>
            <ul class="ml-auto flex items-center ">
                <li class="mr-1 dropdown relative flex items-center gap-4">
                    <span class="hidden md:flex text-gray-400">Henry James Ribano</span>
                    <button type="button" class="dropdown-toggle text-gray-400 w-8 h-8 rounded flex items-center justify-center hover:bg-gray-50 hover:text-gray-600">

                        <i class="fa-solid fa-user mr-2"></i>
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>
                    <ul class="dropdown-menu hidden shadow-md py-1.5 rounded-md bg-white border-gray-100 w-[140px] font-medium absolute top-full right-4 mt-2 z-10">
                        <li>
                            <a href="#" class="flex items-center text-[13px] py-1.5 px-4 hover:bg-gray-100">Profile</a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center text-[13px] py-1.5 px-4 hover:bg-gray-100">Settings</a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center text-[13px] py-1.5 px-4 hover:bg-gray-100">Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
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
                                        <span class="inline-block px-4 py-1 rounded-full text-sm bg-blue-400 text-white">Verified</span>
                                    </td>
                                </tr>
                                <tr class="bg-white hover:bg-slate-50 transition-colors">
                                    <td class="py-3 px-4 text-[13px] text-slate-600 font-medium">John Michael Castor</td>
                                    <td class="py-3 px-4 text-[13px] text-slate-600 font-medium text-center">House 1</td>
                                    <td class="py-3 px-4 text-[13px] text-slate-600 font-medium text-center">P2,100</td>
                                    <td class="py-3 px-4">
                                        <span class="inline-block px-4 py-1 rounded-full text-sm bg-red-400 text-white">Banned</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <script>
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
                    parent.classList.add("selected");
                });
            });

            document.querySelectorAll('.dropdown-toggle').forEach(button => {
                button.addEventListener('click', () => {
                    const dropdownMenu = button.nextElementSibling;

                    // Toggle the hidden class to show/hide the dropdown
                    dropdownMenu.classList.toggle('hidden');

                    // Close any other open dropdowns
                    document.querySelectorAll('.dropdown-menu').forEach(menu => {
                        if (menu !== dropdownMenu) {
                            menu.classList.add('hidden');
                        }
                    });
                });
            });

            // Optional: Close the dropdown if clicked outside
            document.addEventListener('click', (e) => {
                const isDropdown = e.target.matches('.dropdown-toggle') || e.target.closest('.dropdown');
                if (!isDropdown) {
                    document.querySelectorAll('.dropdown-menu').forEach(menu => {
                        menu.classList.add('hidden');
                    });
                }
            });
        </script>

</body>

</html>
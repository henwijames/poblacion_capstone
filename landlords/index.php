<?php include 'includes/header.php'; ?>
<!-- Sidebar -->
<?php include 'includes/sidebar.php'; ?>
<!-- Sidebar End -->
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
                                    <span class="inline-block px-4 py-1 rounded-full text-sm bg-green-400 text-white">Verified</span>
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
</main>
<?php include 'includes/footer.php'; ?>
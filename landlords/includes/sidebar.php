<div class="fixed left-0 top-0 w-64 h-full bg-background p-4 z-50 sidebar-menu transition-transform shadow-md">
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
                    <a href="inquiries" class="text-sm flex items-center dot hover:text-primary">Inquiries</a>
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
            <a href="#" class="flex items-center py-2 px-3 rounded-md hover:text-white hover:bg-primary group-[.active]:bg-primary group-[.active]:text-white group-[.selected]:bg-primary group-[.selected]:text-white sidebar-dropdown-toggle">
                <i class="fa-solid fa-gears mr-3 text-lg"></i>
                <span>Settings</span>
                <i class="fa-solid fa-chevron-right ml-auto group-[.selected]:rotate-90"></i>
            </a>
            <ul class="pl-7 mt-2 hidden group-[.selected]:block">
                <li class="mb-4">
                    <a href="permit" class="text-sm flex items-center dot hover:text-primary">Upload Business Permit</a>
                </li>
            </ul>
        </li>
    </ul>
</div>

<div class="fixed top-0 left-0 w-full h-full bg-black/50 md:hidden z-40 sidebar-overlay"></div>
<div class="fixed left-0 top-0 w-64 h-full bg-background p-4 z-50 sidebar-menu transition-transform shadow-md">
    <a href="#" class="flex justify-center items-center pb-4 border-b border-b-black">
        <img src="../assets/img/poblacionease.png" alt="" class="w-36 object-cover">
    </a>
    <ul class="mt-4">
        <li class="mb-1 group  <?php echo ($page == 'index') ? 'active' : ''; ?>">
            <a href="index" class=" flex items-center py-2 px-3 rounded-md hover:text-white hover:bg-primary group-[.active]:bg-primary group-[.active]:text-white group-[.selected]:bg-primary group-[.selected]:text-white ">
                <i class="fa-solid fa-house mr-3 text-lg"></i>
                <span>Home</span>
            </a>
        </li>
        <li class="mb-1 group <?php echo ($page == 'listings') ? 'active' : ''; ?>">
            <a href="#" class="flex items-center py-2 px-3 rounded-md hover:text-white hover:bg-primary group-[.active]:bg-primary group-[.active]:text-white sidebar-dropdown-toggle group-[.selected]:bg-primary group-[.selected]:text-white">
                <i class="fa-solid fa-sign-hanging mr-3 text-lg"></i>
                <span>Rent</span>
                <i class="fa-solid fa-chevron-right ml-auto group-[.selected]:rotate-90"></i>
            </a>
            <ul class="pl-7 mt-2 hidden group-[.selected]:block ">
                <li class="mb-4">
                    <a href="rent" class="text-sm flex items-center dot hover:text-primary">My Rent</a>
                    <a href="inquiries" class="text-sm flex items-center dot hover:text-primary">Inquiries</a>
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
                    <a href="pay-rent" class="text-sm flex items-center dot hover:text-primary">Pay Rent</a>
                </li>
                <li class="mb-4">
                    <a href="transactions" class="text-sm flex items-center dot hover:text-primary">Transactions</a>
                </li>
            </ul>
        </li>
        <li class="mb-1 group">
            <a href="#" class="flex items-center py-2 px-3 rounded-md hover:text-white hover:bg-primary group-[.active]:bg-primary group-[.active]:text-white group-[.selected]:bg-primary group-[.selected]:text-white sidebar-dropdown-toggle">
                <i class="fa-solid fa-gear mr-3 text-lg"></i>
                <span>Settings</span>
                <i class="fa-solid fa-chevron-right ml-auto group-[.selected]:rotate-90"></i>

            </a>
            <ul class="pl-7 mt-2 hidden group-[.selected]:block">
                <li class="mb-4">
                    <a href="verifymobile" class="text-sm flex items-center dot hover:text-primary">Verify Mobile Number</a>
                </li>
                <li class="mb-4">
                    <a href="verifyemail" class="text-sm flex items-center dot hover:text-primary">Verify Email Address</a>
                </li>
                <li class="mb-4">
                    <a href="valid_id" class="text-sm flex items-center dot hover:text-primary">Add Valid ID</a>
                </li>
            </ul>
        </li>
    </ul>
</div>

<div class="fixed top-0 left-0 w-full h-full bg-black/50 md:hidden z-40 sidebar-overlay"></div>
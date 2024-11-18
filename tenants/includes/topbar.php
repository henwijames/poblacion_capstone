<div class="py-2 px-4 flex items-center shadow-md shadow-black/5 sticky top-0 left-0  z-40 bg-white">
    <button type="button" class="text-lg sidebar-toggle">
        <i class="fa-solid fa-bars z-50"></i>
    </button>
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
                    <a href="logout" id="logout-btn" class="flex items-center text-[13px] py-1.5 px-4 hover:bg-gray-100">Logout</a>
                </li>
            </ul>
        </li>
    </ul>
</div>
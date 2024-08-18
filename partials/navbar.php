<nav class="py-2 sticky top-0 px-5 md:px-[120px]  md:flex items-center justify-between bg-background shadow">
    <div class="flex justify-between items-center">
        <img src="assets/img/poblacionease.png" alt="logo" class="w-[150px]">
        <span class="text-3xl cursor-pointer md:hidden block">
            <i class="fa-solid fa-bars" onclick="onToggleMenu(this)"></i>
        </span>
    </div>
    <ul id="menu" class="md:flex md:items-center gap-4 z-0 md:z-auto  md:static absolute 
            bg-background w-full left-0 md:w-auto md:py-0 py-4 md:pl-0 pl-7 md:opacity-100 
            opacity-0 top-[-400px] transition-all ease-in duration-500">
        <li class="my-6 md:my-0 ">
            <a href="index" class="text-xl hover:text-primary duration-500">Home</a>
        </li>
        <li class="my-6 md:my-0 ">
            <a href="#rent" class="text-xl hover:text-primary duration-500">Rent</a>
        </li>
        <li class="my-6 md:my-0 ">
            <a href="#about" class="text-xl hover:text-primary duration-500">About</a>
        </li>
        <a
            href="login"
            class="bg-primary text-white px-5 py-2 transition-colors rounded-full hover:bg-accent">
            LOGIN
        </a>
    </ul>
</nav>
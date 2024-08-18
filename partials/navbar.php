<div class="container mx-auto py-6">
    <nav class="flex justify-between items-center w-[92%] mx-auto">
        <a href="index">
            <img src="assets/img/poblacionease.png" alt="logo" class="w-24">
        </a>
        <div class="md:static absolute  bg-background md:bg-transparent md:min-h-fit min-h-[30vh] left-0 top-[-120%] md:w-auto w-full flex items-center px-10 transition-all duration-500 ease-in-out" id="nav-links">
            <ul class="flex md:flex-row flex-col md:items-center md:gap-[4vw] gap-8">
                <li>
                    <a class="hover:text-primary" href="index">Home</a>
                </li>
                <li>
                    <a class="hover:text-primary" href="#rent">Rent</a>
                </li>
                <li>
                    <a class="hover:text-primary" href="#about">About</a>
                </li>
            </ul>
        </div>
        <div class="flex items-center gap-6">
            <a href="login" class="bg-primary text-white px-5 py-2 transition-colors rounded-full hover:bg-accent">LOGIN</a>
            <div class="text-3xl cursor-pointer md:hidden z-50">
                <i class="fa-solid fa-bars" onclick="onToggleMenu(this)"></i>
            </div>
        </div>
    </nav>
</div>
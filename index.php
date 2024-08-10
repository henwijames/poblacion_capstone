<?php include 'partials/header.php'; ?>
<header class="home">
    <div class="container mx-auto md:px-[120px] px-6  py-6">
        <nav class="flex justify-between items-center">
            <div>
                <a href="index"><img src="assets/img/poblacionease.png" alt="poblacionease logo" class="w-[150px] h-[60px] max-[150px]:"></a>

            </div>

            <div class="hidden md:flex gap-x-6 text-[18px]">
                <div class=" text-[16px] ">
                    <a href="login" class=" bg-[#DEE197] hover:bg-[#C1C549] transition-all py-2 px-3 w-5 rounded-md uppercase shadow-md">Login</a>

                </div>
                <div class=" text-[16px] ">
                    <a href="choose" class=" hover:bg-[#DEE197] transition-all bg-[#C1C549] py-2 px-3 w-5 rounded-md uppercase shadow-md">Sign up</a>

                </div>
            </div>

            <button id="menu-toggle" class="md:hidden text-gray-800 focus:outline-none">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </nav>
    </div>

    <div class="banner container mx-auto md:px-[120px] px-6 gap-0 mt-[20px]">
        <div class="text-banner flex flex-col justify-center w-[300px] md:w-[730px] h-[500px] ">
            <p class=" uppercase font-bold text-[16px] leading-[20px] mb-1">welcome to poblacion<span class="text-[#C1C549]">ease</span></p>
            <h1 class=" uppercase font-bold text-[30px] md:text-[65px] leading-[30px] md:leading-[75px] ">Discover a New Era of Convenience and Connection</h1>
            <p class="text-[16px] md:text-[24px]">Experience effortless living in Poblacion, Taal with Poblacion<span class="text-[#C1C549]">Ease</span>. Discover apartments, connect with local businesses, and embrace community. Your gateway to convenience in Batangas.</p>

            <a href="" class="flex items-center justify-between w-[213px] bg-[#C1C549] 
            px-3 py-3 md:px-5 md:py-5 text-white font-bold mt-[32px] rounded-[5px] hover:bg-[#DEE197] 
            hover:text-black transition-all ease-in shadow-md">
                FIND PROPERTIES
                <i class="fa-solid fa-chevron-right text-white"></i>
            </a>
        </div>

    </div>
</header>
<div class="">
    <h1>HI guys</h1>
</div>

<script src="assets/js/script.js"></script>
<?php include 'partials/footer.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PoblacionEase</title>

    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://kit.fontawesome.com/f284e8c7c2.js" crossorigin="anonymous"></script>
</head>

<body class="font-custom">
    <header class="home">
        <div class="container mx-auto px-6 py-6">
            <nav class="flex justify-between items-center">
                <div class="font-bold text-[20px] ">
                    <a href="index">Poblacion<span class="text-[#C1C549]">Ease</span></a>

                </div>

                <div class="hidden md:flex gap-x-6 text-[18px]">
                    <div class="flex gap-x-6 items-center">
                        <a href="#" class="text-gray-800 hover:text-[#C1C549] transition-all ease-in">Home</a>
                        <a href="#" class="text-gray-800 hover:text-[#C1C549] transition-all ease-in">About Us</a>
                        <a href="#" class="text-gray-800 hover:text-[#C1C549] transition-all ease-in">Services</a>
                        <a href="#" class="text-gray-800 hover:text-[#C1C549] transition-all ease-in">Testimonials</a>
                        <a href="#" class="text-gray-800 hover:text-[#C1C549] transition-all ease-in">Contact Us</a>
                    </div>


                    <div class="font-bold text-[20px] ">
                        <a href="#" class="text-gray-800 hover:text-[#C1C549] transition-all">Login / Signup</a>

                    </div>
                </div>



                <button id="menu-toggle" class="md:hidden text-gray-800 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </nav>
        </div>
        <div id="menu" class="hidden md:hidden bg-[#C1C549] w-screen">
            <a href="#" class="block text-gray-800 hover:text-yellow-500 py-2">Home</a>
            <a href="#" class="block text-gray-800 hover:text-yellow-500 py-2">Properties</a>
            <a href="#" class="block text-gray-800 hover:text-yellow-500 py-2">About Us</a>
            <a href="#" class="block text-gray-800 hover:text-yellow-500 py-2">Services</a>
            <a href="#" class="block text-gray-800 hover:text-yellow-500 py-2">Agents</a>
            <a href="#" class="block text-gray-800 hover:text-yellow-500 py-2">Contact Us</a>
            <a href="#" class="block text-gray-800 hover:text-yellow-500 py-2">Blog</a>
            <a href="#" class="block text-gray-800 hover:text-yellow-500 py-2">FAQs</a>
            <a href="#" class="block text-gray-800 hover:text-yellow-500 py-2">Testimonials</a>
            <a href="#" class="block text-gray-800 hover:text-yellow-500 py-2">Login / Signup</a>
            <a href="#" class="block text-gray-800 hover:text-yellow-500 py-2">Search</a>
        </div>

        <div class="banner container mx-auto px-6 gap-0 mt-[60px]">
            <div class="text-banner flex flex-col justify-center w-[300px] md:w-[730px] h-[500px] ">
                <p class=" uppercase font-bold text-[16px] leading-[20px] mb-1">welcome to poblacion<span class="text-[#C1C549]">ease</span></p>
                <h1 class=" uppercase font-bold text-[30px] md:text-[64px] leading-[30px] md:leading-[75px] ">Discover a New Era of Convenience and Connection</h1>
                <p class="text-[16px] md:text-[24px]">Experience effortless living in Poblacion, Taal with Poblacion<span class="text-[#C1C549]">Ease</span>. Discover apartments, connect with local businesses, and embrace community. Your gateway to convenience in Batangas.</p>

                <a href="" class="flex items-center justify-between w-[213px] bg-[#C1C549] px-3 py-3 md:px-5 md:py-5 text-white font-bold mt-[32px] rounded-[5px] hover:bg-[#DEE197] transition-all ease-in">FIND PROPERTIES <i class="fa-solid fa-chevron-right text-white"></i></a>



            </div>

        </div>
    </header>

    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
            var menu = document.getElementById('menu');
            menu.classList.toggle('hidden');
        });
    </script>
</body>

</html>
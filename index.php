<?php include 'partials/header.php';
require 'vendor/autoload.php'; // Ensure this path is correct
use Dotenv\Dotenv;

// Specify the path to your .env file
$dotenv = Dotenv::createImmutable(__DIR__); // Change __DIR__ if your .env is in another directory
$dotenv->load();
?>

<main class="font-custom">

    <header class="home">
        <!-- Navigation Bar -->
        <nav class="py-2 sticky top-0 px-5 md:px-[120px]  md:flex items-center justify-between bg-background shadow" style="z-index: 100;">
            <div class="flex justify-between items-center">
                <img src="assets/img/poblacionease.png" alt="logo" class="w-[150px]">
                <span class="text-3xl cursor-pointer md:hidden block">
                    <i class="fa-solid fa-bars" onclick="onToggleMenu(this)"></i>
                </span>
            </div>
            <ul id="menu" class="md:flex md:items-center gap-4 z-1 md:z-auto md:static absolute 
            bg-background w-full left-0 md:w-auto md:py-0 py-4 md:pl-0 pl-7 md:opacity-100 
            opacity-0 top-[-400px] transition-all ease-in duration-500" style="z-index: 50;">
                <li class="my-6 md:my-0 ">
                    <a href="index" class="text-xl hover:text-primary duration-500">Home</a>
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
        <!-- Navigation bar end -->


        <div class=" banner container mx-auto md:px-[60px] px-6 gap-0 mt-[60px]">
            <div class="text-banner flex flex-col justify-center w-[300px] md:w-[730px] h-[500px] ">
                <p class=" uppercase font-bold text-[16px] leading-[20px] mb-1" data-aos="fade-right" data-aos-delay="50" data-aos-duration="1000">welcome to poblacion<span class="text-[#C1C549]">ease</span></p>
                <h1 class=" uppercase font-bold text-[30px] md:text-[65px] leading-[30px] md:leading-[75px] " data-aos="fade-right" data-aos-delay="100" data-aos-duration="1050">Discover a New Era of Convenience and Connection</h1>
                <p class="text-[16px] md:text-[24px]" data-aos="fade-right" data-aos-delay="150" data-aos-duration="1100">Experience effortless living in Poblacion, Taal with Poblacion<span class="text-[#C1C549]">Ease</span>. Discover apartments, connect with local businesses, and embrace community. Your gateway to convenience in Batangas.</p>

                <a href="login" class="flex items-center justify-between w-[213px] bg-primary 
                px-3 py-3 md:px-5 md:py-5 text-white font-bold mt-[32px] rounded-[5px] hover:bg-accent 
                 transition-all ease-in shadow-md" data-aos="fade-right" data-aos-delay="200">
                    FIND PROPERTIES
                    <i class="fa-solid fa-chevron-right text-white"></i>
                </a>
            </div>

        </div>
    </header>
    <section class="w-full py-12 md:py-24 lg:py-32 bg-background" id="about">
        <div class="grid items-center justify-center gap-4 px-4  text-center md:px-6 lg:gap-10">
            <div class="space-y-3">
                <h2 class="text-4xl font-bold tracking-tighter md:text-4xl/tight">About <span class="text-primary">Us</span></h2>
                <p class="mx-auto max-w-[600px] text-muted-foreground md:text-xl/relaxed lg:text-base/relaxed xl:text-xl/relaxed">
                    Welcome to PoblacionEase! We make it easy for you to find the perfect apartment or business space.
                    Our website helps you connect with great rental options that fit what you're looking for.
                </p>
                <h2 class="text-2xl font-bold tracking-tighter md:text-2xl/tight">Our <span class="text-primary">Mission</span></h2>
                <p class="mx-auto max-w-[600px] text-muted-foreground md:text-xl/relaxed lg:text-base/relaxed xl:text-lg/relaxed">

                    Our goal is to make finding a rental quick and easy. Whether you need a comfy apartment or a spacious office, we're here to help you every step of the way.
                </p>
            </div>
            <div class="mx-auto w-full max-w-sm space-y-2">
                <a
                    class="inline-flex h-10 items-center justify-center rounded-md bg-primary hover:bg-accent px-8 text-sm font-medium text-primary-foreground shadow transition-colors  focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
                    href="#"
                    rel="ugc">
                    Learn More
                </a>
            </div>
        </div>
    </section>

</main>
<script>
    function onToggleMenu(e) {
        let list = document.querySelector("ul");

        if (e.classList.contains("fa-bars")) {
            e.classList.replace("fa-bars", "fa-times");
            list.classList.add("top-[70px]", "opacity-100");
        } else {
            e.classList.replace("fa-times", "fa-bars");
            list.classList.remove("top-[70px]", "opacity-100");
        }
    }
</script>
<?php include 'partials/footer.php'; ?>
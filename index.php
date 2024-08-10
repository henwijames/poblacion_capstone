<?php include 'partials/header.php'; ?>
<header class="home">
    <div class="container mx-auto md:px-[120px] px-6  py-6">
        <nav class="flex justify-between items-center">
            <div>
                <a href="index"><img src="assets/img/poblacionease.png" alt="poblacionease logo" class="w-[150px] h-[60px]"></a>

            </div>

            <div class="flex gap-x-6 text-[18px]">
                <div class=" text-[16px] ">
                    <a href="login" class=" bg-[#DEE197] hover:bg-[#C1C549] transition-all py-2 px-3 w-5 rounded-md uppercase shadow-md">Login</a>

                </div>
                <div class=" text-[16px] ">
                    <a href="choose" class=" hover:bg-[#DEE197] transition-all bg-[#C1C549] py-2 px-3 w-5 rounded-md uppercase shadow-md">Sign up</a>

                </div>
            </div>
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
<section class="py-12 md:py-20 lg:py-24">
    <div class="container mx-auto px-4 md:px-6">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-3xl font-bold md:text-4xl lg:text-5xl">Featured Listings</h2>
            <p class="mt-4 text-lg text-muted-foreground md:text-xl">Check out our top-rated properties.</p>
        </div>
        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            <div class="rounded-lg border bg-card text-card-foreground shadow-sm" data-v0-t="card">
                <img
                    src="/placeholder.svg"
                    alt="Featured Listing 1"
                    width="400"
                    height="300"
                    class="rounded-t-md object-cover w-full h-60"
                    style="aspect-ratio: 400 / 300; object-fit: cover;" />
                <div class="p-4">
                    <h3 class="text-lg font-semibold">Luxury Penthouse in Downtown</h3>
                    <p class="mt-2 text-muted-foreground">3 Bedrooms, 2 Bathrooms</p>
                    <p class="mt-3 font-bold">$1,200,000</p>
                    <div class="mt-4">
                        <a class="text-primary bg-[#C1C549] px-5 py-2 border border-[#C1C549] rounded-md hover:bg-white" href="#" rel="ugc">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
            <div class="rounded-lg border bg-card text-card-foreground shadow-sm" data-v0-t="card">
                <img
                    src="/placeholder.svg"
                    alt="Featured Listing 2"
                    width="400"
                    height="300"
                    class="rounded-t-md object-cover w-full h-60"
                    style="aspect-ratio: 400 / 300; object-fit: cover;" />
                <div class="p-4">
                    <h3 class="text-lg font-semibold">Cozy Bungalow in the Suburbs</h3>
                    <p class="mt-2 text-muted-foreground">2 Bedrooms, 1 Bathroom</p>
                    <p class="mt-4 font-bold">$450,000</p>
                    <div class="mt-4">
                        <a class="text-primary hover:underline" href="#" rel="ugc">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
            <div class="rounded-lg border bg-card text-card-foreground shadow-sm" data-v0-t="card">
                <img
                    src="/placeholder.svg"
                    alt="Featured Listing 3"
                    width="400"
                    height="300"
                    class="rounded-t-md object-cover w-full h-60"
                    style="aspect-ratio: 400 / 300; object-fit: cover;" />
                <div class="p-4">
                    <h3 class="text-lg font-semibold">Modern Townhouse in the City</h3>
                    <p class="mt-2 text-muted-foreground">3 Bedrooms, 2.5 Bathrooms</p>
                    <p class="mt-4 font-bold">$800,000</p>
                    <div class="mt-4">
                        <a class="text-primary hover:underline" href="#" rel="ugc">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="assets/js/script.js"></script>
<?php include 'partials/footer.php'; ?>
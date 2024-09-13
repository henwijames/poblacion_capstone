<?php include 'includes/header.php'; ?>
<nav class="shadow py-2 z-20 sticky top-0 px-5 md:px-[120px]  md:flex items-center justify-between bg-background ">
    <div class="flex justify-between items-center">
        <a href="index">
            <img src="../assets/img/poblacionease.png" alt="logo" class="w-[150px]">
        </a>
        <span class="text-3xl cursor-pointer md:hidden block">
            <i class="fa-solid fa-bars" onclick="onToggleMenu(this)"></i>
        </span>
    </div>
    <ul id="menu" class="md:flex md:items-center gap-4 md:z-auto  md:static absolute 
            bg-background w-full left-0 md:w-auto md:py-0 py-4 md:pl-0 pl-7 md:opacity-100 
            opacity-0 top-[-400px] transition-all ease-in duration-500" style="z-index: -1;">
        <li class="my-6 md:my-0 ">
            <a href="index" class="text-lg hover:text-primary duration-500">Home</a>
        </li>
        <li class="my-6 md:my-0 ">
            <a href="#about" class="text-lg hover:text-primary duration-500">About Us</a>
        </li>
        <li class="my-6 md:my-0 ">
            <a href="#book" class="text-lg hover:text-primary duration-500">Book Now!</a>
        </li>
        <a class="profile-name md:hidden flex items-center hover:text-primary duration-50 ease-in transition-colors" href="profile">
            <img src="../assets/img/me.jpg" alt="profile-picture" class="cursor-pointer rounded-full" style="width: 50px; height: 50px; margin-right: 20px;">
            <p class="text-lg " href="#">John Doe</p>
        </a>
    </ul>
    <a class="profile-name md:flex hidden md:items-center hover:text-primary duration-50 ease-in transition-colors" href="profile">
        <img src="<?php echo $profilePicture; ?>" alt="profile-picture" class=" rounded-full" style="width: 50px; height: 50px; margin-right: 20px;">
        <p class="text-lg hover:text-primary duration-500" href="#"><?php echo htmlspecialchars($userName); ?></p>
    </a>
</nav>
<section class="bg-background h-screen" id="apartment">
    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20" id="about">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div>
                <div class="mb-6">
                    <h1 class="text-3xl font-bold mb-2">Luxury Apartment in Downtown</h1>
                    <p class="text-muted-foreground">123 Main St, Anytown USA</p>
                </div>
                <div class="mb-6">
                    <h2 class="text-xl font-bold mb-2">Landlord</h2>
                    <p class="text-muted-foreground">Henry James Ribano</p>
                    <p class="text-muted-foreground">Phone : 09691756860</p>
                </div>
                <div class="mb-6">
                    <h2 class="text-xl font-bold mb-2">Amenities</h2>
                    <ul class="grid grid-cols-2 gap-4">
                        <li class="flex items-center gap-2">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="w-5 h-5 text-primary">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="m9 12 2 2 4-4"></path>
                            </svg>
                            <span>Hardwood Floors</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="w-5 h-5 text-primary">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="m9 12 2 2 4-4"></path>
                            </svg>
                            <span>Stainless Steel Appliances</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="w-5 h-5 text-primary">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="m9 12 2 2 4-4"></path>
                            </svg>
                            <span>In-Unit Laundry</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="w-5 h-5 text-primary">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="m9 12 2 2 4-4"></path>
                            </svg>
                            <span>Balcony</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="w-5 h-5 text-primary">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="m9 12 2 2 4-4"></path>
                            </svg>
                            <span>Gym</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="w-5 h-5 text-primary">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="m9 12 2 2 4-4"></path>
                            </svg>
                            <span>Parking</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <img
                    src="../assets/img/1.jpg"
                    alt="Apartment Image"
                    width="300"
                    height="200"
                    class="rounded-lg object-cover shadow-lg"
                    style="aspect-ratio: 300 / 200; object-fit: cover;" />
                <img
                    src="../assets/img/2.jpg"
                    alt="Apartment Image"
                    width="300"
                    height="200"
                    class="rounded-lg object-cover shadow-lg"
                    style="aspect-ratio: 300 / 200; object-fit: cover;" />
                <img
                    src="../assets/img/3.jpg"
                    alt="Apartment Image"
                    width="300"
                    height="200"
                    class="rounded-lg object-cover shadow-lg"
                    style="aspect-ratio: 300 / 200; object-fit: cover;" />
                <img
                    src="../assets/img/4.jpg"
                    alt="Apartment Image"
                    width="300"
                    height="200"
                    class="rounded-lg object-cover shadow-lg"
                    style="aspect-ratio: 300 / 200; object-fit: cover;" />
            </div>
        </div>
    </main>
</section>

<?php include 'includes/footer.php'; ?>
<?php include 'partials/header.php'; ?>
<!--
    // v0 by Vercel.
    // https://v0.dev/t/LHuSwBBAIzg
-->

<div class="w-full flex flex-col justify-center items-center">
    <div class="container mx-auto md:px-[120px] mb-4 px-6 py-2">
        <nav class="flex justify-between items-center mb-2">
            <a href="../index"><img src="../assets/img/poblacionease.png" alt="Poblacionease logo" class="w-[150px] h-[60px]"></a>
            <div class="flex gap-x-6 text-[18px]">
                <div class=" text-[16px] ">
                    <a href="../login" class=" bg-[#DEE197] hover:bg-[#C1C549] transition-all py-2 px-3 w-5 rounded-md uppercase shadow-md">Login</a>

                </div>
                <div class=" text-[16px] ">
                    <a href="../choose" class=" hover:bg-[#DEE197] transition-all bg-[#C1C549] py-2 px-3 w-5 rounded-md uppercase shadow-md">Sign up</a>

                </div>
            </div>
        </nav>

    </div>
    <main class="flex items-center justify-center gap-8 px-8 w-full max-w-lg pb-4 mb-4">
        <div class=" flex flex-col items-center">
            <h1 class="text-4xl font-bold text-center mb-6">Sign up as a <span class="text-[#C1C549]">Tenant</span></h1>
            <form class="space-y-4 flex flex-col w-full gap-4">
                <div class="flex flex-col md:flex-row w-full justify-center items-center gap-4">
                    <div class="flex flex-col gap-2 w-full">
                        <label for="fname" class="text-md">First Name</label>
                        <input type="text" class="w-full p-2 border border-gray-300 rounded-md placeholder:font-light placeholder:text-gray-500" name="fname" id="fname" placeholder="First Name" required>
                    </div>
                    <div class="flex flex-col gap-2 w-full">
                        <label for="email" class="text-md">Last Name</label>
                        <input type="email" class="w-full p-2 border border-gray-300 rounded-md placeholder:font-light placeholder:text-gray-500" name="email" id="email" placeholder="johndoe@email.com" required>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row w-full justify-center items-center gap-4">
                    <div class="flex flex-col gap-2 w-full">
                        <label for="fname" class="text-md">Email</label>
                        <input type="text" class="w-full p-2 border border-gray-300 rounded-md placeholder:font-light placeholder:text-gray-500" name="email" id="email" placeholder="johndoe@gmail.com" required>
                    </div>
                    <div class="flex flex-col gap-2 w-full">
                        <label for="address" class="text-md">Address</label>
                        <input type="text" class="w-full p-2 border border-gray-300 rounded-md placeholder:font-light placeholder:text-gray-500" name="address" id="address" placeholder="Poblacion 4, Taal, Batangas" required>
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="phone" class="text-sm font-medium leading-none">Phone Number</label>
                    <input class="h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500" id="phone" type="phone" placeholder="(+63)" required>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="id-file" class="text-sm font-medium leading-none">Valid ID</label>
                    <div class="flex items-center gap-4">
                        <input class="h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500" id="id-file" type="file" required>
                        <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 border border-gray-300 bg-white hover:bg-gray-100 h-10 px-4 py-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 h-4 w-4">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line x1="12" x2="12" y1="15" y2="3"></line>
                            </svg>
                            Upload
                        </button>
                    </div>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="password" class="text-sm font-medium leading-none">Password</label>
                    <input class="h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500" id="password" name="password" placeholder="Password" type="password" required>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="confirm" class="text-sm font-medium leading-none">Confirm Password</label>
                    <input class="h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500" id="confirm" name="confirm" placeholder="Confirm Password" type="password" required>
                </div>

                <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 h-10 px-4 py-2 w-full border border-[#C1C549] bg-[#C1C549] hover:bg-white" type="submit">
                    Sign Up
                </button>
            </form>
        </div>
    </main>
</div>
<?php include 'partials/footer.php'; ?>
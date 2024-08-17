<?php include 'includes/header.php'; ?>
<div class="w-full flex flex-col justify-center items-center">
    <div class="container mx-auto md:px-[120px] mb-4 px-6 py-2">
        <nav class="flex justify-between items-center mb-2">
            <a href="../index"><img src="../assets/img/poblacionease.png" alt="Poblacionease logo" class="w-[150px] h-[60px]"></a>
            <div class="flex gap-4 text-[18px]">
                <div class=" text-[16px] ">
                    <a href="../login" class=" bg-primary hover:bg-accent transition-all py-2 px-3 w-5 rounded-md uppercase shadow-md">Login</a>

                </div>
                <div class=" text-[16px] ">
                    <a href="../choose" class=" hover:bg-accent transition-all bg-primary py-2 px-3 w-5 rounded-md uppercase shadow-md">Sign up</a>

                </div>
            </div>
        </nav>

    </div>
    <main class="flex items-center justify-center gap-8 px-8 w-full max-w-lg pb-4 mb-4">
        <div class=" flex flex-col items-center">
            <h1 class="text-4xl font-bold text-center mb-6">Sign up as a <span class="text-[#C1C549]">Landlord</span></h1>
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
                    <label for="password" class="text-sm font-medium leading-none">Password</label>
                    <input class="h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500" id="password" name="password" placeholder="Password" type="password" required>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="confirm" class="text-sm font-medium leading-none">Confirm Password</label>
                    <input class="h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500" id="confirm" name="confirm" placeholder="Confirm Password" type="password" required>
                </div>

                <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 h-10 px-4 py-2 w-full border border-[#C1C549] bg-primary hover:bg-accent" type="submit">
                    Sign Up
                </button>
            </form>
        </div>
    </main>
</div>
<?php include 'includes/footer.php'; ?>
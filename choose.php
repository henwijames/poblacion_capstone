<?php include 'partials/header.php'; ?>
<header class="home min-h-screen">
    <div class="container mx-auto md:px-[120px] px-6 py-6">
        <nav class="flex justify-center items-center">
            <div>
                <a href="index"><img src="assets/img/poblacionease.png" alt="poblacionease logo" class="w-[150px] h-[60px]"></a>

            </div>
        </nav>
    </div>
    <main class="flex flex-col justify-center items-center gap-y-7 ">

        <h1 class="font-bold text-4xl uppercase">Select your role</h1>
        <div class="flex flex-col md:flex-row gap-4">
            <a href="landlordSignup" class="bg-white p-8 rounded-lg w-[200px] h-[200px] md:w-[400px] md:h-[400px] shadow-lg flex flex-col items-center justify-center hover:bg-[#DEE197] transition-all ease focus:ring-2 focus:ring-[#C1C549]">
                <img src="assets/img/landlord.png" alt="landlord" class="w-full h-full mb-2">
                <h1 class="font-semibold text-lg">Landlord</h1>
            </a>
            <a href="signupTenants" class="bg-white p-8 rounded-lg w-[200px] h-[200px] md:w-[400px] md:h-[400px] shadow-lg flex flex-col items-center justify-center hover:bg-[#DEE197] transition-all ease focus:ring-2 focus:ring-[#C1C549]">
                <img src="assets/img/findhouse.png" alt="tenant" class="w-full h-full mb-2">
                <h1 class="font-semibold text-lg">Tenant</h1>
            </a>
        </div>
    </main>
</header>

<?php include 'partials/footer.php'; ?>
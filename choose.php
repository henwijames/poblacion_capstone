<?php include 'partials/header.php'; ?>
<main class="home flex flex-col justify-center items-center gap-y-7 min-h-screen">
    <h1 class="font-bold text-4xl">Select your role</h1>
    <div class="flex flex-col md:flex-row gap-4">
        <a href="landlords/signup" class="bg-white p-8 rounded-lg w-[250px] h-[250px] md:w-[400px] md:h-[400px] shadow-lg flex flex-col items-center justify-center hover:bg-[#DEE197] transition-all ease focus:ring-2 focus:ring-[#C1C549]">
            <img src="assets/img/landlord.png" alt="landlord" class="w-full h-full mb-2">
            <h1 class="font-semibold text-lg">Landlord</h1>
        </a>
        <a href="tenants/signup" class="bg-white p-8 rounded-lg w-[250px] h-[250px] md:w-[400px] md:h-[400px] shadow-lg flex flex-col items-center justify-center hover:bg-[#DEE197] transition-all ease focus:ring-2 focus:ring-[#C1C549]">
            <img src="assets/img/findhouse.png" alt="tenant" class="w-full h-full mb-2">
            <h1 class="font-semibold text-lg">Tenant</h1>
        </a>
    </div>
</main>
<?php include 'partials/footer.php'; ?>
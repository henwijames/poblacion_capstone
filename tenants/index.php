<?php
include 'includes/header.php';
?>
<nav class="shadow py-2 z-20 sticky top-0 px-5 md:px-[120px]  md:flex items-center justify-between bg-background ">
    <div class="flex justify-between items-center">
        <img src="../assets/img/poblacionease.png" alt="logo" class="w-[150px]">
        <span class="text-3xl cursor-pointer md:hidden block">
            <i class="fa-solid fa-bars" onclick="onToggleMenu(this)"></i>
        </span>
    </div>
    <ul id="menu" class="md:flex md:items-center gap-4 md:z-auto  md:static absolute 
            bg-background w-full left-0 md:w-auto md:py-0 py-4 md:pl-0 pl-7 md:opacity-100 
            opacity-0 top-[-400px] transition-all ease-in duration-500" style="z-index: -1;">
        <li class="my-6 md:my-0 ">
            <a href="index" class="text-lg hover:text-primary duration-500">Apartments</a>
        </li>
        <li class="my-6 md:my-0 ">
            <a href="#rent" class="text-lg hover:text-primary duration-500">Commercial</a>
        </li>
        <li class="my-6 md:my-0 ">
            <a href="#about" class="text-lg hover:text-primary duration-500">Find Agent</a>
        </li>
        <a class="profile-name md:hidden flex items-center hover:text-primary duration-50 ease-in transition-colors" href="profile">
            <img src="../assets/img/me.jpg" alt="profile-picture" class="cursor-pointer rounded-full" style="width: 50px; height: 50px; margin-right: 20px;">
            <p class="text-lg " href="#">John Doe</p>
        </a>
    </ul>
    <a class="profile-name md:flex hidden md:items-center hover:text-primary duration-50 ease-in transition-colors" href="profile">
        <img src="../assets/img/me.jpg" alt="profile-picture" class=" rounded-full" style="width: 50px; height: 50px; margin-right: 20px;">
        <p class="text-lg hover:text-primary duration-500" href="#">John Doe</p>
    </a>
</nav>
<section class="relative h-[500px] tenants-home" style="background-image: url('../assets/img/bg.png'); z-index: 0; background-size: cover; background-position: center;">
    <div class="container mx-auto flex flex-col justify-center items-center text-center h-full px-4 text-[20px]">
        <h1 class="text-4xl font-bold">Discover a New Era of Convenience and Connection</h1>
        <p class="mt-4 mb-4 text-base md:text-lg">Experience effortless living in Poblacion, Taal with Poblacion<span class="text-primary">Ease</span>.</p>

        <div class="flex flex-col md:flex-row items-center gap-4 mt-4 w-full max-w-xl">
            <div class="w-full">
                <select class="shadow px-3 py-3 w-full md:w-[100px] rounded-lg md:rounded-l-lg">
                    <option value="">Choose Barangay</option>
                </select>
            </div>
            <div class="w-full">
                <select class="shadow px-3 py-3 w-full md:w-[100px] rounded-lg md:rounded-l-lg">
                    <option value="">Choose Rental Term</option>
                    <option value="">Long Term Rentals</option>
                    <option value="">Short Term Rentals</option>
                    <option value="">Daily Rentals</option>
                </select>
            </div>
            <button class="bg-primary text-white p-2 w-full md:w-auto rounded-lg md:rounded-r-lg hover:bg-accent">Search</button>
        </div>
    </div>
</section>



<script>
    function onToggleMenu(e) {
        let list = document.getElementById("menu");

        if (e.classList.contains("fa-bars")) {
            e.classList.replace("fa-bars", "fa-times");
            list.classList.add("top-[70px]", "opacity-100");
        } else {
            e.classList.replace("fa-times", "fa-bars");
            list.classList.remove("top-[70px]", "opacity-100");
        }
    }
</script>
<?php include 'includes/footer.php'; ?>
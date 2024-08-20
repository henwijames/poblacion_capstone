<?php
include 'includes/header.php';
?>
<nav class="shadow py-2 sticky top-0 px-5 md:px-[120px]  md:flex items-center justify-between bg-background ">
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
        <a class="profile-name md:hidden flex items-center hover:text-primary duration-500" href="profile">
            <img src="../assets/img/me.jpg" alt="profile-picture" class="cursor-pointer rounded-full" style="width: 50px; height: 50px; margin-right: 20px;">
            <p class="text-lg " href="#">John Doe</p>
        </a>
    </ul>
    <div class="profile-name md:flex hidden md:items-center">
        <img src="../assets/img/me.jpg" alt="profile-picture" class=" rounded-full" style="width: 50px; height: 50px; margin-right: 20px;">
        <a class="text-lg hover:text-primary duration-500" href="#">John Doe</a>
    </div>
</nav>
<section class="relative h-[500px] z-0" style="background-image: url('../assets/img/bg.png');  background-size: cover; z-index: -2;">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    <div class="relative container mx-auto flex flex-col justify-center items-center text-center h-full">
        <h1 class="text-4xl font-bold">Find your next home that suits you</h1>
        <p class="mt-4  mb-4">Easy to use. Convenient. All in one place.</p>

        <div class="mt-10 border border-primary md:px-0 py-3 md:py-6 px-3   " style="border: 1px solid black;">
            <select class="bg-white text-black  rounded border select-input">
                <option>Choose Location</option>
                <!-- Add more options here -->
            </select>
            <select class="bg-white text-black py-2 rounded select-input">
                <option>Long Term Rentals</option>
                <!-- Add more options here -->
            </select>
            <button class="bg-primary  px-6 py-2 rounded-full text-white">Search</button>
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
<!DOCTYPE html>
<?php
// session_start();
// include 'session.php';
?>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PoblacionEase</title>

    <link rel="stylesheet" href="assets/css/style.css">

    <!-- FontAwesome CDN -->
    <script src="https://kit.fontawesome.com/f284e8c7c2.js" crossorigin="anonymous"></script>

    <!-- JQuery File -->
    <script src="../assets/js/jquery-3.7.1.min.js"></script>
</head>

<body>

    <div class="fixed left-0 top-0 w-64 h-full bg-background p-4 z-50 sidebar-menu transition-transform ">
        <a href="#" class="flex justify-center items-center pb-4 border-b border-b-black">
            <img src="../assets/img/poblacionease.png" alt="" class="w-36 object-cover">
        </a>
        <ul class="mt-4">
            <li class="mb-1 group <?php echo ($page == 'test') ? 'active' : ''; ?>"">
                <a href=" test" class=" flex items-center py-2 px-3 rounded-md hover:text-white hover:bg-primary group-[.active]:bg-primary group-[.active]:text-white group-[.selected]:bg-primary group-[.selected]:text-white ">
                <i class="fa-solid fa-house mr-3 text-lg"></i>
                <span>Dashboard</span>
                </a>
            </li>
            <li class="mb-1 group <?php echo ($page == 'listings') ? 'active' : ''; ?>">
                <a href="#" class="flex items-center py-2 px-3 rounded-md hover:text-white hover:bg-primary group-[.active]:bg-primary group-[.active]:text-white sidebar-dropdown-toggle group-[.selected]:bg-primary group-[.selected]:text-white">
                    <i class="fa-solid fa-sign-hanging mr-3 text-lg"></i>
                    <span>Listings</span>
                    <i class="fa-solid fa-chevron-right ml-auto group-[.selected]:rotate-90"></i>
                </a>
                <ul class="pl-7 mt-2 hidden group-[.selected]:block ">
                    <li class="mb-4">
                        <a href="#" class="text-sm flex items-center dot hover:text-primary">Add Listings</a>
                    </li>
                    <li class="mb-4">
                        <a href="listings" class="text-sm flex items-center dot hover:text-primary">Active Listings</a>
                    </li>
                </ul>
            </li>
            <li class="mb-1 group">
                <a href="#" class="flex items-center py-2 px-3 rounded-md hover:text-white hover:bg-primary group-[.active]:bg-primary group-[.active]:text-white sidebar-dropdown-toggle group-[.selected]:bg-primary group-[.selected]:text-white">
                    <i class="fa-solid fa-key mr-3 text-lg"></i>
                    <span>Rent</span>
                    <i class="fa-solid fa-chevron-right ml-auto group-[.selected]:rotate-90"></i>
                </a>
                <ul class="pl-7 mt-2 hidden group-[.selected]:block">
                    <li class="mb-4">
                        <a href="#" class="text-sm flex items-center dot hover:text-primary">Rents</a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="text-sm flex items-center dot hover:text-primary">Tenants</a>
                    </li>
                </ul>
            </li>
            <li class="mb-1 group">
                <a href="#" class="flex items-center py-2 px-3 rounded-md hover:text-white hover:bg-primary group-[.active]:bg-primary group-[.active]:text-white group-[.selected]:bg-primary group-[.selected]:text-white sidebar-dropdown-toggle">
                    <i class="fa-solid fa-money-bill mr-3 text-lg"></i>
                    <span>Payment</span>
                    <i class="fa-solid fa-chevron-right ml-auto group-[.selected]:rotate-90"></i>

                </a>
                <ul class="pl-7 mt-2 hidden group-[.selected]:block">
                    <li class="mb-4">
                        <a href="#" class="text-sm flex items-center dot hover:text-primary">Transactions</a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="text-sm flex items-center dot hover:text-primary">Tenants Balance</a>
                    </li>
                </ul>
            </li>
            <li class="mb-1 group">
                <a href="#" class="flex items-center py-2 px-3 rounded-md hover:text-white hover:bg-primary group-[.active]:bg-primary group-[.active]:text-white group-[.selected]:bg-primary group-[.selected]:text-white">
                    <i class="fa-solid fa-gears mr-3 text-lg"></i>
                    <span>Settings</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="py-2 px-4 flex items-center shadow-md shadow-black/5 sticky top-0 left-0  z-50 bg-white">
        <button type="button" class="text-lg sidebar-toggle">
            <i class="fa-solid fa-bars"></i>
        </button>
        <ul class="flex items-center ml-4">
            <li class="mr-2">
                <a id="breadcrumb" href="index" class="text-sm text-gray-600">Dashboard</a>
            </li>
        </ul>
        <ul class="ml-auto flex items-center ">
            <li class="mr-1 dropdown relative flex items-center gap-4">
                <span class="hidden md:flex text-gray-400"></span>
                <button type="button" class="dropdown-toggle text-gray-400 w-8 h-8 rounded flex items-center justify-center hover:bg-gray-50 hover:text-gray-600">

                    <i class="fa-solid fa-user mr-2"></i>
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
                <ul class="dropdown-menu hidden shadow-md py-1.5 rounded-md bg-white border-gray-100 w-[140px] font-medium absolute top-full right-4 mt-2 z-10">
                    <li>
                        <a href="profile" class="flex items-center text-[13px] py-1.5 px-4 hover:bg-gray-100">Profile</a>
                    </li>
                    <li>
                        <a href="settings" class="flex items-center text-[13px] py-1.5 px-4 hover:bg-gray-100">Settings</a>
                    </li>
                    <li>
                        <a href="logout" class="flex items-center text-[13px] py-1.5 px-4 hover:bg-gray-100">Logout</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <main class="main-content main">
        <?php include 'includes/topbar.php'; ?>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <div class="bg-background rounded-md shadow-md border border-gray-100 p-6">
                    <div class="flex justify-between">
                        <div>
                            <div class="text-2xl font-semibold mb-1">10</div>
                            <div class="text-sm font-medium text-gray-400">Active Listings</div>
                        </div>
                        <div class="text-[40px]">
                            <i class="fa-solid fa-sign-hanging"></i>
                        </div>
                    </div>


                </div>
                <div class="bg-background rounded-md shadow-md border border-gray-100 p-6">
                    <div class="flex justify-between">
                        <div>
                            <div class="text-2xl font-semibold mb-1">40</div>
                            <div class="text-sm font-medium text-gray-400">Tenants</div>
                        </div>
                        <div class="text-[40px]">
                            <i class="fa-solid fa-person"></i>
                        </div>
                    </div>

                </div>
                <div class="bg-background rounded-md shadow-md border border-gray-100 p-6">
                    <div class="flex justify-between">
                        <div>
                            <div class="text-2xl font-semibold mb-1">23</div>
                            <div class="text-sm font-medium text-gray-400">Rents</div>
                        </div>
                        <div class="text-[40px]">
                            <i class="fa-solid fa-key"></i>
                        </div>
                    </div>

                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-background border border-gray-100 shadow-md shadow-black/10 p-6 rounded-md">
                    <div class="mb-4 flex justify-between items-start">
                        <div class="font-medium">Tenant</div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[540px] table-auto border-collapse shadow-lg">
                            <thead class="bg-slate-100">
                                <tr>
                                    <th class="text-[12px] uppercase tracking-wide font-semibold py-3 px-4 text-left text-slate-700">Name</th>
                                    <th class="text-[12px] uppercase tracking-wide font-semibold py-3 px-4 text-left text-slate-700">House Rented</th>
                                    <th class="text-[12px] uppercase tracking-wide font-semibold py-3 px-4 text-left text-slate-700">Monthly Rate</th>
                                    <th class="text-[12px] uppercase tracking-wide font-semibold py-3 px-4 text-left text-slate-700 rounded-tr-md">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white border-b hover:bg-slate-50 transition-colors">
                                    <td class="py-3 px-4 text-[13px] text-slate-600 font-medium">Henry James Ribano</td>
                                    <td class="py-3 px-4 text-[13px] text-slate-600 font-medium text-center">House 5</td>
                                    <td class="py-3 px-4 text-[13px] text-slate-600 font-medium text-center">P2,500</td>
                                    <td class="py-3 px-4">
                                        <span class="inline-block px-4 py-1 rounded-full text-sm bg-yellow-400 text-white">Pending</span>
                                    </td>
                                </tr>
                                <tr class="bg-white border-b hover:bg-slate-50 transition-colors">
                                    <td class="py-3 px-4 text-[13px] text-slate-600 font-medium">Juan Lorenzo Aguilar</td>
                                    <td class="py-3 px-4 text-[13px] text-slate-600 font-medium text-center">House 2</td>
                                    <td class="py-3 px-4 text-[13px] text-slate-600 font-medium text-center">P2,800</td>
                                    <td class="py-3 px-4">
                                        <span class="inline-block px-4 py-1 rounded-full text-sm bg-green-400 text-white">Verified</span>
                                    </td>
                                </tr>
                                <tr class="bg-white hover:bg-slate-50 transition-colors">
                                    <td class="py-3 px-4 text-[13px] text-slate-600 font-medium">John Michael Castor</td>
                                    <td class="py-3 px-4 text-[13px] text-slate-600 font-medium text-center">House 1</td>
                                    <td class="py-3 px-4 text-[13px] text-slate-600 font-medium text-center">P2,100</td>
                                    <td class="py-3 px-4">
                                        <span class="inline-block px-4 py-1 rounded-full text-sm bg-red-400 text-white">Banned</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
                <div class="bg-background border border-gray-100 shadow-md shadow-black/10 p-6 rounded-md">
                    <div class="mb-4 flex justify-between items-start">
                        <div class="font-medium">Listings</div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[540px] table-auto border-collapse shadow-lg">
                            <thead class="bg-slate-100">
                                <tr>
                                    <th class="text-[12px] uppercase tracking-wide font-semibold py-3 px-4 text-left text-slate-700">House</th>
                                    <th class="text-[12px] uppercase tracking-wide font-semibold py-3 px-4 text-left text-slate-700">Monthly Rent</th>
                                    <th class="text-[12px] uppercase tracking-wide font-semibold py-3 px-4 text-left text-slate-700">House Type</th>
                                    <th class="text-[12px] uppercase tracking-wide font-semibold py-3 px-4 text-left text-slate-700 rounded-tr-md">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white border-b hover:bg-slate-50 transition-colors">
                                    <td class="py-3 px-4 text-[13px] text-slate-600 font-medium">Bahay Kubo</td>
                                    <td class="py-3 px-4 text-[13px] text-slate-600 font-medium text-center">P1,000</td>
                                    <td class="py-3 px-4 text-[13px] text-slate-600 font-medium text-center">Apartment</td>
                                    <td class="py-3 px-4 flex gap-2">
                                        <button class="inline-block px-4 py-1 rounded-md text-sm bg-blue-400 text-white">
                                            Edit
                                        </button>
                                        <button class="inline-block px-4 py-1 rounded-md text-sm bg-red-400 text-white">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                                <tr class="bg-white border-b hover:bg-slate-50 transition-colors">
                                    <td class="py-3 px-4 text-[13px] text-slate-600 font-medium">La Zanti</td>
                                    <td class="py-3 px-4 text-[13px] text-slate-600 font-medium text-center">P2,000</td>
                                    <td class="py-3 px-4 text-[13px] text-slate-600 font-medium text-center">Apartment</td>
                                    <td class="py-3 px-4 flex gap-2">
                                        <button class="inline-block px-4 py-1 rounded-md text-sm bg-blue-400 text-white">
                                            Edit
                                        </button>
                                        <button class="inline-block px-4 py-1 rounded-md text-sm bg-red-400 text-white">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                                <tr class="bg-white border-b hover:bg-slate-50 transition-colors">
                                    <td class="py-3 px-4 text-[13px] text-slate-600 font-medium">Valentinos</td>
                                    <td class="py-3 px-4 text-[13px] text-slate-600 font-medium text-center">P2,000</td>
                                    <td class="py-3 px-4 text-[13px] text-slate-600 font-medium text-center">Apartment</td>
                                    <td class="py-3 px-4 flex gap-2">
                                        <button class="inline-block px-4 py-1 rounded-md text-sm bg-blue-400 text-white">
                                            Edit
                                        </button>
                                        <button class="inline-block px-4 py-1 rounded-md text-sm bg-red-400 text-white">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </main>
    <div class="p-6">
        <section class="w-full overflow-hidden dark:bg-gray-900">
            <div class="flex flex-col">
                <!-- Cover Image -->
                <img src="https://images.unsplash.com/photo-1451187580459-43490279c0fa?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w0NzEyNjZ8MHwxfHNlYXJjaHw5fHxjb3ZlcnxlbnwwfDB8fHwxNzEwNzQxNzY0fDA&ixlib=rb-4.0.3&q=80&w=1080" alt="User Cover"
                    class="w-full h-auto max-h-[20rem] object-cover" />

                <!-- Profile Image and Name -->
                <div class="sm:w-[80%] xs:w-[90%] mx-auto flex flex-col items-center -mt-16">
                    <img src="https://images.unsplash.com/photo-1501196354995-cbb51c65aaea?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w0NzEyNjZ8MHwxfHNlYXJjaHw3fHxwZW9wbGV8ZW58MHwwfHx8MTcxMTExMTM4N3ww&ixlib=rb-4.0.3&q=80&w=1080" alt="User Profile"
                        class="rounded-md w-28 h-28 sm:w-32 sm:h-32 lg:w-48 lg:h-48 outline outline-2 outline-offset-2 outline-blue-500 relative" />

                    <h1 class="w-full text-center my-6 text-gray-800 dark:text-white text-2xl sm:text-3xl lg:text-4xl font-serif">
                        Samuel Abera</h1>
                </div>

                <!-- Details Section -->
                <div class="w-full px-4 md:px-6 lg:px-0 xl:w-[80%] lg:w-[90%] mx-auto flex flex-col gap-4 items-center relative -mt-6">
                    <!-- Description -->
                    <p class="w-full text-gray-700 dark:text-gray-400 text-sm sm:text-md md:text-lg text-center">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam debitis labore consectetur voluptatibus mollitia dolorem veniam omnis ut quibusdam minima sapiente repellendus asperiores explicabo, eligendi odit, dolore similique fugiat dolor, doloremque eveniet. Odit, consequatur. Ratione voluptate exercitationem hic eligendi vitae animi nam in, est earum culpa illum aliquam.</p>

                    <!-- Detail -->
                    <div class="w-full my-auto py-6 flex flex-col md:flex-row gap-4 justify-center">
                        <div class="w-full">
                            <dl class="text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                                <div class="flex flex-col pb-3">
                                    <dt class="mb-1 text-gray-500 text-md md:text-lg dark:text-gray-400">First Name</dt>
                                    <dd class="text-lg font-semibold">Samuel</dd>
                                </div>
                                <div class="flex flex-col py-3">
                                    <dt class="mb-1 text-gray-500 text-md md:text-lg dark:text-gray-400">Last Name</dt>
                                    <dd class="text-lg font-semibold">Abera</dd>
                                </div>
                                <div class="flex flex-col py-3">
                                    <dt class="mb-1 text-gray-500 text-md md:text-lg dark:text-gray-400">Date Of Birth</dt>
                                    <dd class="text-lg font-semibold">21/02/1997</dd>
                                </div>
                                <div class="flex flex-col py-3">
                                    <dt class="mb-1 text-gray-500 text-md md:text-lg dark:text-gray-400">Gender</dt>
                                    <dd class="text-lg font-semibold">Male</dd>
                                </div>
                            </dl>
                        </div>
                        <div class="w-full">
                            <dl class="text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                                <div class="flex flex-col pb-3">
                                    <dt class="mb-1 text-gray-500 text-md md:text-lg dark:text-gray-400">Location</dt>
                                    <dd class="text-lg font-semibold">Ethiopia, Addis Ababa</dd>
                                </div>
                                <div class="flex flex-col pt-3">
                                    <dt class="mb-1 text-gray-500 text-md md:text-lg dark:text-gray-400">Phone Number</dt>
                                    <dd class="text-lg font-semibold">+251913****30</dd>
                                </div>
                                <div class="flex flex-col pt-3">
                                    <dt class="mb-1 text-gray-500 text-md md:text-lg dark:text-gray-400">Email</dt>
                                    <dd class="text-lg font-semibold">samuelabera87@gmail.com</dd>
                                </div>
                                <div class="flex flex-col pt-3">
                                    <dt class="mb-1 text-gray-500 text-md md:text-lg dark:text-gray-400">Website</dt>
                                    <dd class="text-lg font-semibold">https://www.teclick.com</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- My Location -->
                    <div class="my-10 w-full h-[10rem] sm:h-[14rem] lg:w-[70%] lg:h-[20rem]">
                        <h1 class="font-serif my-4 pb-1 pr-2 rounded-b-md border-b-4 border-blue-600 dark:border-yellow-600 dark:text-white text-2xl sm:text-3xl lg:text-4xl text-center lg:text-left">
                            My Location
                        </h1>

                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d252230.02028974562!2d38.613328040215286!3d8.963479542403238!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x164b85cef5ab402d%3A0x8467b6b037a24d49!2sAddis%20Ababa!5e0!3m2!1sen!2set!4v1710567234587!5m2!1sen!2set"
                            class="rounded-lg w-full h-full" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>

                <!-- Social Links -->
                <div
                    class="fixed right-2 bottom-20 flex flex-col rounded-sm bg-gray-200 text-gray-500 dark:bg-gray-200/80 dark:text-gray-700 hover:text-gray-600 dark:hover:text-gray-400">
                    <a href="https://www.linkedin.com/in/samuel-abera-6593a2209/">
                        <div class="p-2 hover:text-blue-500 dark:hover:text-blue-400">
                            <svg class="w-6 h-6 text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M12.51 8.796v1.697a3.738 3.738 0 0 1 3.288-1.684c3.455 0 4.202 2.16 4.202 4.97V19.5h-3.2v-5.072c0-1.21-.244-2.766-2.128-2.766-1.827 0-2.139 1.317-2.139 2.676V19.5h-3.19V8.796h3.168ZM7.2 6.106a1.61 1.61 0 0 1-.988 1.483 1.595 1.595 0 0 1-1.743-.348A1.607 1.607 0 0 1 5.6 4.5a1.601 1.601 0 0 1 1.6 1.606Z"
                                    clip-rule="evenodd" />
                                <path d="M7.2 8.809H4V19.5h3.2V8.809Z" />
                            </svg>
                        </div>
                    </a>
                    <a href="https://twitter.com/Samuel7Abera7">
                        <div class="p-2 hover:text-blue-500 dark:hover:text-blue-400">
                            <svg class="w-6 h-6 text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M21 7.526a7.652 7.652 0 0 1-2.14.596 3.673 3.673 0 0 0 1.654-2.008 7.32 7.32 0 0 1-2.332.89 3.692 3.692 0 0 0-6.387 3.357 10.406 10.406 0 0 1-7.611-3.775A3.656 3.656 0 0 0 5 10.06a3.598 3.598 0 0 1-1.664-.455v.047c0 1.764 1.276 3.239 2.983 3.57a3.724 3.724 0 0 1-1.654.063A3.707 3.707 0 0 0 8.3 15.177a7.44 7.44 0 0 1-4.569 1.546c-.29 0-.58-.017-.869-.05a10.498 10.498 0 0 0 5.614 1.63c6.731 0 10.415-5.563 10.415-10.386 0-.16-.003-.318-.01-.476A7.447 7.447 0 0 0 21 7.526Z" />
                            </svg>
                        </div>
                    </a>
                </div>
            </div>
        </section>
        <div class="flex flex-col z-10">
            <main class="flex-1 mx-auto py-8 px-6 md:px-8 lg:px-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <div class="rounded-lg border bg-card text-card-foreground shadow-sm overflow-hidden bg-white" data-v0-t="card">
                    <img
                        src="../assets/img/1.jpg"
                        alt="Featured Listing 1"
                        width="400"
                        height="300"
                        class="rounded-t-md object-cover w-full h-60"
                        style="aspect-ratio: 400 / 300; object-fit: cover;" />
                    <div class="p-4">
                        <h3 class="text-lg font-semibold">Luxury Penthouse in Downtown</h3>
                        <h3 class="text-base text-muted-foreground">Zone 14, Taal, Batangas</h3>
                        <p class="mt-2 text-muted-foreground">Hosted by Henry James</p>
                        <p class="text-muted-foreground mb-2">1,000 sq ft | 2 Bed | 2 Bath</p>
                        <p class="text-primary font-bold text-lg">4,000/month</p>
                        <div class="mt-4">
                            <a class="text-white bg-primary px-5 py-2 border border-[#C1C549] rounded-md hover:bg-accent ease transition-colors" href="apartment" rel="ugc">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
                <div class="rounded-lg border bg-card text-card-foreground shadow-sm overflow-hidden bg-white" data-v0-t="card">
                    <img
                        src="../assets/img/1.jpg"
                        alt="Featured Listing 1"
                        width="400"
                        height="300"
                        class="rounded-t-md object-cover w-full h-60"
                        style="aspect-ratio: 400 / 300; object-fit: cover;" />
                    <div class="p-4">
                        <h3 class="text-lg font-semibold">Luxury Penthouse in Downtown</h3>
                        <h3 class="text-base text-muted-foreground">Zone 14, Taal, Batangas</h3>
                        <p class="mt-2 text-muted-foreground">Hosted by Henry James</p>
                        <p class="text-muted-foreground mb-2">1,000 sq ft | 2 Bed | 2 Bath</p>
                        <p class="text-primary font-bold text-lg">4,000/month</p>
                        <div class="mt-4">
                            <a class="text-white bg-primary px-5 py-2 border border-[#C1C549] rounded-md hover:bg-accent ease transition-colors" href="apartment" rel="ugc">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
                <div class="rounded-lg border bg-card text-card-foreground shadow-sm overflow-hidden bg-white" data-v0-t="card">
                    <img
                        src="../assets/img/1.jpg"
                        alt="Featured Listing 1"
                        width="400"
                        height="300"
                        class="rounded-t-md object-cover w-full h-60"
                        style="aspect-ratio: 400 / 300; object-fit: cover;" />
                    <div class="p-4">
                        <h3 class="text-lg font-semibold">Luxury Penthouse in Downtown</h3>
                        <h3 class="text-base text-muted-foreground">Zone 14, Taal, Batangas</h3>
                        <p class="mt-2 text-muted-foreground">Hosted by Henry James</p>
                        <p class="text-muted-foreground mb-2">1,000 sq ft | 2 Bed | 2 Bath</p>
                        <p class="text-primary font-bold text-lg">4,000/month</p>
                        <div class="mt-4">
                            <a class="text-white bg-primary px-5 py-2 border border-[#C1C549] rounded-md hover:bg-accent ease transition-colors" href="apartment" rel="ugc">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
                <div class="rounded-lg border bg-card text-card-foreground shadow-sm overflow-hidden bg-white" data-v0-t="card">
                    <img
                        src="../assets/img/1.jpg"
                        alt="Featured Listing 1"
                        width="400"
                        height="300"
                        class="rounded-t-md object-cover w-full h-60"
                        style="aspect-ratio: 400 / 300; object-fit: cover;" />
                    <div class="p-4">
                        <h3 class="text-lg font-semibold">Luxury Penthouse in Downtown</h3>
                        <h3 class="text-base text-muted-foreground">Zone 14, Taal, Batangas</h3>
                        <p class="mt-2 text-muted-foreground">Hosted by Henry James</p>
                        <p class="text-muted-foreground mb-2">1,000 sq ft | 2 Bed | 2 Bath</p>
                        <p class="text-primary font-bold text-lg">4,000/month</p>
                        <div class="mt-4">
                            <a class="text-white bg-primary px-5 py-2 border border-[#C1C549] rounded-md hover:bg-accent ease transition-colors" href="apartment" rel="ugc">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>








            </main>
        </div>


    </div>
    <script>
        const sidebarToggle = document.querySelector(".sidebar-toggle");
        const sidebarOverlay = document.querySelector(".sidebar-overlay");
        const sidebarMenu = document.querySelector(".sidebar-menu");
        const main = document.querySelector(".main");

        sidebarToggle.addEventListener("click", (e) => {
            e.preventDefault();
            main.classList.toggle("active");
            sidebarOverlay.classList.toggle("hidden");
            sidebarMenu.classList.toggle("-translate-x-full");
        });

        sidebarOverlay.addEventListener("click", (e) => {
            e.preventDefault();
            main.classList.add("active");
            sidebarOverlay.classList.toggle("hidden");
            sidebarMenu.classList.toggle("-translate-x-full");
        });

        document.querySelectorAll(".sidebar-dropdown-toggle").forEach((item) => {
            item.addEventListener("click", (e) => {
                e.preventDefault();
                const parent = item.closest(".group");
                parent.classList.add("selected");
            });
        });

        document.querySelectorAll('.dropdown-toggle').forEach(button => {
            button.addEventListener('click', () => {
                const dropdownMenu = button.nextElementSibling;

                // Toggle the hidden class to show/hide the dropdown
                dropdownMenu.classList.toggle('hidden');

                // Close any other open dropdowns
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    if (menu !== dropdownMenu) {
                        menu.classList.add('hidden');
                    }
                });
            });
        });

        // Optional: Close the dropdown if clicked outside
        document.addEventListener('click', (e) => {
            const isDropdown = e.target.matches('.dropdown-toggle') || e.target.closest('.dropdown');
            if (!isDropdown) {
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.classList.add('hidden');
                });
            }
        });

        document.addEventListener("DOMContentLoaded", function() {
            const breadCrumb = document.getElementById("breadcrumb");
            const pageLinks = document.querySelectorAll("a[href]");

            pageLinks.forEach((link) => {
                link.addEventListener("click", function(event) {
                    const pageName = this.textContent.trim();

                    // Prevent duplicate "Dashboard / Dashboard" entries
                    if (pageName !== "Dashboard") {
                        breadCrumb.textContent = `Dashboard / ${pageName}`;
                    } else {
                        breadCrumb.textContent = "Dashboard";
                    }

                    // Store the breadcrumb in localStorage
                    localStorage.setItem("breadcrumb", breadCrumb.textContent);
                });
            });

            // On page load, restore the breadcrumb from localStorage
            const savedBreadcrumb = localStorage.getItem("breadcrumb");
            if (savedBreadcrumb) {
                breadCrumb.textContent = savedBreadcrumb;
            } else {
                breadCrumb.textContent = "Dashboard";
            }
        });
    </script>
</body>

</html>
<?php
include 'includes/header.php';
$database = new Database();
$db = $database->getConnection();
$listing = new Listing($db);
$landlords = new Landlords($db);

$landlordListings = $listing->getAllListings();
?>
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
            <a href="index" class="text-lg hover:text-primary duration-500">Apartments</a>
        </li>
        <li class="my-6 md:my-0 ">
            <a href="#rent" class="text-lg hover:text-primary duration-500">Commercial</a>
        </li>
        <li class="my-6 md:my-0 ">
            <a href="#about" class="text-lg hover:text-primary duration-500">Find Agent</a>
        </li>
        <a class="profile-name md:hidden flex items-center hover:text-primary duration-50 ease-in transition-colors" href="profile">
            <img src="../assets/img/me.jpg" alt="profile-picture" class="cursor-pointer rounded-full" style="width: 40px; height: 40px; margin-right: 20px;">
            <p class="text-lg " href="#"><?php echo htmlspecialchars($userName); ?></p>
        </a>
    </ul>
    <a class="profile-name md:flex hidden md:items-center hover:text-primary duration-50 ease-in transition-colors" href="profile">
        <img src="<?php echo $profilePicture; ?>" alt="profile-picture" class=" rounded-full" style="width: 40px; height: 40px; margin-right: 20px;">
        <p class="text-lg hover:text-primary duration-500" href="#"><?php echo htmlspecialchars($userName); ?></p>
    </a>
</nav>
<section class="relative h-[500px] tenants-home" style="background-image: url('../assets/img/bg.png'); z-index: 1; background-size: cover; background-position: center;">
    <div class="container mx-auto flex flex-col justify-center items-center text-center h-full px-4 text-[20px]">
        <h1 class="text-4xl font-bold">Discover a New Era of Convenience and Connection</h1>
        <p class="mt-4 mb-4 text-base md:text-lg">Experience effortless living in Poblacion, Taal with Poblacion<span class="text-primary">Ease</span>.</p>

        <div class="flex flex-col md:flex-row items-center gap-4 mt-4 w-full max-w-xl">
            <form action="search.php" method="GET" class="w-full flex flex-col md:flex-row items-center gap-4">
                <div class="w-full">
                    <select name="zone" class="shadow px-3 py-3 w-full md:w-[100px] rounded-lg md:rounded-l-lg">
                        <option value="">Choose Zone</option>
                        <option value="zone1">Zone 1</option>
                        <option value="zone2">Zone 2</option>
                        <option value="zone3">Zone 3</option>
                        <option value="zone4">Zone 4</option>
                        <option value="zone6">Zone 6</option>
                        <option value="zone7">Zone 7</option>
                        <option value="zone8">Zone 8</option>
                        <option value="zone9">Zone 9</option>
                        <option value="zone10">Zone 10</option>
                        <option value="zone11">Zone 11</option>
                        <option value="zone12">Zone 12</option>
                        <option value="zone13">Zone 13</option>
                        <option value="zone14">Zone 14</option>
                    </select>
                </div>
                <div class="w-full">
                    <select name="rental_term" class="shadow px-3 py-3 w-full md:w-[100px] rounded-lg md:rounded-l-lg">
                        <option value="">Choose Rental Term</option>
                        <option value="long_term">Long Term Rentals</option>
                        <option value="short_term">Short Term Rentals</option>
                        <option value="daily">Daily Rentals</option>
                    </select>
                </div>
                <button type="submit" class="bg-primary text-white p-2 w-full md:w-auto rounded-lg md:rounded-r-lg hover:bg-accent">
                    Search
                </button>
            </form>
        </div>

    </div>


</section>
<div class="flex flex-col z-10">
    <main class="flex-1 mx-auto py-8 px-6 md:px-8 lg:px-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <?php if (!empty($landlordListings)): ?>
            <?php foreach ($landlordListings as $landlordListing): ?>
                <div class="rounded-lg border bg-card text-card-foreground shadow-sm overflow-hidden bg-white">
                    <?php
                    $images = $listing->getImagesByListing($landlordListing['id']);
                    // Check if $images is an array and contains data
                    if (is_array($images) && !empty($images)) {
                        $imageSrc = $images[0]; // Access the first image in the array
                    } else {
                        $imageSrc = 'assets/img/image_placeholder.png'; // Fallback if no image is available
                    }

                    $landlordDetails = $landlords->findById($landlordListing['user_id']);
                    $property_name = $landlordDetails['property_name'] ?? 'Property Name Not Available';
                    $fullName = $landlordDetails['first_name'] . ' ' . $landlordDetails['last_name'];
                    ?>
                    <img
                        src="../landlords/Controllers/<?php echo htmlspecialchars($imageSrc); ?>"
                        alt="Featured Listing 1"
                        width="400"
                        height="300"
                        class="rounded-t-md object-cover w-full h-60"
                        style="aspect-ratio: 400 / 300; object-fit: cover;" />
                    <div class="p-4">
                        <h3 class="text-lg font-semibold"><?php echo htmlspecialchars($property_name); ?></h3>
                        <h3 class="text-base text-muted-foreground"><?php echo htmlspecialchars($landlordListing['address']); ?></h3>
                        <p class="mt-2 text-muted-foreground">Hosted by <?php echo htmlspecialchars($fullName); ?></p>
                        <p class="text-muted-foreground mb-2"><?= htmlspecialchars($landlordListing['sqft']); ?> sqft | <?= htmlspecialchars($landlordListing['bedrooms']); ?> Bed | <?= htmlspecialchars($landlordListing['bathrooms']); ?> Bathrooms</p>
                        <p class="text-primary font-bold text-lg">₱<?= htmlspecialchars($landlordListing['rent']) ?>/month</p>
                        <div class="mt-4">
                            <a class="text-white bg-primary px-5 py-2 border border-[#C1C549] rounded-md hover:bg-accent ease transition-colors" href="apartment" rel="ugc">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No listings available.</p>
        <?php endif; ?>
    </main>
</div>



<?php include 'includes/footer.php'; ?>
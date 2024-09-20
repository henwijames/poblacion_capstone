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
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- JQuery File -->
    <script src="../assets/js/jquery-3.7.1.min.js"></script>
</head>

<body>


    <div class="grid grid-cols-3 gap-4">
        <?php if (isset($listingDetails['images']) && is_array($listingDetails['images'])): ?>
            <?php $maxImages = 5; // Adjust this as needed 
            ?>
            <?php $count = 0; ?>
            <?php foreach ($listingDetails['images'] as $image): ?>
                <?php if ($count >= $maxImages) break; ?>
                <img
                    src="<?= htmlspecialchars("Controllers/" . $image); ?>"
                    alt="Apartment Image"
                    width="500"
                    height="400"
                    class="rounded-lg object-cover shadow-lg"
                    style="aspect-ratio: 300 / 200; object-fit: cover;" />
                <?php $count++; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-xl">No images available.</p>
        <?php endif; ?>
    </div>
    <div class="flex items-center gap-4 mb-2">
        <a href="index" class="rounded-full w-10 h-10 bg-none hover:bg-[#C4C4C4] flex items-center justify-center transition-colors ease-in duration-100 hover:shadow-md"><i class="fa-solid fa-chevron-left" cl</i></a></i>
        <h1 class="text-xl lg:text-3xl font-bold">Luxury Apartment in Downtown</h1>
    </div>
</body>

</html>
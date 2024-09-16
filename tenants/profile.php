<?php require 'includes/header.php'; ?>
<?php require 'includes/sidebar.php'; ?>


<main class="main-content main">
    <?php require 'includes/topbar.php'; ?>
    <div class="flex flex-col">
        <!-- Cover Image -->
        <img src="../assets/img/volcano.jpg" alt="User Cover"
            class="w-full h-auto max-h-[20rem] object-cover" />

        <!-- Profile Image and Name -->
        <div class="sm:w-[80%] xs:w-[90%] mx-auto flex flex-col items-center -mt-16">
            <img src="https://images.unsplash.com/photo-1501196354995-cbb51c65aaea?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w0NzEyNjZ8MHwxfHNlYXJjaHw3fHxwZW9wbGV8ZW58MHwwfHx8MTcxMTExMTM4N3ww&ixlib=rb-4.0.3&q=80&w=1080" alt="User Profile"
                class="rounded-full w-28 h-28 sm:w-32 sm:h-32 lg:w-48 lg:h-48 outline outline-2 outline-offset-2 relative" />

            <h1 class="w-full text-center my-6  text-primary text-2xl sm:text-3xl lg:text-4xl">
                <?php echo htmlspecialchars($fullName); ?></h1>
        </div>

        <!-- Details Section -->
        <div class="w-full px-4 md:px-6 lg:px-0 xl:w-[80%] lg:w-[90%] mx-auto flex flex-col gap-4 items-center relative -mt-6">
            <!-- Detail -->
            <div class="w-full my-auto py-6 flex flex-col md:flex-row gap-4 justify-center">
                <div class="w-full">
                    <dl class="text-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                        <div class="flex flex-col pb-3">
                            <dt class="mb-1 text-gray-500 text-md md:text-lg dark:text-gray-400">First Name</dt>
                            <dd class="text-lg font-semibold"><?php echo htmlspecialchars($userName); ?></dd>
                        </div>
                        <div class="flex flex-col py-3">
                            <dt class="mb-1 text-gray-500 text-md md:text-lg dark:text-gray-400">Middle Name</dt>
                            <dd class="text-lg font-semibold"><?php echo htmlspecialchars($tenant["middle_name"]); ?></dd>
                        </div>
                        <div class="flex flex-col py-3">
                            <dt class="mb-1 text-gray-500 text-md md:text-lg dark:text-gray-400">Last Name</dt>
                            <dd class="text-lg font-semibold"><?php echo htmlspecialchars($tenant["last_name"]); ?></dd>
                        </div>
                    </dl>
                </div>
                <div class="w-full">
                    <dl class="text-gray-900 divide-y divide-gray-200  dark:divide-gray-700">
                        <div class="flex flex-col pb-3">
                            <dt class="mb-1 text-gray-500 text-md md:text-lg dark:text-gray-400">Address</dt>
                            <dd class="text-lg font-semibold"><?php echo htmlspecialchars($tenant["address"]); ?></dd>
                        </div>
                        <div class="flex flex-col pt-3">
                            <dt class="mb-1 text-gray-500 text-md md:text-lg dark:text-gray-400">Phone Number</dt>
                            <dd class="text-lg font-semibold"><?php echo htmlspecialchars($tenant["phone_number"]); ?></dd>
                        </div>
                        <div class="flex flex-col pt-3">
                            <dt class="mb-1 text-gray-500 text-md md:text-lg dark:text-gray-400">Email</dt>
                            <dd class="text-lg font-semibold"><?php echo htmlspecialchars($tenant["email"]); ?></dd>
                        </div>
                    </dl>
                </div>
            </div>
            <div class="flex justify-center gap-2 py-2">
                <a href="edit-profile" class="bg-primary text-white py-2 px-4 rounded-md hover:bg-accent transition-all">Edit Profile</a>
            </div>
        </div>
    </div>
</main>
<?php require 'includes/footer.php'; ?>
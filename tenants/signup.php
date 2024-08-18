<?php
session_start();


// Include header and database
include 'includes/header.php';

// Retrieve errors and form data from session
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
$formData = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];

// Clear session data
unset($_SESSION['errors']);
unset($_SESSION['form_data']);
?>
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
            <h1 class="text-4xl font-bold text-center mb-6">Sign up as a <span class="text-primary">Tenant</span></h1>
            <form class="space-y-4 flex flex-col w-full gap-4" method="POST" action="../Controllers/TenantSignupController.php">
                <div class="flex flex-col md:flex-row w-full justify-center items-center gap-4">
                    <div class="flex flex-col gap-2 w-full">
                        <label for="fname" class="text-md">First Name</label>
                        <input type="text" class="w-full p-2 border border-gray-300 rounded-md placeholder:font-light placeholder:text-gray-500" name="fname" id="fname" placeholder="John" value="<?php echo htmlspecialchars($formData['fname'] ?? ''); ?>">
                        <?php if (isset($errors['fname'])): ?>
                            <p class="text-red-500 text-sm"><?php echo htmlspecialchars($errors['fname']); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="flex flex-col gap-2 w-full">
                        <label for="mname" class="text-md">Middle Name (Optional)</label>
                        <input type="text" class="w-full p-2 border border-gray-300 rounded-md placeholder:font-light placeholder:text-gray-500" name="mname" id="mname" placeholder="Sugar" value="<?php echo htmlspecialchars($formData['mname'] ?? ''); ?>">
                    </div>
                    <div class="flex flex-col gap-2 w-full">
                        <label for="lname" class="text-md">Last Name</label>
                        <input type="text" class="w-full p-2 border border-gray-300 rounded-md placeholder:font-light placeholder:text-gray-500" name="lname" id="lname" placeholder="Doe" value="<?php echo htmlspecialchars($formData['lname'] ?? ''); ?>">
                        <?php if (isset($errors['lname'])): ?>
                            <p class="text-red-500 text-sm"><?php echo htmlspecialchars($errors['lname']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row w-full justify-center items-center gap-4">
                    <div class="flex flex-col gap-2 w-full">
                        <label for="email" class="text-md">Email</label>
                        <input type="email" class="w-full p-2 border border-gray-300 rounded-md placeholder:font-light placeholder:text-gray-500" name="email" id="email" placeholder="johndoe@email.com" value="<?php echo htmlspecialchars($formData['email'] ?? ''); ?>">
                        <?php if (isset($errors['email'])): ?>
                            <p class="text-red-500 text-sm"><?php echo htmlspecialchars($errors['email']); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="flex flex-col gap-2 w-full">
                        <label for="address" class="text-md">Address</label>
                        <input type="text" class="w-full p-2 border border-gray-300 rounded-md placeholder:font-light placeholder:text-gray-500" placeholder="Poblacion, Taal, Batangas" name="address" id="address" value="<?php echo htmlspecialchars($formData['address'] ?? ''); ?>">
                        <?php if (isset($errors['address'])): ?>
                            <p class="text-red-500 text-sm"><?php echo htmlspecialchars($errors['address']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="phone" class="text-sm font-medium leading-none">Phone Number</label>
                    <input class="w-full p-2 border border-gray-300 rounded-md placeholder:font-light placeholder:text-gray-500" name="phone" id="phone" type="tel" maxlength="11" placeholder="09567345298" value="<?php echo htmlspecialchars($formData['phone'] ?? ''); ?>">
                    <?php if (isset($errors['phone'])): ?>
                        <p class="text-red-500 text-sm"><?php echo htmlspecialchars($errors['phone']); ?></p>
                    <?php endif; ?>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="id-file" class="text-sm font-medium leading-none">Valid ID</label>
                    <input class="w-full p-2 border border-gray-300 rounded-md placeholder:font-light placeholder:text-gray-500 file:bg-transparent file:text-sm file:font-medium" name="validid" id="id-file" type="file">
                </div>
                <div class="flex flex-col gap-2">
                    <label for="password" class="text-sm font-medium leading-none">Password</label>
                    <input class="w-full p-2 border border-gray-300 rounded-md placeholder:font-light placeholder:text-gray-500" id="password" name="password" placeholder="Password" type="password" value="<?php echo isset($formData['password']) ? htmlspecialchars($formData['password']) : ''; ?>">
                    <?php if (isset($errors['password'])): ?>
                        <p class=" text-red-500 text-sm"><?php echo htmlspecialchars($errors['password']); ?></p>
                    <?php endif; ?>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="confirm" class="text-sm font-medium leading-none">Confirm Password</label>
                    <input class="w-full p-2 border border-gray-300 rounded-md placeholder:font-light placeholder:text-gray-500" id="confirm" name="confirm" placeholder="Confirm Password" type="password">
                    <?php if (isset($errors['confirm'])): ?>
                        <p class="text-red-500 text-sm"><?php echo htmlspecialchars($errors['confirm']); ?></p>
                    <?php endif; ?>
                </div>
                <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 h-10 px-4 py-2 w-full border border-[#C1C549] bg-primary hover:bg-accent" type="submit">
                    Sign Up
                </button>
                <?php if (isset($errors['database'])): ?>
                    <p class="text-red-500 text-sm"><?php echo htmlspecialchars($errors['database']); ?></p>
                <?php endif; ?>
            </form>
        </div>
    </main>
</div>
<?php include 'includes/footer.php'; ?>
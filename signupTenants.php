<?php
// Include header and database
include 'partials/header.php';



// Retrieve errors and form data from session
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
$formData = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];

// Check if there is an email error in session and show a Swal popup
if (isset($_SESSION['same_email'])) {
    echo "<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: '" . addslashes($_SESSION['same_email']) . "'
    });
    </script>";
}

// Clear session data
unset($_SESSION['errors']);
unset($_SESSION['form_data']);
unset($_SESSION['same_email']);

?>

<div class="w-full flex flex-col justify-center items-center">
    <div class="container mx-auto md:px-[120px] mb-4 px-6 py-2">
        <nav class="flex justify-between items-center mb-2">
            <a href="../index"><img src="assets/img/poblacionease.png" alt="Poblacionease logo" class="w-[150px] h-[60px]"></a>
            <div class="flex gap-4 text-[18px]">
                <div class=" text-[16px] ">
                    <a href="login" class=" bg-primary hover:bg-accent transition-all py-2 px-3 w-5 rounded-md uppercase shadow-md">Login</a>
                </div>
                <div class=" text-[16px] ">
                    <a href="choose" class=" hover:bg-accent transition-all bg-primary py-2 px-3 w-5 rounded-md uppercase shadow-md">Sign up</a>
                </div>
            </div>
        </nav>
    </div>
    <main class="flex items-center justify-center gap-8 px-8 w-full max-w-lg pb-4 mb-4">
        <div class=" flex flex-col items-center">

            <h1 class="text-4xl font-bold text-center mb-6">Sign up as a <span class="text-primary">Tenant</span></h1>
            <form class="space-y-4 flex flex-col w-full gap-4" method="POST" action="Controllers/TenantSignupController.php" enctype="multipart/form-data">
                <div class="flex flex-col md:flex-row w-full justify-center items-center gap-4">
                    <div class="flex flex-col gap-2 w-full">
                        <label for="fname" class="text-md">First Name</label>
                        <input type="text" class="w-full p-2 border border-gray-300 rounded-md placeholder:font-light placeholder:text-gray-500" name="fname" id="fname" placeholder="John" value="<?php echo htmlspecialchars($formData['fname'] ?? ''); ?>">
                        <?php if (isset($errors['fname'])): ?>
                            <p class="text-red-500 text-sm"><?php echo htmlspecialchars($errors['fname']); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="flex flex-col gap-2 w-full">
                        <label for="mname" class="text-md">Middle Name</label>
                        <input type="text" class="w-full p-2 border border-gray-300 rounded-md placeholder:font-light placeholder:text-gray-500" name="mname" id="mname" placeholder="Optional*" value="<?php echo htmlspecialchars($formData['mname'] ?? ''); ?>">
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
                <div class="flex items-center space-x-6">
                    <div class="shrink-0">
                        <img id="profilePhoto" class="h-16 w-16 object-cover rounded-full" src="assets/img/image_placeholder.png" alt="Current profile photo" />
                    </div>
                    <label class="block">

                        <span class="ml-2">Add a valid id</span>
                        <input type="file" name="validid" class="block w-full cursor-pointer text-sm text-slate-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-violet-50 file:text-primary
                            hover:file:bg-accent
                            "
                            onchange="previewProfilePhoto(event)" />
                    </label>
                    <?php if (isset($errors['validid'])): ?>
                        <p class="text-red-500 text-sm"><?php echo htmlspecialchars($errors['validid']); ?></p>
                    <?php endif; ?>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="password" class="text-sm font-medium leading-none">Password</label>
                    <div class="relative">
                        <input class="w-full p-2 border border-gray-300 rounded-md placeholder:font-light placeholder:text-gray-500" id="password" name="password" placeholder="Password" type="password" value="<?php echo isset($formData['password']) ? htmlspecialchars($formData['password']) : ''; ?>">
                        <span id="validation-icon" class="absolute top-1/2 right-11 transform -translate-y-1/2 text-red-500 hidden">
                            <i class="fas fa-times-circle"></i>
                        </span>
                        <span id="show-password" class="absolute top-1/2 right-4 transform -translate-y-1/2 cursor-pointer hidden">
                            <i class="fa-regular fa-eye"></i>
                        </span>
                        <div id="requirements" class="absolute top-full mt-2 w-full bg-background shadow-lg text-black text-sm rounded-lg p-3 hidden z-50">
                            <p id="length" class="requirement">* Must be at least 8 characters long</p>
                            <p id="special" class="requirement">* Must have at least 1 special character</p>
                            <p id="lowercase" class="requirement">* Must have at least 1 lowercase character</p>
                            <p id="uppercase" class="requirement">* Must have at least 1 uppercase character</p>
                            <p id="number" class="requirement">* Must have at least 1 number</p>
                        </div>
                    </div>

                    <?php if (isset($errors['password'])): ?>
                        <p class=" text-red-500 text-sm"><?php echo htmlspecialchars($errors['password']); ?></p>
                    <?php endif; ?>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="confirm" class="text-sm font-medium leading-none">Confirm Password</label>
                    <div class="relative">
                        <input class="w-full p-2 border border-gray-300 rounded-md placeholder:font-light placeholder:text-gray-500" id="confirm" name="confirm" placeholder="Confirm Password" type="password">
                        <span id="validation-pass" class="absolute top-1/2 right-11 transform -translate-y-1/2 text-red-500 hidden">
                            <i class="fas fa-times-circle"></i>
                        </span>

                        <span id="show-confirm" class="absolute top-1/2 right-4 transform -translate-y-1/2 cursor-pointer hidden">
                            <i class="fa-regular fa-eye"></i>
                        </span>
                    </div>
                    <?php if (isset($errors['confirm'])): ?>
                        <p class="text-red-500 text-sm"><?php echo htmlspecialchars($errors['confirm']); ?></p>
                    <?php endif; ?>
                </div>
                <p class="text-sm">By clicking "Sign Up" I agree that I have read and accepted the <span class="font-bold text-primary"><a href="#my_modal_8">Terms and Condition</a></span></p>
                <div class="modal" role="dialog" id="my_modal_8">
                    <div class="modal-box">
                        <h3 class="text-lg font-bold">Terms and Conditions</h3>
                        <div class="py-4 overflow-y-auto max-h-96">
                            <p>
                                <b>1. General Terms</b><br>
                                1.1 These terms and conditions govern the use of the platform by both landlords and tenants.<br>
                                1.2 By using this platform, all users agree to abide by the following terms and conditions.<br>
                                1.3 The platform operates under the jurisdiction of the Taal Government and adheres to all applicable laws and regulations.
                            </p>
                            <p class="mt-4">
                                <b>2. For Landlords</b><br>
                                2.1 <b>Business Permit Requirement:</b> All landlords are required to possess a valid business permit to list their properties on the platform.<br>
                                2.2 <b>Property Verification:</b> Each listed property will be verified by the Taal Government before it becomes available on the platform to ensure compliance with local laws.
                            </p>
                            <p class="mt-4">
                                <b>3. For Tenants</b><br>
                                3.1 <b>Valid ID Requirement:</b> All tenants must provide a valid government-issued ID when making a booking or inquiry.<br>
                                3.2 <b>Verification Process:</b> Tenant IDs will be verified by the Taal Government administration to ensure authenticity.
                            </p>
                            <p class="mt-4">
                                <b>4. Confidentiality and Access to Credentials</b><br>
                                4.1 <b>Data Security:</b> The platform ensures the confidentiality of all user credentials (business permits and valid IDs).<br>
                                4.2 <b>Exclusive Access:</b> Only the Taal Government administration has access to user credentials for verification purposes. The platform does not store or share sensitive information with unauthorized third parties.<br>
                                4.3 <b>Compliance with Laws:</b> The platform operates in full compliance with data privacy laws to ensure the safety of user information.
                            </p>
                            <p class="mt-4">
                                <b>5. Liability</b><br>
                                5.1 The platform is not responsible for delays in permit processing, property verification, or ID authentication caused by user non-compliance or external factors beyond the platform's control.<br>
                                5.2 Users are responsible for ensuring the accuracy and authenticity of the information provided.
                            </p>
                            <p class="mt-4">
                                <b>6. Acceptance of Terms</b><br>
                                By using this platform, all users confirm that they have read, understood, and agreed to these terms and conditions.
                            </p>
                        </div>
                        <div class="modal-action">

                            <label class="flex items-center space-x-2">
                                <input type="checkbox" id="accept_terms" class="checkbox">
                                <span class="text-sm">I agree to the Terms and Conditions</span>
                            </label>
                            <a href="#" id="agree_button" class="btn bg-primary text-white" disabled>Agree</a>
                        </div>
                    </div>
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
<script>
    const checkbox = document.getElementById('accept_terms');
    const button = document.getElementById('agree_button');

    checkbox.addEventListener('change', function() {
        if (checkbox.checked) {
            button.removeAttribute('disabled'); // Enable the button
        } else {
            button.setAttribute('disabled', 'true'); // Disable the button
        }
    });

    $(document).ready(function() {

        $('#password, #confirm').on('input', function() {
            // Check if the passwords match
            if ($('#password').val() === $('#confirm').val() && $('#confirm').val() !== '') {
                // Show the validation icon as a check (green color)
                $('#validation-pass').removeClass('hidden text-red-500').addClass('text-green-500');
                $('#validation-pass i').removeClass('fa-times-circle').addClass('fa-check-circle');
            } else {
                // Show the validation icon as an error (red color)
                $('#validation-pass').removeClass('hidden text-green-500').addClass('text-red-500');
                $('#validation-pass i').removeClass('fa-check-circle').addClass('fa-times-circle');
            }
        });

        let clickedEyeIcon = false;

        // Toggle password visibility
        $('#show-password').on('mousedown', function() {
            clickedEyeIcon = true;
            const passwordInput = $('#password');
            const icon = $(this).find('i');

            if (passwordInput.attr('type') === 'password') {
                passwordInput.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                passwordInput.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        }).on('mouseup', function() {
            setTimeout(() => clickedEyeIcon = false, 0);
        });

        let clickedEyeConfirm = false
        $('#show-confirm').on('mousedown', function() {
            clickedEyeConfirm = true;
            const passwordInput = $('#confirm');
            const icon = $(this).find('i');

            if (passwordInput.attr('type') === 'password') {
                passwordInput.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                passwordInput.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        }).on('mouseup', function() {
            setTimeout(() => clickedEyeConfirm = false, 0);
        });

        $('#password').on('focus', function() {
            $('#requirements').removeClass('hidden');
            $('#show-password').removeClass('hidden');
            $('#validation-icon').removeClass('hidden');
        }).on('focusout', function() {
            if (!clickedEyeIcon) {
                $('#requirements').addClass('hidden');
                $('#show-password').addClass('hidden');
                $('#validation-icon').addClass('hidden');
            }
        });

        $('#confirm').on('focus', function() {
            $('#validation-pass').removeClass('hidden');
            $('#show-confirm').removeClass('hidden');
        }).on('focusout', function() {
            if (!clickedEyeConfirm) {
                $('#validation-pass').addClass('hidden');
                $('#show-confirm').addClass('hidden');
            }
        });

        $('#password').on('input', function() {
            const password = $(this).val();

            // Show requirements box when typing
            if (password.length > 0) {
                $('#requirements').removeClass('hidden');
            } else {
                $('#requirements').addClass('hidden');
            }

            // Validation checks
            $('#length').toggleClass('text-green-500', password.length >= 8)
                .toggleClass('text-red-500', password.length < 8);

            $('#special').toggleClass('text-green-500', /[!@#$%^&*(),.?":{}|<>]/.test(password))
                .toggleClass('text-red-500', !/[!@#$%^&*(),.?":{}|<>]/.test(password));

            $('#lowercase').toggleClass('text-green-500', /[a-z]/.test(password))
                .toggleClass('text-red-500', !/[a-z]/.test(password));

            $('#uppercase').toggleClass('text-green-500', /[A-Z]/.test(password))
                .toggleClass('text-red-500', !/[A-Z]/.test(password));

            $('#number').toggleClass('text-green-500', /\d/.test(password))
                .toggleClass('text-red-500', !/\d/.test(password));


            const requirements = [{
                    selector: '#length',
                    condition: password.length >= 8
                },
                {
                    selector: '#special',
                    condition: /[!@#$%^&*(),.?":{}|<>]/.test(password)
                },
                {
                    selector: '#lowercase',
                    condition: /[a-z]/.test(password)
                },
                {
                    selector: '#uppercase',
                    condition: /[A-Z]/.test(password)
                },
                {
                    selector: '#number',
                    condition: /\d/.test(password)
                },
            ];

            let allValid = true;
            requirements.forEach(requirement => {
                const icon = $(requirement.selector).find('i');
                if (requirement.condition) {
                    icon.removeClass('fa-times-circle text-red-500').addClass('fa-check-circle text-green-500');
                } else {
                    icon.removeClass('fa-check-circle text-green-500').addClass('fa-times-circle text-red-500');
                    allValid = false;
                }
            });

            // Update validation icon based on allValid status
            const validationIcon = $('#validation-icon i');
            if (allValid) {
                $('#validation-icon').removeClass('text-red-500').addClass('text-green-500');
                validationIcon.removeClass('fa-times-circle').addClass('fa-check-circle');
                $('#requirements').addClass('hidden'); // Hide requirements box if valid
            } else {
                $('#validation-icon').removeClass('text-green-500').addClass('text-red-500');
                validationIcon.removeClass('fa-check-circle').addClass('fa-times-circle');
            }
        });
    });

    function previewProfilePhoto(event) {
        const reader = new FileReader();
        const fileInput = event.target;

        reader.onload = function() {
            const imageElement = document.getElementById('profilePhoto');
            imageElement.src = reader.result; // Set the new image source to the uploaded file
        };

        if (fileInput.files[0]) {
            reader.readAsDataURL(fileInput.files[0]); // Read the selected file and convert to a data URL
        }
    }
</script>
<?php include 'partials/footer.php'; ?>
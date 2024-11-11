<?php include 'includes/header.php'; ?>
<main class="main-content main">
    <?php include 'includes/topbar.php'; ?>
    <div class="p-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold mb-6">Upload Business Permit</h1>
        </div>
        <form action="Controllers/LandlordsController.php" method="POST" enctype="multipart/form-data">
            <div class="flex flex-col md:items-start items-end justify-center">
                <div class="mb-4">
                    <img id="profilePhoto" class="h-[400px] w-[400px] object-contain mb-6" src="../assets/img/permit.svg" alt="Current profile photo" />
                    <input type="file" name="permit" class="file-input file-input-bordered w-full max-w-xs" onchange="previewProfilePhoto(event)" />
                </div>
            </div>
            <div>
                <button type="submit" name="save_permit" class="btn bg-primary text-white">
                    Save
                </button>
                <a href="index" class="btn btn-outline ">
                    Cancel
                </a>
            </div>

        </form>



    </div>
</main>
<script>
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
<?php include 'includes/footer.php'; ?>
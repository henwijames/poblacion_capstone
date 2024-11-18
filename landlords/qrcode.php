<?php
include 'includes/header.php';
?>
<main class="main-content main">
    <?php include 'includes/topbar.php'; ?>
    <div class="p-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold mb-6">Upload/Update Payment QR Code</h1>
        </div>
        <form action="Controllers/LandlordsController.php" method="POST" enctype="multipart/form-data">
            <div class="flex flex-col md:items-start items-end justify-center">
                <div class="flex flex-col gap-4 mt-2 mb-6">
                    <h3 class="text-lg font-medium text-gray-700">Mode of Payment</h3>
                    <div class="flex gap-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="qr_payment" value="GCash" class="radio" <?php if ($landlord['mode_of_payment'] == 'GCash') echo 'checked'; ?>>
                            <span class=" ml-2 text-sm text-gray-700">GCash</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="qr_payment" value="Maya" class="radio" <?php if ($landlord['mode_of_payment'] == 'Maya') echo 'checked'; ?>>
                            <span class=" ml-2 text-sm text-gray-700">Maya</span>
                        </label>
                    </div>

                </div>
                <div class="mb-4">
                    <img id="qrCode" class="h-[400px] w-[400px] mb-6 object-scale-down" src="<?php echo ($landlord['qr_payment']) ? 'Controllers/' . $landlord['qr_payment'] : '../assets/img/permit.svg'; ?>" alt="Current profile photo" />
                    <input type="file" name="qrcode" class="file-input file-input-bordered w-full max-w-xs" onchange="previewQrCode(event)" accept="image/png, image/gif, image/jpeg" />
                </div>
            </div>
            <div>
                <button type="submit" name="save_qr" class="btn bg-primary text-white">
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
    function previewQrCode(event) {
        const reader = new FileReader();
        const fileInput = event.target;

        reader.onload = function() {
            const imageElement = document.getElementById('qrCode');
            imageElement.src = reader.result; // Set the new image source to the uploaded file
        };

        if (fileInput.files[0]) {
            reader.readAsDataURL(fileInput.files[0]); // Read the selected file and convert to a data URL
        }
    }

    const urlParams = new URLSearchParams(window.location.search);
    const success = urlParams.get('success');
    const error = urlParams.get('error');

    if (success == '1') {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'QR Code uploaded successfully.',
            showConfirmButton: false,
            timer: 2000
        });
        history.replaceState(null, null, window.location.pathname);

    } else if (error == '1') {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'An error occurred while uploading the QR code.',
            showConfirmButton: false,
            timer: 2000
        });
        history.replaceState(null, null, window.location.pathname);
    }
</script>
<?php include 'includes/footer.php'; ?>
<script src="js/navbar.js"></script>
<script src="js/script.js"></script>
<script>
    $(document).ready(function() {
        $(".logout-btn").on("click", function(e) {
            e.preventDefault();
            console.log("Logout button clicked");
            // SweetAlert confirmation
            Swal.fire({
                title: "Are you sure you want to logout?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#C1C549",
                cancelButtonColor: "#A9A9A9",
                confirmButtonText: "Yes, logout!",
                cancelButtonText: "Cancel",
                showClass: {
                    popup: `
      animate__animated
      animate__fadeInUp
      animate__faster
    `,
                },
                hideClass: {
                    popup: `
      animate__animated
      animate__fadeOutDown
      animate__faster
    `,
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to logout page if confirmed
                    window.location.href = "logout";
                }
            });
        });
    });
</script>
</body>

</html>
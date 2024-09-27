$(document).ready(function () {
  // Set the timeout duration in milliseconds (2 seconds = 2000 milliseconds)
  var timeoutDuration = 300000;

  // Start the countdown timer
  var timeout = setTimeout(function () {
    // Show SweetAlert2 confirmation
    Swal.fire({
      icon: "info",
      title: "Auto Logout",
      text: "You will be logged out due to inactivity.",
      timer: 3000, // Display for 3 seconds
      timerProgressBar: true,
      showConfirmButton: false,
    }).then(function () {
      // Redirect to logout.php after the SweetAlert2 popup closes
      window.location.href = "logout";
    });
  }, timeoutDuration);

  // Reset the timer whenever there's any user activity
  $(document).on("mousemove keydown scroll", function () {
    clearTimeout(timeout);
    timeout = setTimeout(function () {
      // Show SweetAlert2 confirmation
      Swal.fire({
        icon: "info",
        title: "Auto Logout",
        text: "You will be logged out due to inactivity.",
        timer: 3000, // Display for 3 seconds
        timerProgressBar: true,
        showConfirmButton: false,
      }).then(function () {
        // Redirect to logout.php after the SweetAlert2 popup closes
        window.location.href = "logout";
      });
    }, timeoutDuration);
  });
});

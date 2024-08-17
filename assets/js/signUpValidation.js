$(document).ready(function () {
  const $form = $("form");
  const $fname = $("#fname");
  const $mname = $("#mname");
  const $lname = $("#lname");
  const $email = $("#email");
  const $address = $("#address");
  const $phone = $("#phone");
  const $file = $("#id-file");
  const $password = $("#password");
  const $confirmPassword = $("#confirm");

  const passwordRegEx = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;

  $form.on("submit", function (e) {
    let valid = true;

    //clear previous error messages
    $(".error-message").remove();

    //fname validation
    if ($fname.val().trim() === "") {
      valid = false;
      showError($fname, "First name is required");
    }
    // Last Name Validation
    if ($lname.val().trim() === "") {
      valid = false;
      showError($lname, "Last Name is required.");
    }

    // Address Validation
    if ($address.val().trim() === "") {
      valid = false;
      showError($address, "Address is required.");
    }

    // Phone Number Validation
    if ($phone.val().trim() === "") {
      valid = false;
      showError($phone, "Phone Number is required.");
    }

    // Password Validation
    if (!passwordRegex.test($password.val())) {
      valid = false;
      showError(
        $password,
        "Password must have at least 8 characters, including an uppercase letter, a number, and a special character."
      );
    }

    // Confirm Password Validation
    if ($confirm.val() !== $password.val()) {
      valid = false;
      showError($confirm, "Passwords do not match.");
    }

    if (!valid) {
      e.preventDefault();
    }
  });
  function showError($input, message) {
    const $error = $("<span>")
      .addClass("error-message text-red-500 text-sm")
      .text(message);
    $input.parent().append($error);
  }
});

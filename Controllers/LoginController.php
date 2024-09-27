<?php
session_start();
require_once 'Database.php'; // Include Database class
require_once '../Models/Tenants.php';  // Include Tenants model
require_once '../Models/Landlords.php'; // Include Landlords model
require_once '../Models/Admins.php'; // Include Admins model

$errors = [];
// $plainPassword = 'Asdfghjkl@27'; // Same password you expect to verify
// $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);
// echo $hashedPassword;

// $enteredPassword = 'Asdfghjkl@27';
// $storedHash = '$2y$10$2pND2IXd2h1McSXzGeAQKeYmAVqMBBID3i2ZvICqsjDtoFuoHD7cK'; // Replace this with the hash from your DB

// // Check if the password matches
// if (password_verify($enteredPassword, $storedHash)) {
//     echo "Password matches!";
// } else {
//     echo "Password does not match.";
// }
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) && empty($password)) {
        $errors['login'] = "Please fill in all fields.";
    } else {
        $database = new Database();
        $db = $database->getConnection();

        $admins = new Admins($db);
        $foundAdmin = $admins->findByEmail($email);

        if ($foundAdmin) {

            // Ensure you're verifying against the correct column
            if ($admins->verifyPassword($password, $foundAdmin['password'])) {
                // Successful admin login
                $_SESSION['user_id'] = $foundAdmin['id'];
                $_SESSION['user_role'] = 'admin';
                $_SESSION['success'] = "Logged in successfully as an admin!";
                header("Location: ../admin/index");
                exit();
            } else {
                // Password is incorrect
                echo "Password entered: " . $password . "<br>";
                echo "Hashed password stored: " . $foundAdmin['password'] . "<br>";
                $errors['login'] = "Admin password incorrect for: " . $email;
            }
        } else {
            // Admin not found
            $errors['login'] = "Admin not found with email: " . $email;
        }

        // Check if the user is a tenant
        $tenants = new Tenants($db);
        $foundTenant = $tenants->findByEmail($email);



        if ($foundTenant) {
            if ($tenants->verifyPassword($password, $foundTenant['password'])) {
                // Successful tenant login
                $_SESSION['user_id'] = $foundTenant['id'];
                $_SESSION['user_role'] = 'tenant';
                $_SESSION['success'] = "Logged in successfully as a tenant!";
                header("Location: ../tenants/index");
                exit();
            } else {
                // Password is incorrect
                $errors['login'] = "Invalid email or password.";
            }
        }

        // If not a tenant, check if the user is a landlord
        $landlords = new Landlords($db);
        $foundLandlord = $landlords->findByEmail($email);

        if ($foundLandlord) {
            if ($landlords->verifyPassword($password, $foundLandlord['password'])) {
                // Successful landlord login
                $_SESSION['user_id'] = $foundLandlord['id'];
                $_SESSION['user_role'] = 'landlord';
                $_SESSION['success'] = "Logged in successfully as a landlord!";
                header("Location: ../landlords/index");
                exit();
            } else {
                // Password is incorrect
                $errors['login'] = "Invalid email or password.";
            }
        }



        // If neither a tenant nor a landlord is found with the provided email
        if (!$foundTenant && !$foundLandlord  && !$foundAdmin) {
            $errors['login'] = "Invalid email or password.";
        }
    }

    // if (!empty($errors)) {
    //     $_SESSION['errors'] = $errors;
    //     $_SESSION['form_data'] = $_POST;
    //     header("Location: ../login.php");
    //     exit();
    // }
}

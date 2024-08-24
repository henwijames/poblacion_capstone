<?php
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'landlord') {
    $_SESSION['errors'] = ['login' => 'Please login as a Landlord to view that page.'];
    header("Location: ../login");
    exit();
}


// Disable caching of the login page
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.
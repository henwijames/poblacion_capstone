<?php
if (isset($_SESSION['user_id'])) {
    if (!isset($_SESSION['mobile_verified']) || $_SESSION['mobile_verified'] !== true) {
        // Redirect to account verification page if not verified
        header("Location: account_verify.php");
        exit();
    }


    if ($_SESSION['user_role'] == 'tenant') {
        header("Location: tenants/index.php");
    } elseif ($_SESSION['user_role'] == 'landlord') {
        header("Location: landlords/index.php");
    }
    exit();
}

header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

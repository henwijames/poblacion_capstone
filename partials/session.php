<?php
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_role'] == 'tenant') {
        header("Location: tenants/index.php");
    } elseif ($_SESSION['user_role'] == 'landlord') {
        header("Location: ../landlords/index.php");
    }
    exit();
}

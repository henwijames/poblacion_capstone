<?php
session_start();
include 'session.php';
include '../Controllers/Database.php';
require_once '../Models/Admins.php';
require_once '../Models/Tenants.php';
require_once '../Models/Landlords.php';

if (isset($_SESSION['user_id']) && isset($_SESSION['user_role'])) {
    $database =  new Database();
    $db = $database->getConnection();

    if ($_SESSION['user_role'] ==  'admin') {
        $admins =  new Admins($db);
        $admin =   $admins->findById($_SESSION['user_id']);
        $fullname  =   $admin['first_name']  . " " .  $admin['middle_name'] . " " . $admin['last_name'];
        $username  =  $admin['first_name'];
    }
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PoblacionEase</title>

    <link rel="stylesheet" href="../assets/css/style.css">

    <!-- FontAwesome CDN -->
    <script src="https://kit.fontawesome.com/f284e8c7c2.js" crossorigin="anonymous"></script>
    <!-- Swiper CSS -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- JQuery File -->
    <script src="../assets/js/jquery-3.7.1.min.js"></script>

    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Animate CSS -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>

<body class="font-custom">
    <?php
    $page = basename($_SERVER['PHP_SELF'], ".php");
    include 'sidebar.php';
    ?>
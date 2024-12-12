<?php
// content.php

// Start the session
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: signin.php'); // Redirect to login if not logged in
    exit();
}

// Define allowed pages
$halaman = array("dashboard", "viewMhs", "addMhs", "editMhs", "deleteMhs");

// Check if 'hal' parameter is set in the URL
if (isset($_GET['hal'])) {
    $hal = $_GET['hal'];
} else {
    $hal = "dashboard"; // Default page
}

// Load the requested page if it is in the allowed list
foreach ($halaman as $h) {
    if ($hal == $h) {
        include "$h.php"; // Include the corresponding PHP file
        break; // Exit the loop once the page is found and included
    }
}
?>
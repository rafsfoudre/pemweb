<?php
session_start(); // Start the session
session_destroy(); // Destroy the session
header("Location: signin.php"); // Redirect to the sign-in page
exit();
?>
</create_file>

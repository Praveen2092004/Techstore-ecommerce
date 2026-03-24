<?php
session_start();
// Destroy all session data
session_unset();
session_destroy();

// Redirect the admin back to the login page
header("Location: login.php");
exit();
?>
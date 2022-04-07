<?php
// Start this users session.
session_start();
// Forget the current user.
session_destroy();
// Go to the login page.
header("Location: login.php");
?>
<?php
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Redirect to the login page
header("Location: http://localhost/IT_DEPT/Main.php");
exit();
?>

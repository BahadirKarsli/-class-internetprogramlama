<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Delete remember me cookies
if (isset($_COOKIE['library_user'])) {
    setcookie('library_user', '', time() - 3600, '/');
}
if (isset($_COOKIE['library_role'])) {
    setcookie('library_role', '', time() - 3600, '/');
}

// Destroy the session
session_destroy();

// Redirect to login page
header('Location: ../login.php');
exit();
?>


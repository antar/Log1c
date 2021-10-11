<?php
session_start();
session_destroy();
if (isset($_COOKIE['rememberme'])) {
    unset($_COOKIE['rememberme']);
    setcookie('rememberme', '', time() - 3600);
}
// redirect
header('Location: index.php');
?>

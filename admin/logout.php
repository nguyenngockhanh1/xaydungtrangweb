<?php 
session_start();
unset($_SESSION['matkhau']);
session_destroy();
header('Location: login.php');
?>
<?php
include('header.php');

unset($_SESSION['login'], $_SESSION['role_type']);
header('location:login.php');
?>

<?php
$current_page = explode('/', $_SERVER['PHP_SELF']);
//returns the filename of the currently executing script
$current_page = end($current_page);
// echo $current_page;

$dbserver = 'localhost';
$dbuser = 'book_user';
$dbpass = 'asdasdasd';
$dbname = 'bookstore';
?>

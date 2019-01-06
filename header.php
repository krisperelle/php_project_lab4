<?php
include 'conf.php';
session_start();
?>

<head>
  <title>PHP</title>
  <link rel="stylesheet" type="text/css" href="main.css">
  <meta charset="utf-8"/>

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
</head>

<header class="nav">
  <ul>
    <li><a href="index.php" class="<?php echo($current_page == 'index.php' || $current_page == '')?'active':NULL?>">Home</a></li>
    <li><a href="about.php" class="<?php echo($current_page == 'about.php')?'active':NULL?>">About Us</a></li>
    <?php
    if (!isset($_SESSION['login'])) {
    ?>
    <li><a href="login.php" class="<?php echo($current_page == 'login.php')?'active':NULL?>">Login</a></li>
    <?php } ?>
    <?php
    if(isset($_SESSION['login'])) {
    ?>
    <li><a href="logout.php" class="<?php echo($current_page == 'logout.php')?'active':NULL?>">Logout</a></li>
    <?php } ?>
    <li><a href="browse.php" class="<?php echo($current_page == 'browse.php')?'active':NULL?>">Browse books</a></li>
    <li><a href="mybooks.php" class="<?php echo($current_page == 'mybooks.php')?'active':NULL?>">My books</a></li>
    <li><a href="contacts.php" class="<?php echo($current_page == 'contacts.php')?'active':NULL?>">Contacts</a></li>
    <?php
    if (isset($_SESSION['role_type']) && isset($_SESSION['login'])) {
    ?>
    <li><a href="gallery.php" class="<?php echo($current_page == 'gallery.php')?'active':NULL?>">Gallery</a></li>
    <?php } ?>
  </ul>
</header>

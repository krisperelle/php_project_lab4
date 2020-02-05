<!doctype html>
<html>
<head>

<header>
  <?php include("header.php") ?>
</header>

<body class="background">

<h1>Moderator page</h1>

<?php 
if($_SESSION["role_type"] !== "moderator") {
  header('location:index.php');
} else {
  include("bookedit.php");
  }
?>

<?php include("footer.php") ?>

</body>
</html>

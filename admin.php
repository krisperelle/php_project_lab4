<!doctype html>
<html>
<head>

<header>
  <?php include("header.php") ?>
</header>

<body class="background">

<h1>Admin page</h1>

<?php 
if($_SESSION["role_type"] !== "admin") {
  header('location:index.php');
} else {
  include("users.php");
  include("bookedit.php"); 
  }
?>
<?php include("footer.php") ?>

</body>
</html>

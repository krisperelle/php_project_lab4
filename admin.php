<?php

include('conf.php');

@ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);
# Check if able to connect or not
if($db->connect_error){
  echo "Connection failed, because " . $db->connect_error;
  exit();
}
?>

<!doctype html>
<html>
<head>

<header>
  <?php include("header.php") ?>
</header>

<body class="background">

<h1>Admin page</h1>

<?php include("users.php") ?>
// todo: inlucde books php

<?php include("footer.php") ?>

</body>
</html>

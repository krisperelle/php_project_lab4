<?php
#check logininfo with the database
#if not promptlogin failed

#store the username and password in new variables
#check if entered password is same as password in db
# Begin the session

include("conf.php");
# Open the Database
@ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);
# Check if able to connect or not
if($db->connect_error){
  echo "Connection failed, because " . $db->connect_error;
  exit();
}
#kai mygtukas paspaudziamas
if(isset($_POST) && !empty($_POST)){
  $mynic = mysqli_real_escape_string($db, $_POST['username']);
  $mypass = mysqli_real_escape_string($db, $_POST['password']);
  #checks if matches db
  #mysqli_real_escape_string is used to prevent SQL injection
  #so input form knows not to take any code, any code is banned
$query =  "SELECT u.Email, u.Password, r.Type FROM User u LEFT JOIN Roles r ON u.rolesID = r.roleID WHERE u.Email = ?";
#identifies table name

$stmt = $db->prepare($query);
#echo $query;
$stmt->bind_param('s', $mynic); #this says it is a string and the value is whatever $myusername is
# where ? look at nickname
$stmt->execute();

$stmt->bind_result($dbemail, $dbpassword, $dbrole);

while($stmt->fetch()) {
 #while i have that result
  if(md5($mypass) == strtolower($dbpassword)){
    #md5 unhashes pass from the database
    session_start();
    $_SESSION['login']= $dbemail;
    $_SESSION['role_type']= $dbrole;
    #stores in session, says a user is logged in

    switch ($dbrole) {
      case 'admin':
      header('location:admin.php');
        break;
      case 'moderator':
      header('location:moderator.php');
        break;
      default:
      header('location:browse.php');
        break;
    }

  }
    echo "Unable to login. Check if username or password are correct";
}
}
?>

<!doctype html>
<html>
<head>

<header>
  <?php include("header.php") ?>
</header>

<body class="background">

<h1>Login</h1>
<form action="" method="post">
<input class="cont" type="text" name="username" placeholder="Email" value autocomplete="true">
<input class="cont" type="password" name="password" placeholder="Password" value>
<br></br>
<input class="submit" type="submit" value="submit">
</form>

<?php include("footer.php") ?>

</body>
</html>

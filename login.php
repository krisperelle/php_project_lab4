<?php
//the user is either allowed into hidden page or not
//check logininfo with the database
//if not promptlogin failed

//type only username and ask for password
//store the username and password in new variables
//check if entered password is same as password in db
//if it is, let them if, if not dont
//Begin the session

//HOW TO PROTECT AGAINST SESSION HIJACKING
include("conf.php");
//Open the Database
@ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);
//Check if able to connect or not
if($db->connect_error){
  echo "Connection failed, because " . $db->connect_error;
  exit();
}
//checks if login used correctly
if(isset($_POST) && !empty($_POST)){
  $mynic = mysqli_real_escape_string($db, $_POST['username']);
  $mypass = mysqli_real_escape_string($db, $_POST['password']);
  //mysqli_real_escape_string is used to prevent SQL injection
  //htmlentities() from XSS
  //so input form knows not to take any code, any code is banned
  //$mynic = mysqli_real_escape_string($db, $mynic);
$query =  "SELECT u.Email, u.Password, r.Type FROM User u LEFT JOIN Roles r ON u.rolesID = r.roleID WHERE u.Email = ?";
//identifies table name

$stmt = $db->prepare($query);
#echo $query;
$stmt->bind_param('s', $mynic); //this says it is a string and the value is whatever $mynic is
$stmt->execute();

$stmt->bind_result($dbemail, $dbpassword, $dbrole);

while($stmt->fetch()) {
  if(md5($mypass) == strtolower($dbpassword)){
    #md5 unhashes pass from the database
    session_start();
    $_SESSION['login']= $dbemail;
    $_SESSION['role_type']= $dbrole;

    switch ($dbrole) {
      //compares to same values in different cases
      case 'admin':
      header('location:admin.php');
        break;
      case 'moderator':
      header('location:moderator.php');
        break;
      default:
      header('location:upload.php');
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

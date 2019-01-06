<?php

include("conf.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

#open database

$db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

#is connection valid

if($db->connect_error){
  echo "Couldn't connect, because " . $db->connect_error;
  exit();
}

$searchtitle = "";
$searchauthor = "";

#reserve

if(isset($_GET) && !empty($_GET)) {
  $book = $_GET['Reserved'];
  $q2 = "UPDATE Book SET Reserved='1' WHERE ISBN='".$book."'";
  $stmt2  = $db->prepare($q2);
  $stmt2->execute();
}

#variables can'tbe empty

if(isset($_POST) && !empty($_POST)) {
  $searchtitle = htmlentities(trim($_POST['Title']));
  $searchauthor = htmlentities(trim($_POST['Author']));
}
//added html tas won't be executed | trim -sql spaces, htmlentities- html code

#connects tabbles to the middle one where books in browse are pulled from
$q = "SELECT Book.Title, Book.ISBN, Author.Name, Author.LastName FROM Book
LEFT JOIN BookAuthor ON Book.ISBN = BookAuthor.ISBN
LEFT JOIN Author ON Author.AuthorID = BookAuthor.AuthorID WHERE Book.Reserved = 0 ";

#checks what was searched
if($searchtitle && !$searchauthor) {
  $q = $q . "AND Book.Title LIKE '%" . $searchtitle . "%'";
}
if($searchauthor && !$searchtitle) {
  $q = $q . "AND Author.Name LIKE '%" . $searchauthor . "%'";
}
if($searchtitle && $searchauthor) {
  $q = $q . "AND Book.Title LIKE '%" . $searchtitle . "%' AND Author.Name LIKE '%" . $searchauthor . "%'";
}

var_dump($q);
$stmt = $db->prepare($q);
$stmt->bind_result($Title, $ISBN, $AuthorN, $AuthorL);
$stmt->execute();

?>
<!doctype html>
<html>

<header>
  <?php include("header.php") ?>
</header>

<body class="background">

<h1>Browse</h1>

<form method="post">
<input class="search" name="Title" type="text" placeholder="Search book" value>
<input class="search" name="Author" type="text" placeholder="Search author" value>
<br></br>
<input class="submit" type="submit" value="submit">
<br></br>
</form>

<?php
while($stmt->fetch()) {
  echo "<div class='search'>";
  echo "<b> Title: </b>";
  echo $Title."</br>";
  echo $ISBN."</br>";
  echo "<b>Author: </b>";
  echo $AuthorN." ";
  echo $AuthorL."</br>";
  echo "<form method='GET'><button class='submit' name='Reserved' value='".$ISBN."'>Reserve</button></form>";
  echo "</div>";
}
?>
<?php include("footer.php") ?>

</body>
</html>

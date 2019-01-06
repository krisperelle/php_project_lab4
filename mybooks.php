<?php
include("conf.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
# Open the Database
@ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

# Check if able to connect or not
if($db->connect_error){
  echo "you couldnt connect, heres why:" . $db->connect_error;
  exit();
}
#has to be at top of page otherwise does not work
#when return button is pressed it sets book reserved to 0 and links the bookid to the specific book that return was clicked on.
if (isset($_GET)  && !empty($_GET)) {
    $id=$_GET['return'];
    $query2 = "UPDATE Book SET Reserved='0' WHERE ISBN='".$id."'";
    $stmt2= $db->prepare($query2);
    $stmt2->execute();
  }

#Connecting tables book to book author and author to bookauthor
#sets book reserved in database to 1 meaning reserved
$query = "SELECT Book.Title, Book.ISBN, Author.Name, Author.LastName FROM Book
LEFT JOIN BookAuthor ON Book.ISBN = BookAuthor.ISBN
LEFT JOIN Author ON Author.AuthorID = BookAuthor.AuthorID
WHERE Book.Reserved = 1";

//echo $query;
$stmt = $db->prepare($query);
$stmt->bind_result($title, $ISBN, $AuthorN, $AuthorL);
$stmt->execute();
 ?>

<!doctype html>
<html>

<header>
  <?php include("header.php") ?>
</header>

<body class="background">

<h1>My books</h1>

  <ul class="list">
    <?php while($stmt->fetch()) { ?>
      <li>
        <?php echo $title; ?>
        <form method='GET'><button class='submit' name='return' value='<?= $ISBN ?>'>Return</button></form>
      </li>
    <?php } ?>
  </ul>
<?php include("footer.php") ?>

</body>
</html>

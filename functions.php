<?php
include('database.php');

//connects to the database
function getDb() {
  include('conf.php');
  return dbConnect($dbserver, $dbuser, $dbpass, $dbname);
}

//gets authors from the database and sorts them by name
function getAuthors() {
 $db = getDb();
 $query = "SELECT * From Author ORDER by Name, LastName asc";
 $stmt = $db->prepare($query);
 $stmt->execute();
 $authors = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
 //ispassina array
 $stmt->close();
 return $authors;
}

//same as with author
function getPublishers() {
  $db = getDb();
  $query = "SELECT * From Publisher ORDER by Name asc";
  $stmt = $db->prepare($query);
  $stmt->execute();
  $publishers = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  $stmt->close();
  return $publishers;
}

//creates a new user if everything in the second if is correctly filled
function createUser() {
  if(isset($_POST['submit_user'])) {
    //if button was pressed
    if(!isset($_POST['Email']) or !isset($_POST['Password']) or strlen($_POST['Password']) < 6) {
      exit('UNABLE');
    }
    $db = getDb();
    // print_r($db); die();
    $name = htmlentities($_POST['Name']);
    $lastName = htmlentities($_POST['LastName']);
    $address = htmlentities($_POST['Address']);
    $email = htmlentities($_POST['Email']);
    $pass = md5(htmlentities($_POST['Password']));

    //kiekviena taip perdaryt visur kur yra kuriama
    $query = "INSERT into User SET Name = ?, LastName = ?, Address = ?, Email = ?, Password = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('sssss', $name, $lastName, $address, $email, $pass);
    $stmt->execute();
    $stmt->close();
  }
}

//udates user and the password
function updateUser(int $userID) {
  //jei iskviesta be id bus klaida, reiskia kad id skaicius, null reiskia kad id nera, ir negalesim updateint
  if(isset($_POST['submit_user'])) {
    //kai paspaustas mygtukas
    $db = getDb();
    // update
    //praleist visus per entities
    $query = "UPDATE User SET Name = ?, LastName = ?, Address = ?, Email = ? WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('ssssi', $_POST['Name'], $_POST['LastName'], $_POST['Address'], $_POST['Email'], $userID);
    //binds variables to a prepared statement as parameters
    $stmt->execute();
    $stmt->close();

    // password update
    if (isset($_POST['Password']) and strlen($_POST['Password']) >= 6) {
      $query = "UPDATE User SET Password = ? WHERE id = ?";
      $stmt = $dn->prepare($query);
      $stmt->bind_param('si', md5($_POST['Password']), $userID);
      $stmt->execute();
      $stmt->close();
    }
  }
}

//deletes user
function deleteUser(int $userID) {
  $db = getDb();
  $query = "DELETE FROM User WHERE id = ?";
  $stmt = $db->prepare($query);
  $stmt->bind_param('i', $userID);
  $stmt->execute();
  $stmt->close();
}

//to edit user
function getUserByID(int $userID) {
  $db = getDb();
  $sql = "SELECT Name, LastName, Address, Email FROM User WHERE id = ?";
  $stmt1 = $db->prepare($sql);
  $stmt1->bind_param('i',$userID);
  $stmt1->execute();
  $stmt1->store_result();
  //transfers result set from the last query
  $stmt1->bind_result($name, $last_name, $address, $email);
  $stmt1->fetch();
  $stmt1->close();

  return [
    'name' => $name,
    'lastN' => $last_name,
    'address' => $address,
    'email' => $email,
  ];
}

//checks if the users are regular
function getUserWithRoles() {
  $db = getDb();
  $queryList = "SELECT * FROM User WHERE rolesID is NULL";

  $res = $db->prepare($queryList);
  $res->execute();
  $users = $res->get_result()->fetch_all(MYSQLI_ASSOC);
  $res->close();
  return $users;
  //select all users that have roles
  //is rezu padaro array ir priskiria users
}

function getBooks() {
  $db = getDb();
  $queryList = "SELECT * FROM Book ORDER by id desc";
  //visa lentele

  $res = $db->prepare($queryList);
  $res->execute();
  $books = $res->get_result()->fetch_all(MYSQLI_ASSOC);
  $res->close();
  return $books;
}

//updates book same as with user
function updateBook($book_id) {
    $db = getDb();
    $query = "UPDATE Book SET ISBN = ?, Title = ?, Pages = ?, Version = ?, PublisherID = ?, YearPublished = ?  WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('ssiiiii', $_POST['ISBN'], $_POST['Title'], $_POST['Pages'], $_POST['Version'], $_POST['publisher'], $_POST['Publishing_year'], $book_id);
    $stmt->execute();
    $stmt->close();
    updateBookAuthors($book_id, $_POST['authors']); //updates book with the author too
}

function createBook() {
  if(!isset($_POST['Title'])) {
    echo('UNABLE');
  }
  $db = getDb();
  $query = "INSERT into Book SET ISBN = ?, Title = ?, Pages = ?, Version = ?, PublisherID = ?, YearPublished = ?";
  $stmt = $db->prepare($query);

  $stmt->bind_param('ssiiii', $_POST['ISBN'], $_POST['Title'], $_POST['Pages'], $_POST['Version'], $_POST['publisher'], $_POST['Publishing_year']);
  //post ateina is formos
  $stmt->execute();
  $bookID=$db->insert_id;
  $stmt->close();
  $authors = [];
  if (isset($_POST['authors'])) {
    $authors = $_POST['authors'];
  }

  updateBookAuthors($bookID, $authors);
}

//updats authors which belong to a book
function updateBookAuthors(int $bookId, array $authorIds=[]) {
  $db = getDb();
  $query = "DELETE FROM BookAuthor WHERE BookID = ?";
  $stmt = $db->prepare($query);
  $stmt->bind_param('i', $bookId);
  $stmt->execute();
  foreach ($authorIds as $authorID) {
    $query = "INSERT into BookAuthor SET AuthorID = ?, BookID = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('ii', $authorID, $bookId);
    $stmt->execute();
  }
  $stmt->close();
}

function getAuthorsStringByID($bookId) {
   $db = getDb();
   $query = "SELECT concat(a.Name, ' ', a.LastName) AS fullname FROM Author a JOIN BookAuthor ba ON a.AuthorID = ba.AuthorID WHERE ba.BookID = ?";
   //adds two or more expressions together
   $stmt = $db->prepare($query);
   $stmt->bind_param('i', $bookId);
   $stmt->execute();
   $authors = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
   $stmt->close();
   return implode(', ', array_column($authors, 'fullname'));
   // is vieno stulpelio
   //sujungia kaip string
 }

function getBookAuthorsIds($bookId) {
   $db = getDb();
   $query = "SELECT * FROM BookAuthor WHERE BookID = ?";

   $stmt = $db->prepare($query);
   $stmt->bind_param('i', $bookId);
   $stmt->execute();
   $authorIds = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
   $stmt->close();
   return array_column($authorIds, 'AuthorID');
 }

function deleteBook($book_id) {
  $db = getDb();
  $query = "DELETE FROM Book WHERE id = ?";
  $stmt = $db->prepare($query);
  $stmt->bind_param('i', $book_id);
  $stmt->execute();
  $query = "DELETE FROM BookAuthor WHERE BookID=?";
  $stmt = $db->prepare($query);
  $stmt->bind_param('i', $book_id);
  $stmt->execute();
  $stmt->close();
}

function getBookById($book_id) {
  $db = getDb();
  $sql = "SELECT ISBN, Title, Pages, Version, PublisherID, YearPublished FROM Book WHERE id = ?";
  $stmt1 = $db->prepare($sql);
  $stmt1->bind_param('i', $book_id);
  $stmt1->execute();
  $stmt1->store_result();
  $stmt1->bind_result($isbn, $title, $pages, $version, $publisherId, $yearpub);
  $stmt1->fetch();
  $stmt1->close();
  return [
    'book_isbn' => $isbn,
    'book_title' => $title,
    'book_pages' => $pages,
    'book_version' => $version,
    'book_publisher_id' => $publisherId,
    'book_year' => $yearpub,
  ];
}

function setBookReserved($isbn, $reserved = 0) {
  $db = getDb();
  $query = "UPDATE Book SET Reserved=? WHERE ISBN=?";
  $stmt2=$db->prepare($query);
  $stmt2->bind_param('is', $reserved, $isbn);
  $stmt2->execute();
  $stmt2->close();
}

function search($search = '') {
  $db = getDb();
  $search = htmlentities(trim($search));
  //connects tables to the middle one where books in browse are pulled from
  $search = '%'.$search.'%';

  $query = "SELECT Book.Title, Book.ISBN, Author.Name, Author.LastName FROM Book
  LEFT JOIN BookAuthor ON Book.id = BookAuthor.BookID
  LEFT JOIN Author ON Author.AuthorID = BookAuthor.AuthorID
    WHERE Book.Reserved = 0
    AND (Book.Title LIKE ? OR Author.Name LIKE ? OR Author.LastName LIKE ?)";
    //bet kurioj vietoj ta fraze

  $stmt = $db->prepare($query);
  //var_dump($stmt->query());
  $stmt->bind_param('sss', $search, $search, $search);

  $stmt->bind_result($Title, $ISBN, $AuthorN, $AuthorL);
  $stmt->execute();
  $data =[];
  while ($stmt->fetch()) {
    $data[] = [
      'title' => $Title,
      'isbn' => $ISBN,
      'author_name' => $AuthorN,
      'author_last_name' => $AuthorL,
    ];
  }

  $stmt->close();
  return $data;
}

function getMyReserved() {
  $db = getDb();
  $query = "SELECT Book.Title, Book.ISBN, Author.Name, Author.LastName FROM Book
  LEFT JOIN BookAuthor ON Book.id = BookAuthor.BookID
  LEFT JOIN Author ON Author.AuthorID = BookAuthor.AuthorID
  WHERE Book.Reserved = 1";

  $stmt = $db->prepare($query);
  $stmt->bind_result($title, $ISBN, $AuthorN, $AuthorL);
  $stmt->execute();

  $data =[];
  while ($stmt->fetch()) {
    $data[] = [
      'title' => $title,
      'isbn' => $ISBN,
      'author_name' => $AuthorN,
      'author_last_name' => $AuthorL,
    ];
  }

  $stmt->close();
  return $data;
}

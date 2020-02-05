<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET' AND isset($_GET['delete_book'])) {
  deleteBook($_GET['delete_book']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if(isset($_GET['book_id'])) {
    updateBook($_GET['book_id']);
  } else {
    createBook();
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' AND isset($_GET['book_id'])) {
  $bookEdit = getBookById($_GET['book_id']);
  $bookAuthorIds = getBookAuthorsIds($_GET['book_id']);
}
 ?>
 <form action="" method="post">
 <input class="cont" type="text" name="ISBN" placeholder="ISBN" value="<?= isset($bookEdit['book_isbn']) ? $bookEdit['book_isbn']:"" ?>">
 <input class="cont" type="text" name="Title" placeholder="Title" value="<?= isset($bookEdit['book_title']) ? $bookEdit['book_title']: "" ?>">
 <select class="cont2" name="authors[]" multiple>
   <?php foreach (getAuthors() as $author) { ?>
   <option value="<?php echo $author['AuthorID'] ?>" <?php echo (isset($bookAuthorIds) && !empty($bookAuthorIds) && in_array($author['AuthorID'], $bookAuthorIds)) ? 'selected="selected"': '' ?> ><?php echo $author['Name'] . " " . $author['LastName'] ?></option>
 <?php }?> <!-- jei array yra toks id, tada pazymes-->
 </select>
 <input class="cont" type="text" name="Pages" placeholder="Pages" value="<?= isset($bookEdit['book_pages']) ? $bookEdit['book_pages']:"" ?>">
 <input class="cont" type="text" name="Version" placeholder="Version" value="<?= isset($bookEdit['book_version']) ? $bookEdit['book_version']:"" ?>">
 <input class="cont" type="text" name="Publishing_year" placeholder="Publishing year" value="<?= isset($bookEdit['book_year']) ? $bookEdit['book_year']:"" ?>">
 <select class="cont" name="publisher">
   <option value="">---</option>
   <?php foreach (getPublishers() as $publisher) { ?>
   <option value="<?php echo $publisher['PublisherID'] ?>" <?php echo (isset($bookEdit) && !empty($bookEdit) && $publisher['PublisherID'] == $bookEdit['book_publisher_id']) ? 'selected="selected"': '' ?> ><?php echo $publisher['Name'] ?></option>
   <?php }?>
 </select>
 <br></br>
 <input class="submit" type="submit" value="save">
 </form>

<?php
$books = getBooks();
?>

 <table>
   <thead>
     <tr>
       <th>ISBN</th>
       <th>Title</th>
       <th>Author</th>
       <th>Pages</th>
       <th>Version</th>
       <th>Publishing year</th>
     </tr>
   </thead>
   <tbody>
    <?php
    foreach ($books as $book) {
    ?>
     <tr>
       <td><?php echo $book['ISBN']?></td>
       <td><?php echo $book['Title']?></td>
       <td><?php echo getAuthorsStringByID($book['id']) ?></td>
       <td><?php echo $book['Pages']?></td>
       <td><?php echo $book['Version']?></td>
       <td><?php echo $book['YearPublished']?></td>
       <td>
         <a href="?book_id=<?= $book['id'] ?>">Edit</a>
         <form method='GET'><button onclick="return confirm('U SURE?')" class='submit' name='delete_book' value='<?= $book['id'] ?>'>Delete</button></form></td>
    <?php
  }
     ?>
     </tr>
   </tbody>
 </table>

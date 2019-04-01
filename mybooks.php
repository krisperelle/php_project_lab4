

<!doctype html>
<html>

<header>
  <?php include("header.php") ?>
</header>


<?php
//when return button is pressed it sets book reserved to 0 and links the bookid to the specific book that return was clicked on.
if (isset($_GET['return'])) {
  setBookReserved($_GET['return']);
}
//connecting tables book to book author and author to bookauthor
//sets book reserved in database to 1 meaning reserved
$myReserved = getMyReserved();
 ?>

<body class="background">

<h1>My books</h1>

  <ul class="list">
    <?php foreach ($myReserved as $key => $item) { ?>
      <li>
        <?= $item['title']; ?>
        <form method='GET'><button class='submit' name='return' value='<?= $item['isbn'] ?>'>Return</button></form>
      </li>
    <?php } ?>
  </ul>
<?php include("footer.php") ?>

</body>
</html>

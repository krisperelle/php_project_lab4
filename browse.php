<!doctype html>
<html>

<header>
  <?php include("header.php") ?>
</header>

<?php
if(isset($_GET['Reserved'])) {
  setBookReserved($_GET['Reserved'], 1);
}
?>

<body class="background">

<h1>Browse</h1>

<form method="post">
<input class="search" name="search" type="text" placeholder="Search" value>
<br></br>
<input class="submit" type="submit" value="submit">
<br></br>
</form>

<?php
$search = '';
if(isset($_POST['search'])) {
  $search = $_POST['search'];
}
  //added html tas won't be executed | trim -sql spaces front/end, htmlentities- html code
  $searchResult = search($search);
  ?>
<table>

  <theader></theader>
  <tbody>
  <?php
  foreach ($searchResult as $item) {?> <!-- runs over searchResults and sets a value to each one-->
<tr>
    <td><?= $item['title'] ?></td>
    <td><?= $item['isbn'] ?></td>
    <td><?= $item['author_name'] ?></td>
    <td><?= $item['author_last_name'] ?></td>
    <td>
    <form method='GET'>
      <button class='submit' name='Reserved' value="<?= $item['isbn'] ?>">Reserve</button>
    </form>
  </td>
  </tr>
<?php  }?>
</tbody>
</table>
<?php include("footer.php") ?>

</body>
</html>

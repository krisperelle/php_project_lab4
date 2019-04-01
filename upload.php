<?php
//my session starts
session_start();

//global var
if(!isset($_SESSION['login'])){
  header('location:login.php');
}

if (file_exists ['uploads']);
if(isset($_FILES['fileupload'])){
  if (!file_exists ("uploads")) {
  mkdir("uploads");
  //if folder doesn't exist it creates one,makes a directory
}

//2m bytes=2MB
$maxsize = 2000000;

$allowed = array('jpg', 'jpeg', 'png', 'gif');
$ext = substr($_FILES['fileupload']['name'], strpos($_FILES['fileupload']['name'], '.')+1));

//take file name and upload them to the server
//upload name to DB
//upload picture to server

$errors = array();

//errors if it doesnt work
if(in_array($ext, $allowed) === false){
  $errors[] = 'This is not allowed';
}
if($_FILES['fileupload']['size']>$maxsize){
  $errors[] = 'This file is more than 2MB';
}
if(empty($errors)){
  //if there is no errors we will upload the file
  move_uploaded_file($_FILES['fileupload']['tmp_name'], "uploads/{$_FILES['fileupload']['name']}");
}

}
?>

<!doctype html>
<html>

<body class="background">
  <header>
    <?php
    include("header.php") ?>
    <h1>File upload</h1>
  </header>

  <div>
    <p>Upload here</p>
    <?php
    if(isset($errors)) {
      if(empty($errors)) {
        echo '<p>"uploaded"</p>';
      } else{
        foreach($errors as $err){
          echo $err;
        }
      }
    }
     ?>
  <form method="post" class="my_upload" enctype="multipart/form-data">
    <input type="file" id="file" name="fileupload">
    <input type="submit" value="Submit" name="submit">
  </form>
  <p>Only the formats .jpg, .jpeg, .gif and .png are allowednot more than 2MB</p>
  </div>



  <?php
  include("footer.php") ?>
</body>

</html>

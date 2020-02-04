<!doctype html>
<html>
<body>
<header>
<?php
  include("header.php") ?>
</header>

<div class="background">
<h1>Gallery</h1>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus maximus, quam vel interdum varius.Maecenas in rhoncus leo. Maecenas ut sapien euismod, aliquam neque nec,
  ultricies arcu</p>


<?php
  $files = glob("uploads/*.*");
  #goes through folder uploads and takes each file and stops when the number is =i which is files
  for ($i=0; $i<count($files); $i++){
    	$num = $files[$i];
      //from files where index is ...
	    echo '<div class="images"><img src="'.$num.'" alt="random image">'."&nbsp;&nbsp;</div>";
  }
  echo "</div>";
?>

<?php
include("footer.php") ?>
</body>

</html>

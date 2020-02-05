
<!doctype html>
<html>

<body class="background">
  <header>
    <br />
<b>Notice</b>:  session_start(): A session had already been started - ignoring in <b>/Applications/MAMP/htdocs/php/php_project_lab4/header.php</b> on line <b>9</b><br />

<head>
  <title>PHP</title>
  <link rel="stylesheet" type="text/css" href="main.css">
  <meta charset="utf-8"/>

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
</head>

<header class="nav">
  <ul>
    <li><a href="index.php" class="">Home</a></li>
    <li><a href="about.php" class="">About Us</a></li>
        <li><a href="upload.php" class="active">Upload page</a></li>
    <li><a href="browse.php" class="">Browse books</a></li>
    <li><a href="mybooks.php" class="">My books</a></li>
    <li><a href="contacts.php" class="">Contacts</a></li>
            <li><a href="logout.php" class="">Logout</a></li>
      </ul>
</header>
    <h1>File upload</h1>
  </header>

  <div>
    <p>Upload here</p>
      <form method="post" class="my_upload" enctype="multipart/form-data">
    <input type="file" id="file" name="fileupload">
    <input type="submit" value="Submit" name="submit">
  </form>
  <p>Only the formats .jpg, .jpeg, .gif and .png are allowednot more than 2MB</p>
  </div>



  <footer>
    <p>© Save me from this hell. All rights reserved. Today is 2020.01.31<br></p>
</footer>
</body>

</html>

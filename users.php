<?php
include('header.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'GET' AND isset($_GET['delete_user'])) {
  $query = "DELETE FROM User WHERE id = ?";
  $stmt = $db->prepare($query);
  $stmt->bind_param('i', $_GET['delete_user']);
  $stmt->execute();
  $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  if (isset($_GET['user_id'])) {
    // update
    $query = "UPDATE User SET Name = ?, LastName = ?, Address = ?, Email = ? WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('ssssi', $_POST['Name'], $_POST['LastName'], $_POST['Address'], $_POST['Email'], $_GET['user_id']);
    $stmt->execute();
    $stmt->close();

    // password update
    if (isset($_POST['Password']) and strlen($_POST['Password']) >= 6) {
      $query = "UPDATE User SET Password = ? WHERE id = ?";
      $stmt = $dn->prepare($query);
      $stmt->bind_param('si', md5($_POST['Password']), $_GET['user_id']);
      $stmt->execute();
      $stmt->close();
    } // todo: make password lenght check on change password.

  } else {
    if(!isset($_POST['Email']) or !isset($_POST['Password']) or strlen($_POST['Password']) < 6) {
      echo('UNABLE');
    }

    $query = "INSERT into User SET Name = ?, LastName = ?, Address = ?, Email = ?, Password = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('sssss', $_POST['Name'], $_POST['LastName'], $_POST['Address'], $_POST['Email'], md5($_POST['Password']));
    $stmt->execute();
    $stmt->close();
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' AND isset($_GET['user_id'])) {
  $sql = "SELECT Name, LastName, Address, Email FROM User WHERE id = ?";
  $stmt1 = $db->prepare($sql);
  $stmt1->bind_param('i', $_GET['user_id']);
  $stmt1->execute();
  $stmt1->store_result();
  $stmt1->bind_result($name, $last_name, $address, $email);
  $stmt1->fetch();
  $stmt1->close();
}
 ?>
 <form action="" method="post">
 <input class="cont" type="text" name="Name" placeholder="First name" value="<?= isset($name) ? $name : "" ?>"> #if else
 <input class="cont" type="text" name="LastName" placeholder="Last name" value="<?= isset($last_name)? $last_name:"" ?>">
 <input class="cont" type="text" name="Address" placeholder="Address" value="<?= isset($address)? $address:"" ?>">
 <input class="cont" type="email" name="Email" placeholder="Email address" value="<?= isset($email)? $email:"" ?>">
 <input class="cont" type="password" name="Password" placeholder="Password">
 <br></br>
 <input class="submit" type="submit" value="save">
 </form>

<?php

$queryList = "SELECT * FROM User WHERE rolesID is NULL";

$res = $db->prepare($queryList);
$res->execute();
$users = $res->get_result()->fetch_all(MYSQLI_ASSOC);
?>

 <table>
   <thead>
     <tr>
       <th>ID</th>
       <th>Name</th>
       <th>Last name</th>
       <th>Email</th>
       <th>Actions</th>
     </tr>
   </thead>
   <tbody>
    <?php
    foreach ($users as $user) {
    ?>
     <tr>
       <td><?php echo $user['id']?></td>
       <td><?php echo $user['Name']?></td>
       <td><?php echo $user['LastName']?></td>
       <td><?php echo $user['Email']?></td>
       <td>
         <a href="?user_id=<?= $user['id'] ?>">Edit</a>
         <form method='DELETE'><button onclick="return confirm('U SURE?')" class='submit' name='delete_user' value='<?= $user['id'] ?>'>Delete</button></form></td>
    <?php
  }

  $res->close();
     ?>
     </tr>
   </tbody>
 </table>

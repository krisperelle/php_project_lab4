<?php
// include('header.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET' AND isset($_GET['delete_user'])) {
  deleteUser($_GET['delete_user']);
  //gets id, runs function
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  if (isset($_GET['user_id'])) { //press button
    updateUser($_GET['user_id']);

  } else {
    createUser();
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' AND isset($_GET['user_id'])) {
  //jei GET ir user id tada vykdo kas zemiau
  $editUserData = getUserByID($_GET['user_id']);
}
 ?>
 <form action="" method="post">
 <input class="cont" type="text" name="Name" placeholder="First name" value="<?= isset($editUserData['name']) ? $editUserData['name'] : "" ?>"> # ? shorten if else
 <input class="cont" type="text" name="LastName" placeholder="Last name" value="<?= isset($editUserData['lastN'])? $editUserData['lastN']:"" ?>">
 <input class="cont" type="text" name="Address" placeholder="Address" value="<?= isset($editUserData['address']) ? $editUserData['address']:"" ?>">
 <input class="cont" type="email" name="Email" placeholder="Email address" value="<?= isset($editUserData['email'])? $editUserData['email']:"" ?>">
 <input class="cont" type="password" name="Password" placeholder="Password">
 <br></br>
 <input class="submit" name="submit_user" type="submit" value="save">
 </form>

<?php
$users = getUserWithRoles();
//select all users that have roles
//is rezu padaro array ir priskiria users
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
    //paima useriu array ir priskiria useriui i lentele, nereikia indeksu
    ?>
     <tr>
       <td><?php echo $user['id']?></td>
       <td><?php echo $user['Name']?></td>
       <td><?php echo $user['LastName']?></td>
       <td><?php echo $user['Email']?></td>
       <td>
         <a href="?user_id=<?= $user['id'] ?>">Edit</a>
         <form method='GET'><button onclick="return confirm('U SURE?')" class='submit' name='delete_user' value='<?= $user['id'] ?>'>Delete</button></form></td>
    <?php
  }
     ?>
     </tr>
   </tbody>
 </table>

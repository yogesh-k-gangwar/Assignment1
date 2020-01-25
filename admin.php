<!--PHP Coding-->
<?php
   session_start();
   include 'conn.php';
   if (strlen($_SESSION['user']) == 0) {
       header('location:index.php');
   } else {
       $id = $_GET['id'];
       $fnameErr = $emailErr  = $contactErr = $unameErr = "";
       $count=0;         //variable to count the errors
       if ($_SERVER["REQUEST_METHOD"] == "POST") {
           if (!preg_match("/^[a-zA-Z ]*$/", $_POST["fname"])) {     //first name validation
               $count++;
               $fnameErr = "Only letters allowed";
           }
   
                                     
           if (!preg_match("/^[a-zA-Z ]*$/", $_POST["lname"])) {     //last name validation
               $count++;
               $lnameErr = "Only letters allowed";
           }
   
           $mail=$_POST["email"]  ;
           $sql1="select email from users where email='$mail'";      //SQL STATEMENT
           $result1 = mysqli_query($conn, $sql1);
           $check1 = mysqli_fetch_array($result1);
           $sql2="select email from users where id='$id'";      //SQL STATEMENT
           $result2 = mysqli_query($conn, $sql2);
           $check2 = mysqli_fetch_array($result2);           
           if ($mail!=$check2[0]) {
               if ($check1>0) {                                             //email validation
                   $count++;
                   $emailErr="Email already exist";
               } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                   $count++;
                   $emailErr = "Invalid email format";
               }
           }  
                               
           if (!preg_match("/^[0-9]*$/", $_POST["cont"])) {             //contact validation
               $count++;
               $contactErr = "Invalid Contact";
           }

           $uname = $_POST["uname"];                  //username validation
            $sql3="select username from users where username='$uname'";//SQL STATEMENT
            $result3 = mysqli_query($conn, $sql3);
           $check3 = mysqli_fetch_array($result3);
           $sql4="select username from users where id='$id'";      //SQL STATEMENT
           $result4 = mysqli_query($conn, $sql4);
           $check4 = mysqli_fetch_array($result4);
           //check availability of username
           if ($uname!=$check4[0]) {
               if ($check3>0) {
                   $count++;
                   $unameErr="Username already exist";
               }
           }
          
           if ($count>0) {
               $_SERVER['PHP_SELF'];
           } else {
               if (isset($_POST['submit'])) {
                   $fname   = $_POST['fname'];
                   $lname   = $_POST['lname'];
                   $email   = $_POST['email'];
                   $contact = $_POST['cont'];
                   $admin   = $_POST['isAdmin'];
                   $uname   = $_POST['uname'];
                   $sql = "update users set first_name='$fname',last_name='$lname',contact='$contact',email='$email',is_admin='$admin',username='$uname' where id='$id'";
                   if (mysqli_query($conn, $sql)) {
                       $host = $_SERVER['HTTP_HOST'];
                       $uri  = rtrim(dirname($_SERVER['PHP_SELF']));
                       $page = "admin.php";
                       $http = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
                       header("location:$http://$host$uri/$page");
                   } else {
                       echo mysqli_error($conn);
                   }
               }
           }
       }
   $sql    = "select * from users";
   $result = mysqli_query($conn, $sql); 
?>
<!--HTML coding-->
<html>
   <!--head-->
   <head>
      <title >Admin Panel</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
      <style>
         .error{color:red}
      </style>
   </head>
   <!--body-->
   <body>
      <h2 style="color:red;">Admin's Panel</h2>
      <div class="container">
         <div class="table-responsive">
         <!--table-->
            <table class="table table-bordered">
               <thead>
                  <tr>
                     <th>#</th>
                     <th>First Name</th>
                     <th>Last Name</th>
                     <th>Contact</th>
                     <th>Email</th>
                     <th>Username</th>
                     <th>Status</th>
                     <th>Change Status</th>
                     <th>User Admin</th>
                     <th>Update</th>
                     <th>Delete</th>
                  </tr>
               </thead>
               <?php while ($num = mysqli_fetch_array($result)) { ?>
               <tbody>
                  <form method="POST">
                     <tr>
                        <!--ID-->
                        <td ><?= $num['id']; ?></td>
                        <!--First Name-->
                        <td><?php if ($_GET['id'] == $num['id']) {?>
                           <input type="text" name="fname" value="<?= $num['first_name']; ?>">
                           <span class="error"> <?php echo $fnameErr;?></span><?php } else {?>
                           <?= $num['first_name']; ?>
                           <?php }?>
                        </td>
                        <!--Last Name-->
                        <td>
                           <?php if ($_GET['id'] == $num['id']) {?>
                           <input type="text" name="lname" value="<?= $num['last_name']; ?>">
                           <span class="error"> <?php echo $lnameErr;?></span>
                           <?php } else {?>
                           <?= $num['last_name']; ?>
                           <?php }?>
                        </td>
                        <!--Contact-->
                        <td>
                           <?php if ($_GET['id'] == $num['id']) { ?>
                           <input type="text" name="cont" value="<?= $num['contact']; ?>">
                           <span class="error"> <?php echo $contactErr;?></span>
                           <?php } else { ?>
                           <?= $num['contact']; ?>
                           <?php }?>
                        </td>
                        <!--Email-->
                        <td>
                           <?php if ($_GET['id'] == $num['id']) {?>
                           <input type="text" name="email" value="<?= $num['email']; ?>">
                           <span class="error"> <?php echo $emailErr;?></span>
                           <?php } else {?>
                           <?= $num['email']; ?>
                           <?php }?>
                        </td>
                        <!--Username-->
                        <td>
                           <?php if ($_GET['id'] == $num['id']) {?>
                           <input type="text" name="uname" value="<?= $num['username']; ?>">
                           <span class="error"> <?php echo $unameErr;?></span>
                           <?php } else {?>
                           <?= $num['username']; ?>
                           <?php }?>
                        </td>
                        <!--Status-->
                        <td>
                           <?php if ($num['is_active'] == 0) {
                              echo "<p style='color:red'>Deactive</p>";
                              } else {
                              echo "<p style='color:green'>Active</p>";
                              }
                              ?>
                        </td>
                        <!--Change Status-->
                        <td>
                           <?php if ($num['is_active'] == 0) { ?>
                           <a href="active.php?id=<?php echo $num['id'];?>" class="btn btn-success" role="button">Activate</a>
                           <?php } else {?>
                           <a href="active.php?id=<?php echo $num['id'];?>" class="btn btn-warning" role="button">Deactivate</a>
                           <?php }?>
                        </td>
                        <!--Admin-->
                        <td>
                           <select name="isAdmin">
                              <option value='0'>User</option>
                              <option value='1'>Admin</option>
                           </select>
                           <span><input type="checkbox" <?php echo($num['is_admin'])==1 ?'checked': '' ;?>/></span>
                        </td>
                        <!--Update-->
                        <td>
                           <?php
                              if ($_GET['id'] == $num['id']) {
                                  ?>
                           <a href="admin.php"><button type="submit" name="submit" class="btn btn-success" >Save</button></a>
                           <?php
                              } else {?>
                           <a href="admin.php?id=<?php echo $num['id'];?>"><button type="button" name="edit" class="btn btn-primary">Edit</button></a>
                           <?php }?>
                        </td>
                        <!--delete-->
                        <td>
                           <a href="delete.php?id=<?php echo $num['id'];?>" class="btn btn-danger" role="button">Delete</a>
                        </td>
                     </tr>
                     <?php } ?>
                  </form>
               </tbody>
            </table>
         </div>
         <a href="logout.php" class="btn btn-danger" role="button">Logout</a>
      </div>
   </body>
</html>
<?php
   }
   mysqli_close($conn);
?>


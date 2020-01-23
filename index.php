<!--PHP Coding-->
<?php
session_start();
include 'conn.php';         //connection

$fnameErr = $emailErr  = $contactErr = $pwdErr = $unameErr = "";
$fname = $email = $contact  = $pwd = $cpwd = $uname = "";
$count=0;         //variable to count the errors

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $fname = test_input($_POST["fname"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$fname)) {
      $count++;
      $fnameErr = "Only letters and white space allowed";
    }
  
    $lname=test_input($_POST["lname"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$lname)) {
      $count++;
      $lnameErr = "Only letters and white space allowed";
    }

    $email = test_input($_POST["email"]);
    $sql1="select email from login where email='$email'";        //SQL STATEMENT
    $result1 = mysqli_query($conn,$sql1);
    $check1 = mysqli_fetch_array($result1);
    //check availability of email
    if($check1>0){
      $count++;
      $emailErr="Email already exist";
    }
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $count++;
      $emailErr = "Invalid email format";
    }
  
    $contact = test_input($_POST["cont"]);
    // check if contact contains only numbers is
    if (!preg_match("/^[0-9]*$/",$contact)) {
      $count++;
      $contactErr = "Invalid Contact";
    }   
    
    $uname = test_input($_POST["uname"]);
    $sql2="select username from login where username='$uname'";        //SQL STATEMENT
    $result2 = mysqli_query($conn,$sql2);
    $check2 = mysqli_fetch_array($result2);
    //check availability of username
    if($check2>0){
      $count++;
      $unameErr="Username already exist";
    }

    $pwd=test_input($_POST["pswd"]);
    $cpwd=test_input($_POST["cnfm_pswd"]);
    //check password match with confirm password
    if($pwd!=$cpwd){
      $count++;
      $pwdErr="Password and Confirm Password does not match";
    }

    if(/*$fnameErr == "" || $emailErr  == "" || $contactErr == "" || $pwdErr == ""*/$count>0){     //checking for errors
      $_SERVER['PHP_SELF'];
    }
    else{
      if(isset($_POST['submit']))
    {
       $_SESSION['user']=$_POST['uname'];   //session created
        $fname=$_POST['fname'];
        $lname=$_POST['lname'];
        $contact=$_POST['cont'];
        $email=$_POST['email'];
        $username=$_POST['uname'];
      $password=$_POST['pswd'];

      //inserting data in database
    $sql="Insert into login (first_name, last_name, contact, email, username, password) values('$fname','$lname','$contact','$email','$username','$password')";
    if (mysqli_query($conn, $sql)) {
      $_SESSION['user']=$_POST['uname'];
      $host=$_SERVER['HTTP_HOST'];
      $uri=rtrim(dirname($_SERVER['PHP_SELF']));
      $page="welcome.php";
      $http=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") ;
      header("location:$http://$host$uri/$page");  
      
     } else {
        echo  mysqli_error($conn);
     }
    }
    }
  
  
}
//function to perform validate operations
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


 mysqli_close($conn);

?>


<!--HTML Coding-->
<html>
<!--head-->
<head>
<title>Registration Form</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<style>
.error{color:red}
</style>
</head>
<!--body-->
<body style="background-color:powderblue">

<h2 style="margin:20px;color:blue">Register Yourself</h2>


<div class="form-group">
<form method="POST" class="form-horizontal style-form" >
<!--first name-->
<div class="form-group">
<label  for="fname" class="col-sm-3 col-sm-3 control-label" ><h5><span class="error">*</span>First Name</h5></label>
<div class="col-sm-4">
<input  type="text" class="form-control" name="fname" placeholder="Enter First Name" required>
<span class="error"> <?php echo $fnameErr;?></span>
</div>
</div>
<!--last name-->
<div class="form-group">
<label  for="lname" class="col-sm-3 col-sm-3 control-label"><h5>Last Name</h5></label>
<div class="col-sm-4">
<input  type="text" class="form-control" name="lname" placeholder="Enter Last Name" >
<span class="error"> <?php echo $lnameErr;?></span>
</div>
</div>
<!--contact-->
<div class="form-group">
<label  for="cont" class="col-sm-3 col-sm-3 control-label"><h5><span class="error">*</span>Contact</h5></label>
<div class="col-sm-4">
<input  type="text" class="form-control" name="cont" placeholder="Enter Contact Number" minlength="10" maxlength="10" required>
<span class="error"> <?php echo $contactErr;?></span>
</div></div>
<!--email-->
<div class="form-group">
<label  for="email" class="col-sm-3 col-sm-3 control-label"><h5><span class="error">*</span>Email</h5></label>
<div class="col-sm-4">
<input id="mail" class="form-control" type="text" name="email" placeholder="Enter Email" required>
<span class="error"> <?php echo $emailErr;?></span>
</div></div>
<!--username-->
<div class="form-group">
<label  for="uname" class="col-sm-4 col-sm-4 control-label"><h5><span class="error">*</span>Username</h5><span><p>(username should not be less than 6 characters)</p></span></label>
<div class="col-sm-4">
<input id="uname" class="form-control" type="text" name="uname" placeholder="Enter username" minlength="6"  required>
<span class="error"> <?php echo $unameErr;?></span>
</div></div>
<!--password-->
<div class="form-group">
<label  for="pswd" class="col-sm-3 col-sm-3 control-label"><h5><span class="error">*</span>Password</h5></label>
<div class="col-sm-4">
<input  type="password" class="form-control" name="pswd" placeholder="Enter Password" required>
</div></div>
<!--confirm password-->
<div class="form-group">
<label  for="cnfm_pswd" class="col-sm-3 col-sm-3 control-label"><h5><span class="error">*</span>Re-Enter Password</h5></label>
<div class="col-sm-4">
<input  type="password" class="form-control" name="cnfm_pswd" placeholder="Confirm Password" required>
<span class="error"> <?php echo $pwdErr;?></span>
</div></div>
<!--button-->
<button type="submit" name="submit" class="btn btn-primary" style="margin:20px">Sign Up</button>
<a href="login.php" class="btn btn-success" role="button">Already Registered</a>

</form>
</div>
</body>

</html>
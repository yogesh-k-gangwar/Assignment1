<!--PHP coding-->
<?php 
session_start();
include 'conn.php';     //connection
if(isset($_POST['submit']))
    {
	    $username=$_POST['uname'];
        $password=$_POST['pswd'];
        $sql="select * from login where username='$username' and password='$password'";        //SQL STATEMENT
        $result = mysqli_query($conn,$sql);
        $check = mysqli_fetch_array($result);       
        if(isset($check))
        {
            //redirecting to other page
            $_SESSION['user']=$_POST['uname'];                  //session created
            $host=$_SERVER['HTTP_HOST'];
            $uri=rtrim(dirname($_SERVER['PHP_SELF']));
            $page="welcome.php";
            $http=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") ;
            header("location:$http://$host$uri/$page");     
          
        }
        else
        {
            $err="Invalid username and password";
        }   
    }
mysqli_close($conn);   //CLOSE CONNECTION
?>


<!--HTML coding -->
<html>
<!--head-->
<head>
    <title>Login Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <style>
        .error{color:red}
    </style>
</head>
<!--body-->
<body style="background-color:powderblue">
    <h2 style="margin:20px;color:blue">Log In</h2>
    <div class="form-group">
        <form method="POST" class="form-horizontal style-form" >
        <!--username-->
            <div class="form-group">
                <label  for="uname" class="col-sm-3 col-sm-3 control-label"><h5>Username</h5></label>
                <div class="col-sm-4">
                    <input id="uname" class="form-control" type="text" name="uname" placeholder="Enter Username" required>
                </div>
            </div>
        <!--password-->
            <div class="form-group">
                <label  for="pswd" class="col-sm-3 col-sm-3 control-label"><h5>Password</h5></label>
                <div class="col-sm-4">
                    <input  type="password" class="form-control" name="pswd" placeholder="Enter Password" required>
                </div>
                <span class="error" style="margin:20px"><?php echo $err; ?></span>
            </div>
        <!--buttton-->
            <button type="submit" name="submit" class="btn btn-primary" style="margin:20px">Sign In</button>
            <a href="index.php" class="btn btn-success" role="button">Register Now</a>
        </form>
    </div>
</body>
</html>
<!--PHP coding-->
<?php 
session_start();
include 'conn.php';
if(strlen($_SESSION['user'])==0)
{	
    header('location:index.php');
}
else
{
    $sql="select first_name,last_name from users where username='".$_SESSION['user']."'";
    $result = mysqli_query($conn,$sql);
    while($name = mysqli_fetch_array($result))
    {
?> 
<!--HTML Coding-->
<html>
<!--head-->
<head>
    <title>Welcome Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<!--body-->
<body>
    <h3>Congrats <?php echo $name['first_name']; echo " ".$name['last_name']?>! you are successfully Logged In</h3>
    <a href="logout.php" class="btn btn-danger" role="button">Logout</a>
</body>
</html>
<?php 
    } 
}
?>
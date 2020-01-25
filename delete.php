<?php 
include 'conn.php';

$id = $_GET['id']; 
if(!empty($id)){
    $sql = "delete from users where id=".$id."";    //delete
    if (mysqli_query($conn, $sql)) {
        $host=$_SERVER['HTTP_HOST'];
        $uri=rtrim(dirname($_SERVER['PHP_SELF']));
        $page="admin.php";
        $http=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") ;
        header("location:$http://$host$uri/$page");  
      } 
      else {
        echo  mysqli_error($conn);
      }
    }
?>
<?php 
    session_start();
    $_SESSION['user']=="";
    session_unset();                            //session destroyed
    $host=$_SERVER['HTTP_HOST'];
    $uri=rtrim(dirname($_SERVER['PHP_SELF']));
    $page="index.php";
    $http=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") ;
    header("location:$http://$host$uri/$page"); 

?>
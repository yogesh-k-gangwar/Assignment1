<?php
   include 'conn.php';
   
   $id = $_GET['id'];
   if (!empty($id))
   {
       $sql = "select is_active from users where id=" . $id . ""; //SQL STATEMENT
       $result = mysqli_query($conn, $sql);
       $num = mysqli_fetch_array($result);
       if (isset($num))
       {
           if ($num['is_active'] == 0)
           {
               $sql1 = "update users set is_active='1' where id=" . $id . "";       //active
               if (mysqli_query($conn, $sql1))
               {
                   $host = $_SERVER['HTTP_HOST'];
                   $uri = rtrim(dirname($_SERVER['PHP_SELF']));
                   $page = "admin.php";
                   $http = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
                   header("location:$http://$host$uri/$page");
               }
           }
           elseif ($num['is_active'] == 1)
           {
               $sql2 = "update users set is_active='0' where id=" . $id . "";        //deactive
               if (mysqli_query($conn, $sql2))
               {
                   $host = $_SERVER['HTTP_HOST'];
                   $uri = rtrim(dirname($_SERVER['PHP_SELF']));
                   $page = "admin.php";
                   $http = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
                   header("location:$http://$host$uri/$page");
               }
           }
       }
       else
       {
           echo mysqli_error($conn);
       }
   }
?>


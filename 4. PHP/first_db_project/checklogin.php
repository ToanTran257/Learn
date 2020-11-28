<?php
 session_start();

 $link = mysqli_connect("localhost", "root", "") or die(mysql_error());
 mysqli_select_db($link, "first_db") or die("Cannot connect to datbase");

 $username = mysqli_real_escape_string($link, $_POST['username']);
 $password = mysqli_real_escape_string($link, $_POST['password']);
 $is_login = true;

 $query = mysqli_query($link, "Select * from users WHERE username='$username'");
 $exists = mysqli_num_rows($query);

 $table_users = "";
 $table_password = "";

 if($exists > 0)
 {
  while($row = mysqli_fetch_assoc($query))
  {
   $table_users = $row['username'];
   $table_password = $row['password'];
  }

  if(($username == $table_users) && ($password == $table_password))
  {
    $_SESSION['user'] = $username;
    header("location: home.php"); //redirect the user to the authenticated home page
  }
  else
  {
   Print '<script>alert("Incorrect Password!");</script>';
   Print '<script>window.location.assign("login.php");</script>';
  }
 }
 else
 {
  Print '<script>alert("Incorrect Username!");</script>';
  Print '<script>window.location.assign("login.php");</script>';
 }
?>
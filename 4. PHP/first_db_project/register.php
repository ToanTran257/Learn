<html lang="en">
<body>
 <h2>Registration Page</h2>
 <a href="index.php">Click here to go back</a>
 <br/><br/>
 <form action="register.php" method="POST">
  Enter Username: <input type="text" name="username" required="required" /> <br/>
  Enter Password: <input type="password" name="password" required="required" /> <br/>
  <input type="submit" value="Register">
 </form>
</body>
</html>

<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
 $link = mysqli_connect("localhost", "root", "") or die(mysql_error());
 mysqli_select_db($link, "first_db") or die("Cannot connect to datbase");

 $username = mysqli_real_escape_string($link, $_POST['username']);
 $password = mysqli_real_escape_string($link, $_POST['password']);
 $is_registered = true;

 $query = mysqli_query($link, "Select * from users");
 while($row = mysqli_fetch_array($query)) // display all rows from query
 {
  $table_users = $row['username'];
  if($username == $table_users)
  {
   $is_registered = false;
   Print '<script>alert("Username has been taken!");</script>';
   Print '<script>window.location.assign("register.php");</script>'; //redirects to register.php - this page
  }
 }

 if($is_registered)
 {
  mysqli_query($link, "INSERT INTO users (username, password) VALUES ('$username','$password')");
  Print '<script>alert("Successfully Registered!");</script>';
  Print '<script>window.location.assign("register.php);</script>';
 }
}
?>
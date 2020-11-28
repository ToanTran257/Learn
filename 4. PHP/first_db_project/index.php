<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>My first PHP Website</title>
</head>
<body>
 <?php
  echo "<p>Hello World!</p>";
 ?>
 <a href="login.php">Click here to login</a>
 <a href="register.php">Click here to register</a>
</body>
<br>
<h2 style="text-align: center">My list</h2>
<table style="border: black 1px solid; width: 100%">
 <tr>
  <th>Id</th>
  <th>Details</th>
  <th>Post Time</th>
  <th>Edit Time</th>
 </tr>

 <?php
  $link = mysqli_connect("localhost", "root", "") or die(mysql_error());
  mysqli_select_db($link, "first_db") or die("Cannot connect to datbase");

  $query = mysqli_query($link, "Select * from list where public='yes'");
  while($row = mysqli_fetch_array($query))
  {
    Print "<tr>";
      Print '<td style="text-align: center">'. $row['id'] . "</td>";
      Print '<td style="text-align: center">'. $row['details'] . "</td>";
      Print '<td style="text-align: center">'. $row['date_posted']. " - ". $row['time_posted']. "</td>";
      Print '<td style="text-align: center">'. $row['date_edited']. " - ". $row['time_edited'].  "</td>";
  }
 ?>
</table>
</html>
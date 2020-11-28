<html>
 <head>
  <title>My First PHP Website</title>
 </head>
 <?php
  session_start();
  if($_SESSION['user']) { // check if the user is logged in
  }
  else
  {
   header("location: index.php"); //redirect if not logged in
  }

  $user = $_SESSION['user'];
 ?>
 <body>
  <h2>Home Page</h2>
  <p>Hello <?php Print "$user"?>!</p> <!--Displays user's name -->
  <a href="logout.php">Click here to logout</a><br><br>
  <form action="add.php" method="POST">
   Add more to list: <input type="text" name="details" /> <br>
   Public post? <input type="checkbox" name="public[]" value="yes" /> <br>
   <input type="submit" value="Add to list"/>
  </form>
  <h2 style="text-align: center">My list</h2>
  <table style="border: black 1px solid; width: 100%">
   <tr>
    <th>Id</th>
    <th>Details</th>
    <th>Post Time</th>
    <th>Edit Time</th>
    <th>Edit</th>
    <th>Delete</th>
    <th>Public Post</th>
   </tr>

   <?php
    $link = mysqli_connect("localhost", "root", "") or die(mysql_error());
    mysqli_select_db($link, "first_db") or die("Cannot connect to datbase");

    $query = mysqli_query($link, "Select * from list");
    while($row = mysqli_fetch_array($query))
    {
      Print "<tr>";
        Print '<td style="text-align: center">'. $row['id'] . "</td>";
        Print '<td style="text-align: center">'. $row['details'] . "</td>";
        Print '<td style="text-align: center">'. $row['date_posted']. " - ". $row['time_posted']. "</td>";
        Print '<td style="text-align: center">'. $row['date_edited']. " - ". $row['time_edited'].  "</td>";
        Print '<td align="center"><a href="edit.php?id='. $row['id'] .'">edit</a> </td>';
        Print '<td align="center"><a href="#" onclick="myFunction('.$row['id'].')">delete</a> </td>';
        Print '<td style="text-align: center">'. $row['public']. "</td>";
    }
   ?>
  </table>
  <script>
    function myFunction(id)
    {
      var r=confirm("Are you sure you want to delete this record?");
      if (r)
      {
        window.location.assign("delete.php?id=" + id);
      }
    }
  </script>
 </body>
</html>
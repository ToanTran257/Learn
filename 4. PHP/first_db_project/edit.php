<html>
 <head>
  <title>My first PHP Websites</title>
 </head>
 <?php
  session_start();
  if($_SESSION['user']){}
  else {
   header('location: index.php');
  }

  $user = $_SESSION['user'];
 ?>
 <body>
  <h2>Home Page</h2>
  <p>Hello <?php Print "$user"?>!</p> <!--Displays user's name-->
		<a href="logout.php">Click here to logout</a><br/><br/>
		<a href="home.php">Return to Home page</a>
		<h2 style="align-items: center">Currently Selected</h2>
		<table style="border: black 1px solid; width: 100%;">
   <tr>
     <th>Id</th>
     <th>Details</th>
     <th>Post Time</th>
     <th>Edit Time</th>
     <th>Public Post</th>
    </tr>
    <?php
     if(!empty($_GET['id']))
     {
      $id = $_GET['id'];
      $_SESSION['id'] = $id;
      $id_exists = true;

      $link = mysqli_connect("localhost", "root", "") or die(mysql_error());
mysqli_select_db($link, "first_db") or die("Cannot connect to datbase");
      
      $query = mysqli_query($link, "Select * from list WHERE id='$id'");
      $count = mysqli_num_rows($query);

      if($count > 0)
      {
       while($row = mysqli_fetch_array($query))
       {
        Print "<tr>";
         Print '<td align="center">'. $row['id'] . "</td>";
         Print '<td align="center">'. $row['details'] . "</td>";
         Print '<td align="center">'. $row['date_posted']. " - ". $row['time_posted']."</td>";
         Print '<td align="center">'. $row['date_edited']. " - ". $row['time_edited']. "</td>";
         Print '<td align="center">'. $row['public']. "</td>";
							 Print "</tr>";
       }
      }
      else
      {
       $id_exists = false;
      }
     }
    ?>
  </table>
  <br>
  <?php
   if($id_exists)
   {
    Print '
     <form action="edit.php" method="POST">
      Enter new detail: <input type="text" name="details"/><br>
      Public post? <input type="checkbox" name="public[]" value="yes"/><br>
      <input type="submit" value="Update List"/>
     </form>
    ';
   }
   else
   {
    Print '<h2 style="align-items:center;">There is no data to be edited.</h2>';
   }
  ?>
 </body>
</html>

<?php
 if($_SERVER['REQUEST_METHOD'] == "POST")
 {
  $link = mysqli_connect("localhost", "root", "") or die(mysql_error());
  mysqli_select_db($link, "first_db") or die("Cannot connect to datbase");
  
  $details = mysqli_real_escape_string($link, $_POST['details']);
  $public = "no";

  $id = $_SESSION['id'];
  $time = strftime("%X");
  $date = strftime("%B %d, %Y");

  foreach($_POST['public'] as $list)
  {
   if($list != null)
   {
    $public = "yes";
   }
  }

  mysqli_query($link, "UPDATE list set details='$details', public='$public', date_edited='$date', time_edited='$time' WHERE id='$id'");
  
  header("location: home.php");
 }
?>
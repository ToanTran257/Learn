<?php
 session_start();
 if($_SESSION['user']) {
 }
 else {
  header("location: index.php");
 }

 if($_SERVER['REQUEST_METHOD'] == "POST")
 {
  $link = mysqli_connect("localhost", "root", "") or die(mysql_error());
  mysqli_select_db($link, "first_db") or die("Cannot connect to datbase");

  $details = mysqli_real_escape_string($link, $_POST['details']);
  $time = strftime("%X");
  $date = strftime("%B %d, %Y");
  $public = "no";

  foreach($_POST['public'] as $each_check)
  {
   if($each_check != null)
   {
    $public = "yes";
   }
  }

  mysqli_query($link, "INSERT INTO list(details, date_posted, time_posted, public) VALUES ('$details', '$date', '$time', '$public')");

  header("location: home.php");
 }
 else {
  header("location: home.php");
 }
?>
<?php
 session_start();

 if($_SESSION['user']) {}
 else
 {
  header("location: index.php");
 }

 if($_SERVER['REQUEST_METHOD'] == "GET")
 {
  $link = mysqli_connect("localhost", "root", "") or die(mysql_error());
  mysqli_select_db($link, "first_db") or die("Cannot connect to datbase");

  $id = $_GET['id'];
  mysqli_query($link, "DELETE FROM list where id='$id'");
  header("location: home.php");
 }
?>
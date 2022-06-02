<?php
  date_default_timezone_set("Asia/Ho_Chi_Minh");
  $host = "localhost";
  $username = "root";
  $password = "root";
  $database = "my_music";
  $connection = mysqli_connect($host,$username,$password,$database) or die ("Không thể kết nối đến database");
	$mysqli = new mysqli($host, $username, $password, $database);
	mysqli_query($connection,"SET NAMES 'UTF8'");
  error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
?>
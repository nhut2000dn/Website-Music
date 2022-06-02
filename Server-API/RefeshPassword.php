<?php
  include("config/connection.php");
  $query_refesh_password = 'UPDATE account SET password = "123456" WHERE account.id = ' . $_POST['idAccount'];
  $result_refesh_password = mysqli_query($connection,$query_refesh_password) or die ("loi".mysqli_error($connection));
  if ($result_refesh_password) {
    echo "succesful";
  }
?>
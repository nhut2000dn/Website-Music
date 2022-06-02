<?php
  include("config/connection.php");
  $query_delete_account = 'DELETE FROM account WHERE id = ' . $_POST['idAccount'];
  $result_delete_account = mysqli_query($connection,$query_delete_account) or die ("loi".mysqli_error($connection));
  if ($result_delete_account) {
    echo "succesful";
  }
?>
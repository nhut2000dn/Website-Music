<?php
  include("config/connection.php");
  $query_check_password = 'SELECT * FROM account WHERE account.id="' . $_POST['idAccount'] . '" AND account.password="' . $_POST['password'] . '"';
  $result_check_password = mysqli_query($connection,$query_check_password);
  if (!mysqli_num_rows($result_check_password) > 0) {
    echo 'incorrect-password';
  } 
  else {
    $query_update_password = 'UPDATE account SET password = "'. $_POST["newPassword"] .'" WHERE account.id = '. $_POST["idAccount"] .';';
    $result_update_password = mysqli_query($connection,$query_update_password) or die ("loi".mysqli_error($connection));  
    if ($result_update_password) {
      echo "succesful";
    }
  }
?>
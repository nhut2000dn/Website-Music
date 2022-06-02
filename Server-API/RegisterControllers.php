<?php
  include("config/connection.php");
  $query_check_username = 'SELECT * FROM account WHERE account.username="' . $_POST['UsernameRegister'] . '"';
  $result_check_username = mysqli_query($connection,$query_check_username);
  $query_check_email = 'SELECT * FROM account WHERE account.email="' . $_POST['EmailRegister'] . '"';
  $result_check_email = mysqli_query($connection,$query_check_email);
  if (mysqli_num_rows($result_check_username) > 0) {
    $resp['error-username'] = 'username-existed';
    $resp['status'] = false;
  } else if (mysqli_num_rows($result_check_email) > 0) {
    $resp['error-email'] = 'email-existed';
    $resp['status'] = false;
  } else {
    $query_insert_account = 'INSERT INTO account (id, full_name, username, password, email, active_status, user_types_id) VALUES 
    (NULL, "'. $_POST['FullnameRegister'].'", "'. $_POST['UsernameRegister'].'", "'. $_POST['PasswordRegister'].'", "'. $_POST['EmailRegister'].'", "1", "2");';
    $result_insert_account = mysqli_query($connection,$query_insert_account) or die ("loi".mysqli_error($connection));
    $resp['status'] = true;    
  }
  echo json_encode($resp);
?>
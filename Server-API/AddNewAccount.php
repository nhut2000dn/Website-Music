<?php
  include("config/connection.php");
  $check_update = true;
  
  $phpFileUploadErrors = array(
    0 => 'There is no error, the file uploaded with success',
    1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
    2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
    3 => 'The uploaded file was only partially uploaded',
    4 => 'No file was uploaded',
    6 => 'Missing a temporary folder',
    7 => 'Failed to write file to disk.',
    8 => 'A PHP extension stopped the file upload.',
  );

  if (file_exists($_FILES['imgFileAdd']['tmp_name']) || is_uploaded_file($_FILES['imgFileAdd']['tmp_name']))  {
    $error = '';
    $anh = $_FILES['imgFileAdd']['name'];
    $ext_error = false;
    $extensions = array('jpg','jpeg','gif','png','PNG');
    $file_ext = explode('.',$_FILES['imgFileAdd']['name']);
    $file_ext = end($file_ext);
    
    if (!in_array($file_ext, $extensions)) {
      $ext_error = true;
    }
    if ($_FILES['imgFileAdd']['error']) {
      echo $phpFileUploadErrors[$_FILES['imgFileAdd']['error']];
    }
    elseif ($ext_error) {
      $check_update = false;
      echo "The file image must be in format jpg, jpeg, gif, png !";
    }
    else {
    }
  }
  $query_check_username = 'SELECT * FROM account WHERE account.username="' . $_POST['username'] . '"';
  $result_check_username = mysqli_query($connection,$query_check_username);
  $query_check_email = 'SELECT * FROM account WHERE account.email="' . $_POST['email'] . '"';
  $result_check_email = mysqli_query($connection,$query_check_email);
  if (mysqli_num_rows($result_check_username) > 0) {
    $resp['error-username'] = 'username-existed';
    $resp['status'] = false;
  } else if (mysqli_num_rows($result_check_email) > 0) {
    $resp['error-email'] = 'email-existed';
    $resp['status'] = false;
  } else {
    if (!file_exists($_FILES['imgFileAdd']['tmp_name']) || !is_uploaded_file($_FILES['imgFileAdd']['tmp_name']))  {
      $query_insert_account = 'INSERT INTO account (id, full_name, username, password, email, user_types_id) VALUES 
      (NULL, "'. $_POST['fullName'].'", "'. $_POST['username'].'", "'. $_POST['password'].'", "'. $_POST['email'].'", "'. $_POST['userType'].'");';
      $result_insert_account = mysqli_query($connection,$query_insert_account) or die ("loi".mysqli_error($connection));
      $resp['status'] = true;    
      $resp['sql'] = $query_insert_account;
    } else {
      $query_insert_account = 'INSERT INTO account (id, full_name, username, password, email, image, user_types_id) VALUES 
      (NULL, "'. $_POST['fullName'].'", "'. $_POST['username'].'", "'. $_POST['password'].'", "'. $_POST['email'].'", "' . $_FILES['imgFileAdd']['name'] . '", "'. $_POST['userType'].'");';
      $result_insert_account = mysqli_query($connection,$query_insert_account) or die ("loi".mysqli_error($connection));
      if($result_insert_account) {
        $resp['status'] = true;    
        move_uploaded_file($_FILES['file']['tmp_name'], '../Client-side/images/account/'.$_FILES['imgFileAdd']['name']);
      }
    }
  }
  echo json_encode($resp);
?>
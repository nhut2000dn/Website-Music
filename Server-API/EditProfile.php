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

  if (file_exists($_FILES['file']['tmp_name']) || is_uploaded_file($_FILES['file']['tmp_name']))  {
    $error = '';
    $anh = $_FILES['file']['name'];
    $ext_error = false;
    $extensions = array('jpg','jpeg','gif','png','PNG');
    $file_ext = explode('.',$_FILES['file']['name']);
    $file_ext = end($file_ext);
    
    if (!in_array($file_ext, $extensions)) {
      $ext_error = true;
    }
    if ($_FILES['file']['error']) {
      echo $phpFileUploadErrors[$_FILES['img-file']['error']];
    }
    elseif ($ext_error) {
      $check_update = false;
      echo "The file image must be in format jpg, jpeg, gif, png !";
    }
    else {
    }
  }

  if ($check_update == true) {
  
    if (!file_exists($_FILES['file']['tmp_name']) || !is_uploaded_file($_FILES['file']['tmp_name']))  {
      $queryUpdate = 'UPDATE account SET full_name="' . $_POST['fullName'] . '"  WHERE id=' . $_POST['idAccount'];
      $result   = mysqli_query($connection,$queryUpdate)or die("loi cap nhat".mysqli_error($con));
      if($result) {
        echo 'succesful';
      }
    } else {
      $queryUpdate = 'UPDATE account SET full_name="' . $_POST['fullName'] . '", image="' . $_FILES['file']['name'] . '"  WHERE id=' . $_POST['idAccount'];
      $result   = mysqli_query($connection,$queryUpdate)or die("loi cap nhat".mysqli_error($con));
      if($result) {
        move_uploaded_file($_FILES['file']['tmp_name'], '../Client-side/images/account/'.$_FILES['file']['name']);
        echo 'succesful';
      }
    }
  }
?>
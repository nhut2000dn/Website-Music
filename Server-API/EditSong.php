<?php
  include("config/connection.php");
  $check_update = true;

  //format string to url_name
  function vn_to_str ($str){
  
    $unicode = array(
    
    'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
    
    'd'=>'đ',
    
    'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
    
    'i'=>'í|ì|ỉ|ĩ|ị',
    
    'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
    
    'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
    
    'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
    
    'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
    
    'D'=>'Đ',
    
    'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
    
    'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
    
    'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
    
    'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
    
    'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
    
    );
    
    foreach($unicode as $nonUnicode=>$uni){
    
    $str = preg_replace("/($uni)/i", $nonUnicode, $str);
    
    }
    $str = str_replace(' ','-',$str);
    
    return $str;
  
  }
  
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

  if (file_exists($_FILES['fileImage']['tmp_name']) || is_uploaded_file($_FILES['fileImage']['tmp_name']))  {
    $error = '';
    $anh = $_FILES['file']['name'];
    $ext_error = false;
    $extensions = array('jpg','jpeg','gif','png','PNG');
    $file_ext = explode('.',$_FILES['fileImage']['name']);
    $file_ext = end($file_ext);
    
    if (!in_array($file_ext, $extensions)) {
      $ext_error = true;
    }
    if ($_FILES['fileImage']['error']) {
      echo $phpFileUploadErrors[$_FILES['fileImage']['error']];
    }
    elseif ($ext_error) {
      $check_update = false;
      echo "The file image must be in format jpg, jpeg, gif, png !";
    }
    else {
    }
  }

  if (file_exists($_FILES['fileAudio']['tmp_name']) || is_uploaded_file($_FILES['fileAudio']['tmp_name']))  {
    $error = '';
    $anh = $_FILES['file']['name'];
    $ext_error = false;
    $extensions = array('mp3');
    $file_ext = explode('.',$_FILES['fileAudio']['name']);
    $file_ext = end($file_ext);
    
    if (!in_array($file_ext, $extensions)) {
      $ext_error = true;
    }
    if ($_FILES['fileAudio']['error']) {
      echo $phpFileUploadErrors[$_FILES['fileAudio']['error']];
    }
    elseif ($ext_error) {
      $check_update = false;
      echo "The file audio must be in format mp3 !";
    }
    else {
    }
  }

  if ($check_update == true) {
    $replaceNameSong = vn_to_str($_POST['nameSong']);
    $urlNameSong = strtolower($replaceNameSong);
  
    if ((!file_exists($_FILES['fileImage']['tmp_name']) || !is_uploaded_file($_FILES['fileImage']['tmp_name'])) && (!file_exists($_FILES['fileAudio']['tmp_name']) || !is_uploaded_file($_FILES['fileAudio']['tmp_name'])))  {
      $queryUpdate = 'UPDATE song SET name="' . $_POST['nameSong'] . '", url_name="' . $urlNameSong . '", views="' . $_POST['viewsSong'] . '", dowloads="' . $_POST['dowloadsSong'] . '", 
        artist_id="' . $_POST['idArtist'] . '", account_id="' . $_POST['idAccount'] . '", country_id="' . $_POST['idCountry'] . '"  
        WHERE id=' . $_POST['idSong'];
      $result   = mysqli_query($connection,$queryUpdate)or die("loi cap nhat".mysqli_error($con));
      if($result) {
        echo 'succesful';
      }
    } else if ((file_exists($_FILES['fileImage']['tmp_name']) || is_uploaded_file($_FILES['fileImage']['tmp_name'])) && (!file_exists($_FILES['fileAudio']['tmp_name']) || !is_uploaded_file($_FILES['fileAudio']['tmp_name']))) {
      $queryUpdate = 'UPDATE song SET name="' . $_POST['nameSong'] . '", url_name="' . $urlNameSong . '", image="' . $_FILES['fileImage']['name'] . '", views="' . $_POST['viewsSong'] . '", dowloads="' . $_POST['dowloadsSong'] . '", 
        artist_id="' . $_POST['idArtist'] . '", account_id="' . $_POST['idAccount'] . '", country_id="' . $_POST['idCountry'] . '"  
        WHERE id=' . $_POST['idSong'];
      $result   = mysqli_query($connection,$queryUpdate)or die("loi cap nhat".mysqli_error($con));
      if($result) {
        move_uploaded_file($_FILES['fileImage']['tmp_name'], '../Client-side/images/songs/'.$_FILES['fileImage']['name']);
        echo 'succesful';
      }
    } else if ((!file_exists($_FILES['fileImage']['tmp_name']) || !is_uploaded_file($_FILES['fileImage']['tmp_name'])) && (file_exists($_FILES['fileAudio']['tmp_name']) || is_uploaded_file($_FILES['fileAudio']['tmp_name']))) {
      $queryUpdate = 'UPDATE song SET name="' . $_POST['nameSong'] . '", url_name="' . $urlNameSong . '", audio="' . $_FILES['fileAudio']['name'] . '", views="' . $_POST['viewsSong'] . '", dowloads="' . $_POST['dowloadsSong'] . '", 
        artist_id="' . $_POST['idArtist'] . '", account_id="' . $_POST['idAccount'] . '", country_id="' . $_POST['idCountry'] . '"  
        WHERE id=' . $_POST['idSong'];
      $result   = mysqli_query($connection,$queryUpdate)or die("loi cap nhat".mysqli_error($con));
      if($result) {
        move_uploaded_file($_FILES['fileAudio']['tmp_name'], '../Client-side/audio/'.$_FILES['fileAudio']['name']);
        echo 'succesful';
      }
    } else {
      $queryUpdate = 'UPDATE song SET name="' . $_POST['nameSong'] . '", url_name="' . $urlNameSong . '",image="' . $_FILES['fileImage']['name'] . '" , audio="' . $_FILES['fileAudio']['name'] . '", views="' . $_POST['viewsSong'] . '", dowloads="' . $_POST['dowloadsSong'] . '", 
        artist_id="' . $_POST['idArtist'] . '", account_id="' . $_POST['idAccount'] . '", country_id="' . $_POST['idCountry'] . '"  
        WHERE id=' . $_POST['idSong'];
      $result   = mysqli_query($connection,$queryUpdate)or die("loi cap nhat".mysqli_error($con));
      if($result) {
        move_uploaded_file($_FILES['fileImage']['tmp_name'], '../Client-side/images/songs/'.$_FILES['fileImage']['name']);
        move_uploaded_file($_FILES['fileAudio']['tmp_name'], '../Client-side/audio/'.$_FILES['fileAudio']['name']);
        echo 'succesful';
      }
    }
  }
?>
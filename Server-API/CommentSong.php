<?php
  include("config/connection.php");
  $datetime_currently = date("Y-m-d H:i:s");
  $query_insert_comment = 'INSERT INTO `comment` (`id`, `content`, `date_time`, `account_id`, `song_id`) VALUES (NULL, "' . $_POST["contentComment"] . '", "' . $datetime_currently . '", "' . $_POST["idAccount"] . '", "' . $_POST["idSong"] . '")';
  $result_insert_comment = mysqli_query($connection,$query_insert_comment) or die ("loi".mysqli_error($connection));
  if ($result_insert_comment) {
    echo 'succesfull';
  }
?>
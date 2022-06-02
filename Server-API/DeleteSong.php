<?php
  include("config/connection.php");
  $query_delete_song= 'DELETE FROM song WHERE id = ' . $_POST['idSong'];
  $result_delete_song = mysqli_query($connection,$query_delete_song) or die ("loi".mysqli_error($connection));
  if ($result_delete_song) {
    echo "succesful";
  }
?>
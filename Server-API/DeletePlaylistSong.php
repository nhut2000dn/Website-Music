<?php
  include("config/connection.php");
  $query_delete_playlist= 'DELETE FROM playlists_songs WHERE id = ' . $_POST['idPlaylistSong'];
  $result_delete_playlist = mysqli_query($connection,$query_delete_playlist) or die ("loi".mysqli_error($connection));
  if ($result_delete_playlist) {
    echo "succesful";
  }
?>
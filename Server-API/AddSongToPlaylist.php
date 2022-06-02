<?php
  include("config/connection.php");
  $query_song = 'SELECT * FROM playlists, playlists_songs WHERE playlists.id = playlists_songs.playlists_id AND playlists.id = "' .  $_POST['idPlaylist'] . '" AND playlists_songs.song_id = "' . $_POST['idSong'] . '"';
  $result_song = mysqli_query($connection,$query_song);
  if (mysqli_num_rows($result_song) > 0) {
    echo 'fail';
  } else {
    $query_insert_account = 'INSERT INTO playlists_songs (id, playlists_id, song_id) VALUES (NULL, "' .  $_POST['idPlaylist'] . '", "' . $_POST['idSong'] . '")';
    $result_insert_account = mysqli_query($connection,$query_insert_account) or die ("loi".mysqli_error($connection));
    echo 'succesful';
  }
?>
<?php
  include("config/connection.php");
  $query_search = 'SELECT song.id AS id_song, song.name AS name_song, song.image AS image_song, song.views AS views_song, song.audio AS audio_song, artist.id AS id_artist, artist.name AS name_artist 
    FROM song, artist 
    WHERE song.artist_id = artist.id AND song.name LIKE "%' . $_POST['nameSong'] . '%"';
  $result_search = mysqli_query($connection,$query_search);
  while($row = mysqli_fetch_assoc($result_search)) {
    $resultset_search[] = $row;
  }
  $resp['array_search'] = $resultset_search;
  echo json_encode($resp);
?>
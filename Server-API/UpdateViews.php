<?php
  include("config/connection.php");

  //Upload view song
  if ($_POST['select'] == 'songUpdateViews') {
    $query_song = 'SELECT views FROM song WHERE song.id="' . $_POST['idSong'] . '"';
    $result_song = mysqli_query($connection,$query_song);
    $row_song = mysqli_fetch_array($result_song,MYSQLI_ASSOC);
    $query_update_views = 'UPDATE song SET views = "' . ($row_song['views'] + 1) . '" WHERE id="' . $_POST['idSong'] . '"';
    $result_update_views = mysqli_query($connection,$query_update_views);
  }

  //Upload view playlist
  if ($_POST['select'] == 'playlistUpdateViews') {
    $query_playlist = 'SELECT views FROM playlists WHERE playlists.id="' . $_POST['idPlaylist'] . '"';
    $result_playlist = mysqli_query($connection,$query_playlist);
    $row_playlist = mysqli_fetch_array($result_playlist,MYSQLI_ASSOC);
    $query_update_views = 'UPDATE playlists SET views = "' . ($row_playlist['views'] + 1) . '" WHERE id="' . $_POST['idPlaylist'] . '"';
    $result_update_views = mysqli_query($connection,$query_update_views);
  }
?>
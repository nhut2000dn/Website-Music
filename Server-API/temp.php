<?php
  include("config/connection.php");

  //select theme, country for menu
  if ($_POST['select'] == 'menu') {
    $query_theme = 'SELECT * FROM theme';
    $result_theme = mysqli_query($connection,$query_theme);
    while($row = mysqli_fetch_assoc($result_theme)) {
      $resultset_theme[] = $row;
    }
    $resp['array-theme'] = $resultset_theme;
    $query_country = 'SELECT * FROM country';
    $result_country = mysqli_query($connection,$query_country);
    while($row = mysqli_fetch_assoc($result_country)) {
      $resultset_country[] = $row;
    }
    $resp['array-country'] = $resultset_country;
  }

  // select new song limit 6
  if ($_POST['select'] == 'newSong') {
    $query_new_song = 'SELECT song.id AS id_song, song.name AS name_song, song.url_name AS url_name_song, song.image AS image_song, artist.id AS id_artist, 
      artist.name AS name_artist, artist.url_name AS url_name_artist FROM song, artist WHERE song.artist_id = artist.id ORDER BY song.id DESC LIMIT 6';
    $result_new_song = mysqli_query($connection,$query_new_song);
    while($row = mysqli_fetch_assoc($result_new_song)) {
      $resultset_new_song[] = $row;
    }
    $resp['array-new_song'] = $resultset_new_song;
  }

  //select playlist limit 6
  if ($_POST['select'] == 'playlist') {
    $query_playlist = 'SELECT  playlists.id AS id_playlists ,playlists.name AS name_playlists, playlists.url_name AS url_name_playlists, playlists.image AS 
      image_playlists, account.id AS id_account, account.full_name AS full_name_account, account.username AS username_account FROM playlists, account 
      WHERE playlists.account_id = account.id LIMIT 6';
    $result_playlist = mysqli_query($connection,$query_playlist);
    while($row = mysqli_fetch_assoc($result_playlist)) {
      $resultset_playlist[] = $row;
    }
    $resp['array-playlist'] = $resultset_playlist;
  }

  // select top tracks limit 5
  if ($_POST['select'] == 'topTracks') {
    $query_top_tracks = 'SELECT song.id AS id_song, song.name AS name_song, song.url_name AS url_name_song, song.image AS image_song, song.views AS views_song, song.dowloads 
      AS dowloads_song, artist.id AS id_artist, artist.name AS name_artist, artist.url_name AS url_name_artist 
      FROM song, artist WHERE song.artist_id = artist.id ORDER BY song.views DESC LIMIT 6';
    $result_top_tracks = mysqli_query($connection,$query_top_tracks);
    while($row = mysqli_fetch_assoc($result_top_tracks)) {
      $resultset_top_tracks[] = $row;
    }
    $resp['array-top_tracks'] = $resultset_top_tracks;
  }

  // select country
  if ($_POST['select'] == 'country') {
    $query_top_100 = 'SELECT * FROM country';
    $result_top_100 = mysqli_query($connection,$query_top_100);
    while($row = mysqli_fetch_assoc($result_top_100)) {
      $resultset_top_100[] = $row;
    }
    $resp['array-top_100'] = $resultset_top_100;
    echo json_encode($resp);
  }
?>
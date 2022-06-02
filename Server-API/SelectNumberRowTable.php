<?php
  include("config/connection.php");
  $query_number_account = 'SELECT * FROM account';
  $result_number_account = mysqli_query($connection,$query_number_account) or die ("loi".mysqli_error($connection));
  $num_number_account = mysqli_num_rows($result_number_account);
  $resp['numberAccount'] = $num_number_account;

  $query_number_song = 'SELECT * FROM song';
  $result_number_song = mysqli_query($connection,$query_number_song) or die ("loi".mysqli_error($connection));
  $num_number_song = mysqli_num_rows($result_number_song);
  $resp['numberSong'] = $num_number_song;

  $query_number_artist = 'SELECT * FROM artist';
  $result_number_artist = mysqli_query($connection,$query_number_artist) or die ("loi".mysqli_error($connection));
  $num_number_artist = mysqli_num_rows($result_number_artist);
  $resp['numberArtist'] = $num_number_artist;

  $query_number_country = 'SELECT * FROM country';
  $result_number_country = mysqli_query($connection,$query_number_country) or die ("loi".mysqli_error($connection));
  $num_number_country = mysqli_num_rows($result_number_country);
  $resp['numberCountry'] = $num_number_country;

  $query_number_playlist = 'SELECT * FROM playlists';
  $result_number_playlist = mysqli_query($connection,$query_number_playlist) or die ("loi".mysqli_error($connection));
  $num_number_playlist = mysqli_num_rows($result_number_playlist);
  $resp['numberPlaylists'] = $num_number_playlist;

  $query_number_user_types = 'SELECT * FROM user_types';
  $result_number_user_types = mysqli_query($connection,$query_number_user_types) or die ("loi".mysqli_error($connection));
  $num_number_user_types = mysqli_num_rows($result_number_user_types);
  $resp['numberUserTypes'] = $num_number_user_types;

  $query_number_comment = 'SELECT * FROM comment';
  $result_number_comment = mysqli_query($connection,$query_number_comment) or die ("loi".mysqli_error($connection));
  $num_number_comment = mysqli_num_rows($result_number_comment);
  $resp['numberComment'] = $num_number_comment;

  echo json_encode($resp);
?>
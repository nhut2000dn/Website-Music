<?php
  include("config/connection.php");

  //select theme, country, account for menu
  if ($_POST['select'] == 'menu') {
    $query_country = 'SELECT * FROM country';
    $result_country = mysqli_query($connection,$query_country);
    while($row = mysqli_fetch_assoc($result_country)) {
      $resultset_country[] = $row;
    }
    $resp['array-country'] = $resultset_country;
    $query_account = 'SELECT * FROM account WHERE id="' . $_POST['idAccount'].'"';
    $result_account = mysqli_query($connection,$query_account);
    $number_account = mysqli_num_rows($result_account);
    $row_account = mysqli_fetch_array($result_account,MYSQLI_ASSOC);
    $resp['id'] = $row_account["id_account"];
    $resp['full_name'] = $row_account["full_name"];
    $resp['username'] = $row_account["username"];
    $resp['email'] = $row_account["email"];
    $resp['image'] = $row_account["image"];
    $resp['active_status'] = $row_account["active_status"];
    $resp['user_types_id'] = $row_account["user_types_id"];
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
  }

  // select artist
  if ($_POST['select'] == 'artist') {
    $query_artist = 'SELECT * FROM artist';
    $result_artist = mysqli_query($connection,$query_artist);
    while($row = mysqli_fetch_assoc($result_artist)) {
      $resultset_artist[] = $row;
    }
    $resp['array-artist'] = $resultset_artist;
  }

  // select theme
  if ($_POST['select'] == 'theme') {
    $query_theme = 'SELECT * FROM theme';
    $result_theme = mysqli_query($connection,$query_theme);
    while($row = mysqli_fetch_assoc($result_theme)) {
      $resultset_theme[] = $row;
    }
    $resp['array-theme'] = $resultset_theme;
  }

  // select box play
  if ($_POST['select'] == 'playSong') {
    
    //query song
    $query_song = 'SELECT account.id AS id_account, account.username AS username_account, account.image AS image_account, song.id AS id_song, song.name AS name_song, song.url_name AS url_name_Song, 
      song.image AS image_song, song.audio AS audio_song, song.views AS views_song, song.dowloads AS dowloads_song, artist.id AS id_artist, artist.name AS name_artist, 
      artist.url_name AS url_name_artist, artist.image AS image_artist FROM account, song, artist 
      WHERE account.id = song.account_id AND song.artist_id = artist.id AND song.id = ' . $_POST['idSong'];
    $result_song = mysqli_query($connection,$query_song);
    $number_song = mysqli_num_rows($result_song);
    $row_song = mysqli_fetch_array($result_song,MYSQLI_ASSOC);
    $resp['id_account_song'] = $row_song["id_account"];
    $resp['username_account_song'] = $row_song["username_account"];
    $resp['image_account_song'] = $row_song["image_account"];
    $resp['id_song'] = $row_song["id_song"];
    $resp['name_song'] = $row_song["name_song"];
    $resp['url_name_Song'] = $row_song["url_name_Song"];
    $resp['image_song'] = $row_song["image_song"];
    $resp['audio_song'] = $row_song["audio_song"];
    $resp['views_song'] = $row_song["views_song"];
    $resp['dowloads_song'] = $row_song["dowloads_song"];
    $resp['id_artist'] = $row_song["id_artist"];
    $resp['name_artist'] = $row_song["name_artist"];
    $resp['url_name_artist'] = $row_song["url_name_artist"];
    $resp['image_artist'] = $row_song["image_artist"];

    //query lyrics song
    $query_lyrics = 'SELECT account.id AS id_account, account.username AS username_account, lyrics.content AS content_lyrics FROM account, lyrics 
      WHERE account.id = lyrics.account_id AND lyrics.song_id = ' . $_POST['idSong'];
    $result_lyrics = mysqli_query($connection,$query_lyrics);
    $number_lyrics = mysqli_num_rows($result_lyrics);
    $row_lyrics = mysqli_fetch_array($result_lyrics,MYSQLI_ASSOC);
    if (mysqli_num_rows($result_lyrics) > 0) {
      $resp['status_lyrics'] = true;
      $resp['id_account_lyrics'] = $row_lyrics["id_account"];
      $resp['username_account_lyrics'] = $row_lyrics["username_account"];
      $resp['content_lyrics'] = $row_lyrics["content_lyrics"];
    } else {
      $resp['status_lyrics'] = false;
    }
  }

  // select listen next
  if ($_POST['select'] == 'listenNext') {
    $query_song_listen_next = 'SELECT song.id AS id_song, song.name AS name_song, song.url_name AS url_name_song, song.image AS image_song, artist.id AS id_artist, 
      artist.name AS name_artist, artist.url_name AS url_name_artist FROM song, artist WHERE song.artist_id = artist.id AND song.id != ' . $_POST['idSong'] . ' ORDER BY song.id LIMIT 11';
    $result_song_listen_next = mysqli_query($connection,$query_song_listen_next);
    while($row = mysqli_fetch_assoc($result_song_listen_next)) {
      $resultset_song_listen_next[] = $row;
    }
    $resp['array_song_listen_next'] = $resultset_song_listen_next;
  }

  //select playlist limit 4
  if ($_POST['select'] == 'playlistPlaySong') {
    $query_playlist = 'SELECT  playlists.id AS id_playlists ,playlists.name AS name_playlists, playlists.url_name AS url_name_playlists, playlists.image AS 
      image_playlists, account.id AS id_account, account.full_name AS full_name_account, account.username AS username_account FROM playlists, account 
      WHERE playlists.account_id = account.id LIMIT 4';
    $result_playlist = mysqli_query($connection,$query_playlist);
    while($row = mysqli_fetch_assoc($result_playlist)) {
      $resultset_playlist[] = $row;
    }
    $resp['array-playlist'] = $resultset_playlist;
  }

  // select comment
  if ($_POST['select'] == 'comment') {
    $query_comment = 'SELECT account.id AS id_account, account.username AS username_account, account.image AS image_account, comment.content AS content_comment, 
      comment.date_time AS date_time_comment  FROM account, comment, song 
      WHERE song.id = comment.song_id AND account.id = comment.account_id AND song.id="'.$_POST['idSong']. '" ORDER BY comment.date_time DESC';
    $result_comment = mysqli_query($connection,$query_comment);
    while($row = mysqli_fetch_assoc($result_comment)) {
      $resultset_comment[] = $row;
    }
    $resp['array_comment'] = $resultset_comment;
  }

  //select information account
  if ($_POST['select'] == 'account') {
    $query_account = 'SELECT * FROM account WHERE id="' . $_POST['idAccount'].'"';
    $result_account = mysqli_query($connection,$query_account);
    $number_account = mysqli_num_rows($result_account);
    $row_account = mysqli_fetch_array($result_account,MYSQLI_ASSOC);
    $resp['id'] = $row_account["id_account"];
    $resp['full_name'] = $row_account["full_name"];
    $resp['username'] = $row_account["username"];
    $resp['email'] = $row_account["email"];
    $resp['image'] = $row_account["image"];
    $resp['active_status'] = $row_account["active_status"];
    $resp['user_types_id'] = $row_account["user_types_id"];
  }

  // select box playlist
  if ($_POST['select'] == 'boxPlaylist') {
    $query_playlists = 'SELECT account.id AS id_account, account.username AS username_account, account.image AS image_account, playlists.id AS id_playlist, 
    playlists.name AS name_playlists, playlists.image AS image_playlists, playlists.views AS views_playlists FROM playlists, account 
    WHERE account.id = playlists.account_id AND playlists.id =' . $_POST['idPlaylist'];
    $result_playlists = mysqli_query($connection,$query_playlists);
    $number_playlists = mysqli_num_rows($result_playlists);
    $row_playlists = mysqli_fetch_array($result_playlists,MYSQLI_ASSOC);
    $resp['id_account_playlists'] = $row_playlists["id_account"];
    $resp['username_account_playlists'] = $row_playlists["username_account"];
    $resp['image_account_playlists'] = $row_playlists["image_account"];
    $resp['id_playlists'] = $row_playlists["id_playlists"];
    $resp['name_playlists'] = $row_playlists["name_playlists"];
    $resp['image_playlists'] = $row_playlists["image_playlists"];
    $resp['views_playlists'] = $row_playlists["views_playlists"];
  }

  // select playlist play song
  if ($_POST['select'] == 'playlistSong') {
    $query_playlist_songs = 'SELECT playlists_songs.id AS id_playlists_song, song.id AS id_song, song.name AS name_song, song.url_name AS url_name_song, 
      song.image AS image_song, song.audio AS audio_song ,song.views AS views_song, artist.id AS id_artist, artist.name AS name_artist, artist.url_name AS url_name_artist 
      FROM playlists_songs, song, artist 
      WHERE song.artist_id = artist.id AND playlists_songs.song_id = song.id AND playlists_songs.playlists_id = ' . $_POST['idPlaylist'];
    $result_playlist_songs = mysqli_query($connection,$query_playlist_songs);
    while($row = mysqli_fetch_assoc($result_playlist_songs)) {
      $resultset_playlist_songs[] = $row;
    }
    $resp['array-playlist-songs'] = $resultset_playlist_songs;
  }

  // select playlist song lyrics
  if ($_POST['select'] == 'playlistSongLyrics') {
    //query lyrics song
    $query_lyrics = 'SELECT account.id AS id_account, account.username AS username_account, lyrics.content AS content_lyrics FROM account, lyrics 
      WHERE account.id = lyrics.account_id AND lyrics.song_id = ' . $_POST['idSong'];
    $result_lyrics = mysqli_query($connection,$query_lyrics);
    $number_lyrics = mysqli_num_rows($result_lyrics);
    $row_lyrics = mysqli_fetch_array($result_lyrics,MYSQLI_ASSOC);
    if (mysqli_num_rows($result_lyrics) > 0) {
      $resp['status_lyrics'] = true;
      $resp['id_account_lyrics'] = $row_lyrics["id_account"];
      $resp['username_account_lyrics'] = $row_lyrics["username_account"];
      $resp['content_lyrics'] = $row_lyrics["content_lyrics"];
    } else {
      $resp['status_lyrics'] = false;
    }
  }

  // select song of top100
  if ($_POST['select'] == 'songTop100') {
    $query_top100 = 'SELECT country.id AS id_country, country.name AS name_country, song.id AS id_song, song.name AS name_song, song.url_name AS url_name_song, 
      song.image AS image_song, song.audio AS audio_song ,song.views AS views_song, artist.id AS id_artist, artist.name AS name_artist, artist.url_name AS url_name_artist 
      FROM country, song, artist 
      WHERE song.artist_id = artist.id AND country.id = song.country_id AND country.id = ' . $_POST['idCountry'] . ' ORDER BY song.views DESC';
    $result_top100 = mysqli_query($connection,$query_top100);
    while($row = mysqli_fetch_assoc($result_top100)) {
      $resultset_top100[] = $row;
    }
    $result2_top100 = mysqli_query($connection,$query_top100);
    $row_top100 = mysqli_fetch_array($result2_top100,MYSQLI_ASSOC);
    $resp['idCountry'] = $row_top100["id_country"];
    $resp['nameCountry'] = $row_top100["name_country"];
    $resp['arrayTop100Song'] = $resultset_top100;
  }

  // select box top100
  if ($_POST['select'] == 'boxTop100') {
    $query_top100 = 'SELECT * FROM country WHERE id = ' . $_POST['idCountry'];
    $result_top100 = mysqli_query($connection,$query_top100);
    $number_top100 = mysqli_num_rows($result_top100);
    $row_top100 = mysqli_fetch_array($result_top100,MYSQLI_ASSOC);
    $resp['id_top100'] = $row_top100["id"];
    $resp['name_top100'] = $row_top100["name"];
    $resp['image_top100'] = $row_top100["image"];
  }

  // select song of theme
  if ($_POST['select'] == 'songTheme') {
    $query_theme = 'SELECT theme.id AS id_theme, theme.name AS name_theme, song.id AS id_song, song.name AS name_song, song.url_name AS url_name_song, 
      song.image AS image_song, song.audio AS audio_song ,song.views AS views_song, artist.id AS id_artist, artist.name AS name_artist, artist.url_name AS url_name_artist 
      FROM theme, song, artist 
      WHERE song.artist_id = artist.id AND Theme.id = song.theme_id AND Theme.id = ' . $_POST['idTheme'] . '';
    $result_theme = mysqli_query($connection,$query_theme);
    while($row = mysqli_fetch_assoc($result_theme)) {
      $resultset_theme[] = $row;
    }
    $result2_theme = mysqli_query($connection,$query_theme);
    $row_theme = mysqli_fetch_array($result2_theme,MYSQLI_ASSOC);
    $resp['idTheme'] = $row_theme["id_Theme"];
    $resp['nameTheme'] = $row_theme["name_Theme"];
    $resp['arrayThemeSong'] = $resultset_theme;
  }

  // select box theme
  if ($_POST['select'] == 'boxTheme') {
    $query_Theme = 'SELECT * FROM theme WHERE id = ' . $_POST['idTheme'];
    $result_Theme = mysqli_query($connection,$query_Theme);
    $number_Theme = mysqli_num_rows($result_Theme);
    $row_Theme = mysqli_fetch_array($result_Theme,MYSQLI_ASSOC);
    $resp['id_Theme'] = $row_Theme["id"];
    $resp['name_Theme'] = $row_Theme["name"];
    $resp['image_Theme'] = $row_Theme["image"];
  }

  // select playlist song lyrics
  if ($_POST['select'] == 'top100SongLyrics') {
    //query lyrics song
    $query_lyrics = 'SELECT account.id AS id_account, account.username AS username_account, lyrics.content AS content_lyrics FROM account, lyrics 
      WHERE account.id = lyrics.account_id AND lyrics.song_id = ' . $_POST['idSong'];
    $result_lyrics = mysqli_query($connection,$query_lyrics);
    $number_lyrics = mysqli_num_rows($result_lyrics);
    $row_lyrics = mysqli_fetch_array($result_lyrics,MYSQLI_ASSOC);
    if (mysqli_num_rows($result_lyrics) > 0) {
      $resp['status_lyrics'] = true;
      $resp['id_account_lyrics'] = $row_lyrics["id_account"];
      $resp['username_account_lyrics'] = $row_lyrics["username_account"];
      $resp['content_lyrics'] = $row_lyrics["content_lyrics"];
    } else {
      $resp['status_lyrics'] = false;
    }
  }

  // select playlists for user function 
  if ($_POST['select'] == 'userPlaylists') {
    $query_user_playlists = 'SELECT * FROM playlists WHERE account_id = ' . $_POST['idAccount'];
    $result_user_playlists = mysqli_query($connection,$query_user_playlists);
    while($row = mysqli_fetch_assoc($result_user_playlists)) {
      $resultset_user_playlists[] = $row;
    }
    $resp['array_user_playlists'] = $resultset_user_playlists;
  }

  // select playlists for user function edit
  if ($_POST['select'] == 'selectEditPlaylist') {
    $query_select_playlist = 'SELECT * FROM playlists WHERE id = ' . $_POST['idPlaylistEdit'];
    $result_select_playlist = mysqli_query($connection,$query_select_playlist);
    $row_select_playlist = mysqli_fetch_array($result_select_playlist,MYSQLI_ASSOC);
    if (mysqli_num_rows($result_select_playlist) > 0) {
      $resp['idPlaylist'] = $row_select_playlist["id"];
      $resp['namePlaylist'] = $row_select_playlist["name"];
      $resp['imagePlaylist'] = $row_select_playlist["image"];
    } else {
      $resp['status'] = false;
    }
  }

  //select information profile account 
  if ($_POST['select'] == 'profileAccount') {
    $query_account = 'SELECT * FROM account WHERE id="' . $_POST['idAccount'].'"';
    $result_account = mysqli_query($connection,$query_account);
    $number_account = mysqli_num_rows($result_account);
    $row_account = mysqli_fetch_array($result_account,MYSQLI_ASSOC);
    $resp['id'] = $row_account["id_account"];
    $resp['fullName'] = $row_account["full_name"];
    $resp['username'] = $row_account["username"];
    $resp['email'] = $row_account["email"];
    $resp['image'] = $row_account["image"];
    $resp['active_status'] = $row_account["active_status"];
    $resp['user_types_id'] = $row_account["user_types_id"];
  }

  //select all playlist
  if ($_POST['select'] == 'Playlists') {
    $query_playlists = 'SELECT * FROM playlists';
    $result_playlists = mysqli_query($connection,$query_playlists);
    while($row = mysqli_fetch_assoc($result_playlists)) {
      $resultset_playlists[] = $row;
    }
    $resp['array_playlists'] = $resultset_playlists;
  }

  //select song of artist
  if ($_POST['select'] == 'ArtistSongs') {
    $query_artist_songs = 'SELECT song.id AS id_song, song.name AS name_song, song.image AS image_song, song.views AS views_song, artist.id AS id_artist, artist.name AS name_artist, artist.image AS image_artist, artist.description AS description_artist 
      FROM artist, song 
      WHERE song.artist_id = artist.id AND artist.id =' . $_POST['idArtist'];
    $result_artist_songs = mysqli_query($connection,$query_artist_songs);
    while($row = mysqli_fetch_assoc($result_artist_songs)) {
      $resultset_artist_songs[] = $row;
    }
    $resp['array_artist_songs'] = $resultset_artist_songs;
  }

  // select artist
  if ($_POST['select'] == 'ArtistsElse') {
    $query_artists = 'SELECT * FROM artist WHERE NOT id = ' . $_POST['idArtist'] . ' ORDER BY RAND() LIMIT 10';
    $result_artists = mysqli_query($connection,$query_artists);
    while($row = mysqli_fetch_assoc($result_artists)) {
      $resultset_artists[] = $row;
    }
    $resp['array_artists'] = $resultset_artists;
  }

  // select all songs
  if ($_POST['select'] == 'allSong') {
    $query_songs = 'SELECT * FROM song';
    $result_songs = mysqli_query($connection,$query_songs);
    while($row = mysqli_fetch_assoc($result_songs)) {
      $resultset_songs[] = $row;
    }
    $resp['array_songs'] = $resultset_songs;
  }

  // select view songs
  if ($_POST['select'] == 'DetailSong') {
    $query_detail_song = 'SELECT song.id AS id_song, song.name AS name_song, song.url_name AS url_name_song, song.image AS image_song, song.audio AS audio_song, song.views AS views_song, song.dowloads AS dowloads_song, 
      artist.id AS id_artist, artist.name AS name_artist, country.id AS id_country, country.name AS name_country, account.id AS id_account, account.username AS username_account 
      FROM song, artist, country, account 
      WHERE artist.id = song.artist_id AND account.id = song.account_id AND song.country_id = country.id AND song.id = ' . $_POST["idSong"];
    $result_detail_song = mysqli_query($connection,$query_detail_song);
    $number_detail_song = mysqli_num_rows($result_detail_song);
    $row_detail_song = mysqli_fetch_array($result_detail_song,MYSQLI_ASSOC);
    $resp['idSong'] = $row_detail_song["id_song"];
    $resp['nameSong'] = $row_detail_song["name_song"];
    $resp['urlNameSong'] = $row_detail_song["url_name_song"];
    $resp['imageSong'] = $row_detail_song["image_song"];
    $resp['audioSong'] = $row_detail_song["audio_song"];
    $resp['viewsSong'] = $row_detail_song["views_song"];
    $resp['dowloadsSong'] = $row_detail_song["dowloads_song"];
    $resp['idArtist'] = $row_detail_song["id_artist"];
    $resp['nameArtist'] = $row_detail_song["name_artist"];
    $resp['idCountry'] = $row_detail_song["id_country"];
    $resp['nameCountry'] = $row_detail_song["name_country"];
    $resp['idAccount'] = $row_detail_song["id_account"];
    $resp['usernameAccount'] = $row_detail_song["username_account"];
  }
  
  // select all information songs
  if ($_POST['select'] == 'formSong') {
    $query_accounts = 'SELECT account.id, account.username FROM account';
    $result_accounts = mysqli_query($connection,$query_accounts);
    while($row = mysqli_fetch_assoc($result_accounts)) {
      $resultset_accounts[] = $row;
    }
    $resp['array_accounts'] = $resultset_accounts;

    $query_artists = 'SELECT artist.id, artist.name FROM artist';
    $result_artists = mysqli_query($connection,$query_artists);
    while($row = mysqli_fetch_assoc($result_artists)) {
      $resultset_artists[] = $row;
    }
    $resp['array_artists'] = $resultset_artists;

    $query_countrys = 'SELECT country.id, country.name FROM country';
    $result_countrys = mysqli_query($connection,$query_countrys);
    while($row = mysqli_fetch_assoc($result_countrys)) {
      $resultset_countrys[] = $row;
    }
    $resp['array_countrys'] = $resultset_countrys;
  }

  // select all information account
  if ($_POST['select'] == 'tableAccount') {
    $query_accounts = 'SELECT account.id AS id_account, account.full_name AS full_name_account, account.username AS username_account, account.email AS email_account, 
      account.image AS image_account, user_types.id AS id_user_types, user_types.user_position 
      FROM account, user_types 
      WHERE account.user_types_id = user_types.id';
    $result_accounts = mysqli_query($connection,$query_accounts);
    while($row = mysqli_fetch_assoc($result_accounts)) {
      $resultset_accounts[] = $row;
    }
    $resp['array_accounts'] = $resultset_accounts;
  }

  // select all information account
  if ($_POST['select'] == 'formUserType') {
    $query_user_types = 'SELECT * FROM user_types';
    $result_user_types = mysqli_query($connection,$query_user_types);
    while($row = mysqli_fetch_assoc($result_user_types)) {
      $resultset_user_types[] = $row;
    }
    $resp['array_user_types'] = $resultset_user_types;
  }

  // select all information account
  if ($_POST['select'] == 'FormEditAccount') {
    $query_account = 'SELECT account.id AS id_account, account.full_name AS full_name_account, account.username AS username_account, account.email AS email_account, 
      account.image AS image_account, user_types.id AS id_user_types, user_types.user_position 
      FROM account, user_types 
      WHERE account.user_types_id = user_types.id AND account.id = ' . $_POST['idAccount'];
    $result_account = mysqli_query($connection,$query_account);
    $number_account = mysqli_num_rows($result_account);
    $row_account = mysqli_fetch_array($result_account,MYSQLI_ASSOC);
    $resp['id'] = $row_account["id_account"];
    $resp['fullName'] = $row_account["full_name_account"];
    $resp['username'] = $row_account["username_account"];
    $resp['email'] = $row_account["email_account"];
    $resp['image'] = $row_account["image_account"];
    $resp['idUserTypes'] = $row_account["id_user_types"];
    $resp['userPosition'] = $row_account["user_position"];
  }

  // select all information country
  if ($_POST['select'] == 'tableCountry') {
    $query_country = 'SELECT * FROM country';
    $result_country = mysqli_query($connection,$query_country);
    while($row = mysqli_fetch_assoc($result_country)) {
      $resultset_country[] = $row;
    }
    $resp['array_country'] = $resultset_country;
  }

  // select form edit country
  if ($_POST['select'] == 'FormEditCountry') {
    $query_country = 'SELECT * FROM country WHERE id = ' . $_POST['idCountry'];
    $result_country = mysqli_query($connection,$query_country);
    $number_country = mysqli_num_rows($result_country);
    $row_country = mysqli_fetch_array($result_country,MYSQLI_ASSOC);
    $resp['id'] = $row_country["id"];
    $resp['name'] = $row_country["name"];
    $resp['image'] = $row_country["image"];
  }

  // //select playlist number song
  // $query_playlist = 'SELECT playlists.id AS playlist_id, name, url_name FROM playlists';
  // $result_playlist = mysqli_query($connection,$query_playlist) or die ("loi".mysqli_error($connection));
  // while($row_playlist=mysqli_fetch_array($result_playlist,MYSQLI_ASSOC)) {
  //   $count_playlist = 0;
  //   $query_playlist_song = 'SELECT * FROM playlists_songs';
  //   $result_playlist_song = mysqli_query($connection,$query_playlist_song) or die ("loi".mysqli_error($connection));
  //   $count_playlist_song = mysqli_num_rows($result_playlist_song);
  //   while($row_playlist_song=mysqli_fetch_array($result_playlist_song,MYSQLI_ASSOC)) {
  //     $name_playlist = $row_playlist["name"];
  //     if ($row_playlist["playlist_id"]==$row_playlist_song["playlists_id"]) {
  //       $count_playlist++;
  //     }
  //   }
  //   echo $name_playlist . $count_playlist . '------------------</br>';
  // }
  echo json_encode($resp);
?>
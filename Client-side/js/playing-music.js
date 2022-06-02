$(document).ready(function () {
  // check idSong in URL
  var image_account = '';
  var check_lyrics = false;
  var pathname = $(location).attr("href");
  var url = new URL(pathname);

  //check idSong
  idSong = url.searchParams.get("idSong");
  if (!idSong) {
    window.location.href = "index.html";
  }

  // load image account
  if (localStorage.getItem("idAccount") != null) {
    $.ajax({
      url:'../Server-API/load-data-page.php',
      type:'post',
      data: {
        select: 'account',
        idAccount: localStorage.getItem("idAccount")
      },
      success:function(response) {
        var response = JSON.parse(response);
        if(!response['image']) {
          $('.container-img-account').html('<img src="images/account/no-avatar.jpg" alt="" class="img-account">');
        } else {
          $('.container-img-account').html('<img src="images/account/'+response['image']+'" alt="" class="img-account">');
        }
      }
    });
  }

  //update views
  $.ajax({
    url:'../Server-API/UpdateViews.php',
    type:'post',
    data: {
      idSong: idSong,
      select: 'songUpdateViews'
    }
  });

  //load html header footer
  $.ajax({
    url:'../Server-API/load-data-page.php',
    type:'post',
    data: {
      select: 'menu',
      idAccount: localStorage.getItem("idAccount")
    },
    success:function(response) {
      var response = JSON.parse(response);
      var dataItemCountry = '';
      var htmlBoxUser = '';
      var htmlDropDownUser = '';
      for (var k in response['array-country']) {
        dataItemCountry += '<a href="top100-music.html?idCountry=' + response['array-country'][k]['id'] + '"> ' + response['array-country'][k]['name'] + ' </a>';
      }
      if(!response['image']) {
        image_account = 'no-avatar.jpg';
      } else {
        image_account = response['image'];
      }
      if (localStorage.getItem("idAccount") != null) {
        htmlBoxUser = '<img src="images/account/'+image_account+'" alt="Zing MP3" class="icon-user">';
        htmlDropDownUser = '\
          <a href="user-function.html?type=playlist"><li class="item-drop-down-user">Personal page</li></a>\
          <a href="user-function.html?type=profile"><li class="item-drop-down-user">Profile</li></a>\
          <a class="js-btn-logout"><li class="item-drop-down-user">Logout</li></a>\
        ';
      } else {
        htmlBoxUser = '<i class="far fa-user"></i>';
        htmlDropDownUser = '\
          <a href="auth.html#login"><li class="item-drop-down-user">Login</li></a>\
          <a href="auth.html#register"><li class="item-drop-down-user">Register</li></a>\
        ';
      }
      $('header').html('\
        <div class="container-header">\
          <nav class="navbar-collapse">\
            <div class="navbar-left">\
              <a href="index.html"><img src="images/LOGO.png" alt="" class="logo"></a>\
            </div>\
            <div class="navbar-center">\
              <a href="index.html" class="item-menu">Home</a>\
              <a href="artist.html" class="item-menu">Artist</a>\
              <div class="navbar-container">\
                <div class="dropdown-item-header">\
                  <button class="dropbtn">Top 100\
                  </button>\
                  <div class="dropdown-content">\
                    <div class="row-content">\
                      <div class="column-dropdown">\
                      ' + dataItemCountry + '\
                      </div>\
                    </div>\
                  </div>\
                </div>\
              </div>\
              <a href="playlist.html" class="item-menu">PlayList</a>\
              <form class="input-search">\
                <span class="input-search-prepend">\
                  <button type="button" class="button-seach">\
                    <svg class="feather feather-search" width="16" height="16" viewBox="0 0 24 24" fill="none"\
                      stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">\
                      <circle cx="11" cy="11" r="8"></circle>\
                      <line x1="21" y1="21" x2="16.65" y2="16.65"></line>\
                    </svg>\
                  </button>\
                </span>\
                <span class="twitter-typeahead">\
                  <input type="text" class="form-input-search" placeholder="Search..." autocomplete="off"\
                    spellcheck="false" dir="auto">\
                </span>\
              </form>\
            </div>\
            <div class="navbar-right">\
              <div class="container-user">\
                <div class="box-user">\
                  ' + htmlBoxUser + '\
                </div>\
                <div class="drop-down-user">\
                  <ul class="box-drop-down-user">\
                  ' + htmlDropDownUser + '\
                  </ul>\
                </div>\
              </div>\
              <div class="btn-action">\
                <i class="fas fa-bars"></i>\
              </div>\
            </div>\
          </nav>\
          <div class="box-action">\
            <a href="index.html">\
              <div class="dropdown-item-header">\
                <button class="dropbtn">Home\
                </button>\
              </div>\
            </a>\
            <a href="artist.html">\
            <div class="dropdown-item-header">\
              <button class="dropbtn">Artist\
              </button>\
            </div>\
            </a>\
            <div class="navbar-header">\
              <div class="dropdown-item-header">\
                <button class="dropbtn">Top 100\
                </button>\
                <div class="dropdown-content">\
                  <div class="row-content">\
                    <div class="column-dropdown">\
                      ' + dataItemCountry + '\
                    </div>\
                  </div>\
                </div>\
              </div>\
              <a href="playlist.html">\
                <div class="dropdown-item-header">\
                  <button class="dropbtn">PlayList\
                  </button>\
                </div>\
              </a>\
              <a href="playlist.html">\
                <div class="dropdown-item-header">\
                  <button class="dropbtn">PlayList\
                  </button>\
                </div>\
              </a>\
            </div>\
            <form class="input-search">\
              <span class="input-search-prepend">\
                <button type="button" class="button-seach">\
                  <svg class="feather feather-search" width="16" height="16" viewBox="0 0 24 24" fill="none"\
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">\
                    <circle cx="11" cy="11" r="8"></circle>\
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>\
                  </svg>\
                </button>\
              </span>\
              <span class="twitter-typeahead">\
                <input type="text" class="form-input-search" placeholder="Search..." autocomplete="off"\
                  spellcheck="false" dir="auto">\
              </span>\
            </form>\
          </div>\
        </div>\
      ');
    }
  });

  //load information 
  $.ajax({
    url:'../Server-API/load-data-page.php',
    type:'post',
    data: {
      select: 'playSong',
      idSong: idSong
    },
    success:function(response) {
      var response = JSON.parse(response);
      if(!response['image_account_song']) {
        image_account = 'no-avatar.jpg';
      } else {
        image_account = response['image_account_song'];
      }
      if (response['status_lyrics'] == true) {
        var str_lyrics = response['content_lyrics'];
        var result_lyrics = str_lyrics.replace(/_/g, '<br>');
        var postBy = '<p>Posted by: ' + response['username_account_lyrics'] + '</p>';
        var btnSeeLyrics = '\
          <br>\
          <br>\
          <a id="seeMoreLyric" class="btn_view_more">Show all Lyrics<span class="down"></span></a>\
          <a id="hideMoreLyric" class="btn_view_hide hide">Hiden Lyrics<span class="up"></span></a>\
        ';
      } else {
        result_lyrics = "</br>Don't have lyrics now";
        check_lyrics = true;
      }
      $('.title-play-music').html('\
        <span class="title-left">' + response['name_song'] + ' - ' + response['name_artist'] + '</span>\
        <span class="title-right"><i class="fas fa-headphones-alt"></i> ' + response['views_song'] + '</span>\
      ');
      $('.box-img-music').html('\
        <img src="images/songs/' + response['image_song'] + '" alt="">\
      ');
      $('.box-img-small').html('\
        <img src="images/songs/' + response['image_song'] + '" alt="">\
      ');
      $('.box-name-artists').html('\
        <h3>' + response['name_artist'] + '</h3>\
      ');
      $('.box-player-left').html('\
        <img src="images/account/'+image_account+'" alt="">\
        <p class="txt-box-player-left"><span class="txt-upload-by">Upload by: </span><span class="account-upload">' + response['username_account_song'] + '</span></p>\
      ');
      $('.container-dowloaded').html('\
        <i class="fas fa-cloud-download-alt"></i> ' + response['dowloads_song'] + '\
      '); 
      $('.box-lyrics').html('\
        <div class="box-lyrics-padding">\
          <div class="name-lyrics">\
            <h2>Lyrics : ' + response['name_song'] + '</h2>\
            ' + postBy + '\
          </div>\
          <p id="divLyric" class="pd_lyric" style="height:auto;">Song: ' + response['name_song'] + ' - ' + response['name_song'] + '\
            ' + result_lyrics + '\
          </p>\
            ' + btnSeeLyrics + '\
        </div>\
      '); 
      $('#myAudio').attr('src', 'audio/' + response['audio_song']);
    }
  });

  //load html bar playlist
  $.ajax({
    url:'../Server-API/load-data-page.php',
    type:'post',
    data: {
      select: 'playlistPlaySong'
    },
    success:function(response) {
      var response = JSON.parse(response);
      for(var k in response['array-playlist']) {
        $('.bar-playlist').append('\
          <div class="box-new-song">\
            <a href="play-music.html">\
              <div class="box-img-new-song">\
                <img src="images/playlists/' + response['array-playlist'][k]['image_playlists'] + '" alt="" class="img-new-song">\
                <button class="btn-play"></button>\
              </div>\
              </a>\
            <div class="box-information-new-song">\
              <a href="play-music.html"><h3> ' + response['array-playlist'][k]['name_playlists'] + ' </h3></a>\
              <p> ' + response['array-playlist'][k]['username_account'] + ' </p>\
            </div>\
          </div>\
        ');
      }
    }
  });

  //load html box item comment
  function loadItemComment() {
    $('.container-item-comment').html('');
    $.ajax({
      url:'../Server-API/load-data-page.php',
      type:'post',
      data: {
        select: 'comment',
        idSong: idSong,
      },
      success:function(response) {
        var response = JSON.parse(response);
        for(var k in response['array_comment']) {
          var imageComment = '';
          if (response['array_comment'][k]['image_account']) {
            imageComment = '<img src="images/account/'+response['array_comment'][k]['image_account']+'" alt="">';
          } else {
            imageComment = '<img src="images/account/no-avatar.jpg" alt="">'; 
          }
          $('.container-item-comment').append('\
            <div class="box-item-comment">\
              <div class="box-left-comment">\
                ' + imageComment + '\
              </div>\
              <div class="box-right-comment">\
                <h4> ' + response['array_comment'][k]['username_account'] + '  <span>' + response['array_comment'][k]['date_time_comment'] + '</span></h4>\
                <p>' + response['array_comment'][k]['content_comment'] + '</p>\
              </div>\
            </div>\
          ');
        }
      }
    });
  }
  loadItemComment();

  //load html listen next
  $.ajax({
    url:'../Server-API/load-data-page.php',
    type:'post',
    data: {
      select: 'listenNext',
      idSong: idSong
    },
    success:function(response) {
      var response = JSON.parse(response);
      for(var k in response['array_song_listen_next']) {
        $('.listen-next-hidden').append('\
          <div class="col-music-next">\
            <a href="play-music.html?idSong=' + response['array_song_listen_next'][k]['id_song'] + '">\
              <div class="box-img-listen-next">\
                <img src="images/songs/' + response['array_song_listen_next'][k]['image_song'] + '" alt="" class="img-music-next">\
                <button class="btn-play btn-play-next" tabindex="0">\
                </button>\
              </div>\
            </a>\
            <div class="name-music-next">\
              <a href="play-music.html?idSong=' + response['array_song_listen_next'][k]['id_song'] + '">\
                <div>' + response['array_song_listen_next'][k]['name_song'] + '</div>\
              </a>\
              <span>' + response['array_song_listen_next'][k]['name_artist'] + '</span>\
            </div>\
          </div>\
        ');
      }
    }
  });

  //load html top 100 country
  $.ajax({
    url:'../Server-API/load-data-page.php',
    type:'post',
    data: {
      select: 'country'
    },
    success:function(response) {
      var response = JSON.parse(response);
      for(var k in response['array-top_100']) {
        $('.container-top100').append('\
          <div class="col-music-next margin-top">\
            <div class="box-img-top100">\
              <img src="images/country/' + response['array-top_100'][k]['image'] + '" alt="" class="img-music-top100">\
              <button class="btn-play btn-play-top100" tabindex="0">\
              </button>\
            </div>\
            <div class="name-music-next">\
              <div>Top 100 Best Song Of ' + response['array-top_100'][k]['name'] + '</div>\
            </div>\
          </div>\
        ');
      }
    }
  });

  function loadUserPlaylist() {
    $.ajax({
      url:'../Server-API/load-data-page.php',
      type:'post',
      data: {
        select: 'userPlaylists',
        idAccount: localStorage.getItem("idAccount"),
      },
      success:function(response) {
        var response = JSON.parse(response);
        var imagePlaylist = '';
        $('.container-playlists').html('');
        for(var k in response['array_user_playlists']) {
          $('.container-playlists').append('\
            <div class="box-item-playlist" data-id="' + response['array_user_playlists'][k]['id'] + '">\
              <div class="box-playlist-left">\
                <p class="txt-name-playlist">' + response['array_user_playlists'][k]['name'] + '</p>\
              </div>\
              <div class="box-playlist-right">\
                <p class="txt-date-time-playlist">' + response['array_user_playlists'][k]['date_time'] + '</p>\
              </div>\
            </div>\
          ');
        }
      }
    });
  }

  //handle btn logout
  $(document).on("click",".js-btn-logout",function() {
    localStorage.removeItem("idAccount");
    Swal.fire({
      icon: 'success',
      title: 'Logout succesful',
      timer: 8500
    }).then((result) => {
      location.reload();
    })
  });

  //handle action menu responsive
  function btnActionMenu() {
    var boxAction = document.getElementsByClassName("box-action")[0];
    $('.btn-action').click(function(){
      if (boxAction.style.display == "block") {
        boxAction.style.display = "none";
      } else {
        boxAction.style.display = "block";
      }
    });
  }
  btnActionMenu();

  //handle check error input comment
  $(".form-comment").validate({
    rules: {
      contentComment: "required",
    },
    messages: {
      contentComment: "",
    },
    onkeyup: function() {
      if ($('.form-comment').valid() == true) {
        $('.js-btn-comment').prop('disabled', false);
      } else {
        $('.js-btn-comment').prop('disabled', true);
      }
    }
  });

  // handle check error create playlist
  $(".form-create-playlist").validate({
    rules: {
      namePlaylist: "required"
    },
    messages: {
      namePlaylist: ""
    },
    onkeyup: function() {
      if ($('.form-create-playlist').valid() == true) {
        $('.js-create-playlist').prop('disabled', false);
      } else {
        $('.js-create-playlist').prop('disabled', true);
      }
    }
  });

  if (check_lyrics == false) {
    $(document).on("click","#seeMoreLyric",function() {
      $('#divLyric').css('max-height', '100%');
      $("#seeMoreLyric").css("display", "none");
      $("#hideMoreLyric").css("display", "block");
    });
    $(document).on("click","#hideMoreLyric",function() {
      $('#divLyric').css('max-height', '250px');
      $("#seeMoreLyric").css("display", "block");
      $("#hideMoreLyric").css("display", "none");
    });
  }

  //handle btn see hidden listen next
  var btnShowListenNext = document.getElementById('showListen');
  var btnHidenListenNext = document.getElementById('hideListen');
  var divListenNext = document.getElementById('hidden-listen');
  btnShowListenNext.addEventListener("click", function() {
    divListenNext.style.maxHeight = "100%";
    btnShowListenNext.style.display = "none";
    btnShowListenNext.style.marginLeft = "5.2em";
    btnHidenListenNext.style.display = "block";
    btnHidenListenNext.style.marginLeft = "5.2em";
  });
  btnHidenListenNext.addEventListener("click", function() {
    divListenNext.style.maxHeight = "473px";
    btnShowListenNext.style.display = "block";
    btnHidenListenNext.style.display = "none";
  });

  //check login to comment
  $('.js-btn-comment').click(function() {
    //handle comment action
    if (localStorage.getItem("idAccount") != null) {
      $.ajax({
        url:'../Server-API/CommentSong.php',
        type:'post',
        data: {
          idAccount: localStorage.getItem("idAccount"),
          idSong: idSong,
          contentComment: $('.content-comment').val(),
        },
        success:function(response) {
          if (response == 'succesfull') {
            Swal.fire(
              'Comment succesfull!',
              'You have just commented!',
              'success'
            ).then((result) => {
              $('.content-comment').val('');
              loadItemComment();
            })
          }
        }
      });
    } else {
      Swal.fire(
        'Login?',
        'You are not logged in?',
        'question'
      )
    }
  });

  //display model add song to playlist
  $('.js-display-model').click(function() {
    if (localStorage.getItem("idAccount") != null) {
      $('#boxAddToPlaylist').modal('show');
      loadUserPlaylist();
    } else {
      Swal.fire(
        'Login?',
        'You are not logged in?',
        'question'
      )
    }
  });

  //handle create new playlist
  $('.js-create-playlist').click(function() {
    var namePlaylist = $('.input-name-playlist').val();
    $.ajax({
      url: "../Server-API/CreatePlaylist.php",
      type: "post",
      dataType :"text",
      data: {
        idAccount: localStorage.getItem("idAccount"),
        namePlaylist: namePlaylist
      },
      success:function (response){
        if (response == 'succesful') {
          Swal.fire({
            title: 'Create playlist succesful',
            text: '',
            icon: 'success',
          }).then((result) => {
            $('.input-name-playlist').val('');
            loadUserPlaylist();
          });
        }
      }
    });
  });

  $(document).on("click",".box-item-playlist",function() {
    var idPlaylist = $(this).attr('data-id');
    $.ajax({
      url: "../Server-API/AddSongToPlaylist.php",
      type: "post",
      dataType :"text",
      data: {
        idPlaylist: idPlaylist,
        idSong: idSong
      },
      success:function (response){
        if (response == 'succesful') {
          Swal.fire({
            icon: 'success',
            title: 'Add to playlist succesful',
            text: '',
            showConfirmButton: false,
            timer: 4500
          }).then((result) => {
          })
        } else if (response == 'fail') {
          Swal.fire({
            icon: 'error',
            title: 'Playlist have been add this song!',
            text: '',
          })
        } else {
          alert(response);
        }
      }
    });
  });

  $(document).on("click",".button-seach",function() {
    if (($('.form-input-search').val()) != '') {
      window.location.href = "search-page.html?nameSong=" + $('.form-input-search').val();
    }
  });
});
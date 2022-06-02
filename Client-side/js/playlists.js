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

//load html bar playlist
$.ajax({
  url:'../Server-API/load-data-page.php',
  type:'post',
  data: {
    select: 'Playlists'
  },
  success:function(response) {
    var response = JSON.parse(response);
    var imagePlaylist;
    for(var k in response['array_playlists']) {
      if (response['array_playlists'][k]['image'] == '') {
        imagePlaylist = 'No-Image-Playlist.jpg';
      } else {
        imagePlaylist = response['array_playlists'][k]['image'];
      }
      $('.container-playlist').append('\
        <div class="box-new-song playlist-item">\
          <div class="box-img-new-song">\
            <div>\
              <a href="play-playlist.html?idPlaylist=' + response['array_playlists'][k]['id'] + '"><img src="images/playlists/' + imagePlaylist + '" alt="" class="img-new-song"></a>\
            </div>\
          </div>\
          <div class="box-information">\
          <a href="play-playlist.html?idPlaylist=' + response['array_playlists'][k]['id'] + '"><p class="name-playlist">' + response['array_playlists'][k]['name'] + '</p></a>\
          </div>\
        </div>\
      ');
    }
  }
});

$(document).on("click",".button-seach",function() {
  if (($('.form-input-search').val()) != '') {
    window.location.href = "search-page.html?nameSong=" + $('.form-input-search').val();
  }
});
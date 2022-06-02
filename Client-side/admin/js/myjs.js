$('.page-header').html('\
  <div class="header-left">\
    <a href="index.html"><p class="sb-admin-v20">SB Admin v2.0</p></a>\
  </div>\
  <div class="header-right">\
    <div class="box-item" id="box-user">\
      <i class="fas fa-user" id="icon-header"></i><i class="fas fa-sort-down" id="icon-down"></i>\
      <div class="drop-down-user" id="drop-user" style="display: none;">\
        <div class="btn-drop-down btn-log-out">\
          <i class="fas fa-user-cog icon-drop-down" id="icon-drop-down"></i>\
          <div class="txt-drop-down">Setting</div>\
        </div>\
        <a href="profile.php">\
          <div class="btn-drop-down btn-log-out">\
            <i class="far fa-id-card icon-drop-down" id="icon-drop-down"></i>\
            <div class="txt-drop-down">ProFile</div>\
          </div>\
        </a>\
        <a href="log-out.php">\
          <div class="btn-drop-down btn-log-out">\
            <i class="fas fa-sign-out-alt icon-drop-down" id="icon-drop-down"></i>\
            <div class="txt-drop-down">Log Out</div>\
          </div>\
        </a>\
      </div>\
    </div>\
  </div>\
');

$.ajax({
  url:'../../Server-API/SelectNumberRowTable.php',
  type:'post',
  success:function(response) {
    var response = JSON.parse(response);
    $('.main-left').html('\
      <div class="bar-item-tool">\
        <ul class="all-item-tool">\
          <a href="account.html">\
            <li class="item-tool"><i class="fas fa-users" id="icon-main-left"></i>Account ('+ response['numberAccount'] +')<span class=""></span></li>\
          </a>\
          <a href="artist.php">\
            <li class="item-tool"><i class="fas fa-ticket-alt" id="icon-main-left"></i>Artist ('+ response['numberArtist'] +')<span class=""></span></li>\
          </a>\
          <a href="songs.html">\
            <li class="item-tool"><i class="fas fa-music" id="icon-main-left"></i></i>Song ('+ response['numberSong'] +')<span class=""></span></li>\
          </a>\
          <a href="comment.php">\
            <li class="item-tool"><i class="fas fa-comments" id="icon-main-left"></i>Comment ('+ response['numberComment'] +')<span class=""></span></li>\
          </a>\
          <a href="country.html">\
            <li class="item-tool"><i class="fas fa-globe-asia" id="icon-main-left"></i>Country ('+ response['numberCountry'] +')<span class=""></span></li>\
          </a>\
          <a href="playlists.php">\
            <li class="item-tool"><i class="fas fa-list" id="icon-main-left"></i>Playlists ('+ response['numberPlaylists'] +')<span class=""></span></li>\
          </a>\
          <a href="usertypes.php">\
            <li class="item-tool"><i class="fas fa-users-cog" id="icon-main-left"></i>User types ('+ response['numberUserTypes'] +')<span class=""></span></li>\
          </a>\
        </ul>\
      </div>\
    ');
  }
});

$(document).ready(function () {

  var boxUser = document.getElementById("box-user");
  var dropUser = document.getElementById("drop-user");
  boxUser.addEventListener("click", function () {
    if (dropUser.style.display == "none") {
      dropUser.style.display = "block";
    } else {
      dropUser.style.display = "none";
    }
  });
});
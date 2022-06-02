var idAccount = localStorage.getItem("idAccount");
var username = localStorage.getItem("username");
var pathname;
var url;
var type;
var idPlaylistEdit;
var idPlaylistEditSongs;

//get type in URL
function getPathType() {
  pathname = $(location).attr("href");
  url = new URL(pathname);
  type = url.searchParams.get("type");
  if (!type) {
    window.location.href = "index.html";
  }
}
getPathType();


//load html bar playlist
function loadBarPlaylist() {
  $.ajax({
    url:'../Server-API/load-data-page.php',
    type:'post',
    data: {
      select: 'userPlaylists',
      idAccount: idAccount
    },
    success:function(response) {
      var response = JSON.parse(response);
      var imagePlaylist = '';
      $('.container-main-right').html('');
      for(var k in response['array_user_playlists']) {
        if (response['array_user_playlists'][k]['image']) {
          imagePlaylist = response['array_user_playlists'][k]['image'];
        } else {
          imagePlaylist = 'No-Image-Playlist.jpg';
        }
        $('.container-main-right').append('\
          <div class="box-playlist">\
            <a class="link-image-playlist" href="play-playlist.html?idPlaylist=' + response['array_user_playlists'][k]['id'] + '"><img src="images/playlists/'+ imagePlaylist +'"></a>\
            <div class="box-information-playlist">\
              <p class="name-playlist" title="' + response['array_user_playlists'][k]['name'] + '">' + response['array_user_playlists'][k]['name'] + '</p>\
              <p class="action-playlist">\
                <i class="fas fa-pen js-display-edit" data-toggle="modal" data-target="#boxEditPlaylist" data-id="' + response['array_user_playlists'][k]['id'] + '"></i>\
                <i class="fas fa-list js-display-list-songs" data-toggle="modal" data-target="#boxEditPlaylistsongs" data-id="' + response['array_user_playlists'][k]['id'] + '"></i>\
                <i class="fas fa-trash-alt js-delete-playlist" idPlaylist="' + response['array_user_playlists'][k]['id'] + '"></i>\
              </p>\
            </div>\
          </div>\
        ');
      }
    }
  });
}

//change src image by js
function readURL(input) {
  var numFiles = $("input:file")[0].files.length;
  var images = '.blah0';
  if (input.files && input.files[0]) {
    var reader = new FileReader();
      reader.onload = function (e) {
        $('.blah0')
          .attr('src', e.target.result)
          .width(118)
          .height(118);
      };
    reader.readAsDataURL(input.files[0]);
  }
}

$(document).ready(function () {

  //handle model edit playlist when hidden
  $('.modal-edit-playlist').on('hidden.bs.modal', function () {
    $('.name-edit-playlist').val('');
    $('.img-edit-playlist'). attr("src", "");
  });

  //handle model create playlist when hidden
  $('.modal-playlist').on('hidden.bs.modal', function () {
    $('.input-name-playlist').val('');
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

  // handle check error edit playlist
  $(".form-edit-playlist").validate({
    rules: {
      nameEditPlaylist: "required"
    },
    messages: {
      nameEditPlaylist: ""
    },
    onkeyup: function() {
      if ($('.form-edit-playlist').valid() == true) {
        $('.js-edit-playlist').prop('disabled', false);
      } else {
        $('.js-edit-playlist').prop('disabled', true);
      }
    }
  });

  //handle btn create playlist
  $(document).on("click",".js-create-playlist",function() {
    var namePlaylist = $('.input-name-playlist').val();
    $.ajax({
      url: "../Server-API/CreatePlaylist.php",
      type: "post",
      dataType :"text",
      data: {
        idAccount: idAccount,
        namePlaylist: namePlaylist
      },
      success:function (response){
        if (response == 'succesful') {
          Swal.fire({
            title: 'Create playlist succesful',
            text: '',
            icon: 'success',
          }).then((result) => {
            $('.modal-playlist').modal('hide');
            loadBarPlaylist();
          });
        }
      }
    });
  });

  //handle btn display action edit playlist
  $(document).on("click",".js-display-edit",function() {
    idPlaylistEdit = $(this).attr('data-id');
    $.ajax({
      url: "../Server-API/load-data-page.php",
      type: "post",
      dataType :"text",
      data: {
        select: 'selectEditPlaylist',
        idPlaylistEdit: idPlaylistEdit,
      },
      success:function (response){
        var response = JSON.parse(response);
        $('.name-edit-playlist').val(response['namePlaylist']);
        if (response['imagePlaylist']) {
          $('.img-edit-playlist'). attr("src", "images/playlists/" + response['imagePlaylist']);
        }
      }
    });
  });

  //load html playlist songs
  function loadPlaylistSongs(idPlaylistSongs) {
    $('.container-playlist-songs').html('');
    $.ajax({
      url:'../Server-API/load-data-page.php',
      type:'post',
      data: {
        select: 'playlistSong',
        idPlaylist: idPlaylistSongs
      },
      success:function(response) {
        var response = JSON.parse(response);
        var i = 1;
        for(var k in response['array-playlist-songs']) {
          $('.container-playlist-songs').append('\
            <div class="item-playlist-songs">\
              <div class="information-songs-left">\
                <p class="txt-songs">\
                  <span class="txt-row-number">'+ i +'.</span>\
                  <span class="txt-name-song">\
                    <a href="play-music.html?idSong='+ response['array-playlist-songs'][k]['id_song'] +'">'+ response['array-playlist-songs'][k]['name_song'] +'</a> - \
                  </span>\
                  <span class="txt-name-artist">'+ response['array-playlist-songs'][k]['name_artist'] +'</span>\
                </p>\
              </div>\
              <div class="action-songs-right">\
                <p class="action-song">\
                  <span class="action-delete"><i class="fas fa-trash-alt js-delete-playlist-song" idPlaylistSong="'+ response['array-playlist-songs'][k]['id_playlists_song'] +'"></i></span>\
                  <span class="action-play-song"><a href="play-music.html?idSong='+ response['array-playlist-songs'][k]['id_song'] +'"><i class="fas fa-play"></i></span>\
                </p>\
              </div>\
            </div>\
          ');
          i++;
        }
        if ($('.container-playlist-songs').is(':empty')) {
          $('.container-playlist-songs').html('\
            <p>No songs have been added yet</>\
          ');
        }
      }
    });
  }

  //handle btn display action edit playlist songs
  $(document).on("click",".js-display-list-songs",function() {
    idPlaylistEditSongs = $(this).attr('data-id');
    loadPlaylistSongs(idPlaylistEditSongs);
  });

  //handle btn delete playlist
  $(document).on("click",".js-delete-playlist",function() {
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.value) {
        var idPlaylist = $(this).attr('idPlaylist');
        $.ajax({
          url: "../Server-API/DeletePlaylist.php",
          type: "post",
          dataType :"text",
          data: {
            idPlaylist: idPlaylist,
          },
          success:function (response){
            if (response == 'succesful') {
              Swal.fire({
                title: 'Deleted',
                text: "Your playlist had delete",
                icon: 'success',
              }).then((result) => {
                loadBarPlaylist();
              });
            }
          }
        });
      }
    })
  });

  //handle btn edit playlist
  $(document).on("click",".js-edit-playlist",function() {
    var fd = new FormData();
    var filesImage = $('#file')[0].files[0];
    fd.append('file', filesImage);
    fd.append('idPlaylist', idPlaylistEdit);
    fd.append('namePlaylist', $('.name-edit-playlist').val());
    $.ajax({
      url: '../Server-API/EditPlaylist.php',
      type: 'post',
      data: fd,
      contentType: false,
      processData: false,
      success: function(response){
        if (response == 'succesful') {
          Swal.fire({
            icon: 'success',
            title: 'Edit succesful',
            timer: 8500
          }).then((result) => {
            loadBarPlaylist();
            $('.modal-edit-playlist').modal('hide');
          })
        } else {
          Swal.fire({
            icon: 'error',
            title: response,
            timer: 8500
          }).then((result) => {
            $('.modal-edit-playlist').modal('hide');
          }) 
        }
      },
    });
  });

  //handle btn delete playlist song
  $(document).on("click",".js-delete-playlist-song",function() {
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.value) {
        var idPlaylistSong = $(this).attr('idPlaylistSong');
        $.ajax({
          url: "../Server-API/DeletePlaylistSong.php",
          type: "post",
          dataType :"text",
          data: {
            idPlaylistSong: idPlaylistSong,
          },
          success:function (response){
            if (response == 'succesful') {
              Swal.fire({
                title: 'Deleted',
                text: "Your playlist had delete",
                icon: 'success',
              }).then((result) => {
                loadPlaylistSongs(idPlaylistEditSongs);
              });
            }
          }
        });
      }
    })
  });

});

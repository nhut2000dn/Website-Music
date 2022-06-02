var idAccount = localStorage.getItem("idAccount");
var username = localStorage.getItem("username");
var pathname;
var url;
var type;

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

//load page by type in URL
function loadMainPage(nameType) {
  var pathnameCurrent = window.location.href;
  var newPathname = pathnameCurrent.split('?type');
  url = newPathname[0] + '?type=' + nameType;
  window.history.pushState('object or string', 'Title', url);
  getPathType();
  if (type == 'playlist') {
    $('.title-fucntion').html('\
      <h3 class="title-left">\
        <span>Playlist</span>\
      </h3>\
      <div class="title-right"><button data-toggle="modal" data-target="#exampleModalCenter">Creat playlist</button></div>\
    ');
    $('.txt-item-right').css('color', '#0088c5');
    loadBarPlaylist();
  } else {
    $('.txt-item-right').css('color', '#5f595f');
  }
  if (type == 'profile') {
    $('.title-fucntion').html('\
      <h3 class="title-left">Profile</h3>\
    ');
    $('.txt-profile').css('color', '#0088c5');
    loadBoxChangeProfile();
  } else {
    $('.txt-profile').css('color', '#5f595f');
  }
  if (type == 'change-password') {
    $('.title-fucntion').html('\
      <h3 class="title-left">Change password</h3>\
    ');
    $('.txt-change-password').css('color', '#0088c5');
    loadBoxChangePassword();
  } else {
    $('.txt-change-password').css('color', '#5f595f');
  }
}

//check error form change password
function checkErrorFormProfile() {
  $(".form-profile").validate({
    errorElement: 'li',
    rules: {
      fullName: {
        required: true,
      },
    },
    messages: {
      fullName: {
        required: "Please enter your fullname",
      },
    },
    onkeyup: function() {
      if ($('.form-profile').valid() == true) {
        $('.js-edit-profile').prop('disabled', false);
      } else {
        $('.js-edit-profile').prop('disabled', true);
      }
    }
  });
}

function promiseLoadAjax() {
  var promise = $.ajax('../Server-API/load-data-page.php').done(function() {});
  promise.then(function() {
    checkErrorFormProfile();
  });
}

//load html bar playlist
function loadBoxChangeProfile() {
  var image;
  $.ajax({
    url: "../Server-API/load-data-page.php",
    type: "post",
    dataType :"text",
    data: {
      select: 'profileAccount',
      idAccount: idAccount,
    },
    success:function (response){
      response = JSON.parse(response);
      if (response['image']) {
        image = response['image'];
      } else {
        image = 'no-avatar.jpg';
      }
      $('.container-main-right').html('\
        <form action="" method="post" id="form" class="form-profile">\
          <div class="profile-left">\
            <table class="tb-profile-left">\
              <tr class="row-profile-left">\
                <th>Full name: </th>\
                <td class="col-profile-left"><input type="text" placeholder="Enter your full name" name="fullName" class="full-name" value="' + response['fullName'] + '"></td>\
              </tr>\
              <tr class="row-profile-left">\
                <th>Username: </th>\
                <td class="col-profile-left"><input type="text" placeholder="Enter your username" name="username" readonly="readonly" value="' + response['username'] + '"></td>\
              </tr>\
              <tr class="row-profile-left">\
                <th>Email: </th>\
                <td class="col-profile-left"><input type="text" placeholder="Enter your email" name="email" readonly="readonly" value="' + response['email'] + '"></td>\
              </tr>\
              <tr class="row-profile-left">\
                <th></th>\
                <td class="col-profile-left"><button type="button" class="btn-edit-profile js-edit-profile">Update</button></td>\
              </tr>\
            </table>\
          </div>\
          <div class="profile-right">\
            <table class="tb-profile-right">\
              <tbody>\
                <tr class="row-profile-right">\
                  <td class="col-profile-right"><img class="img-avatar blah0"  id="blah0" src="images/account/'+ image +'" alt=""></td>\
                </tr>\
                <tr class="row-profile-right">\
                  <td class="col-profile-right"><span>Chọn Ảnh</span></td>\
                </tr>\
                <tr class="row-profile-right">\
                  <td class="col-profile-right"><input type="file" id="imgFile" name="imgFile" onchange="readURL(this);"></td>\
                </tr>\
                <tr class="row-profile-right">\
                  <td class="col-profile-right"><span class="img-txt">Dung lượng file tối đa 1MB</span></td>\
                </tr>\
                <tr class="row-profile-right">\
                  <td class="col-profile-right"><span class="img-txt">File phải có định dạng jpg, jpeg, gif, png !</span></td>\
                </tr>\
              </tbody>\
            </table>\
          </div>\
        </form>\
      ');
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

  loadMainPage(type);
  promiseLoadAjax();

  //handle btn menu left choose item password
  $(document).on("click",".js-menu-profile",function() {
    loadMainPage('profile');
    promiseLoadAjax();
  })

  //handle btn create playlist
  $(document).on("click",".js-edit-profile",function() {
    var fd = new FormData();
    var filesImage = $('#imgFile')[0].files[0];
    var fullName = $('.full-name').val();
    fd.append('idAccount', idAccount);
    fd.append('file', filesImage);
    fd.append('fullName', fullName);
    $.ajax({
      url: '../Server-API/EditProfile.php',
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
            
          })
        } else {
          Swal.fire({
            icon: 'error',
            title: response,
            timer: 8500
          }).then((result) => {
          }) 
        }
      },
    });

  });
});

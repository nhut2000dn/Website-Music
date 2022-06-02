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


//load html bar playlist
function loadBoxChangePassword() {
  $('.container-main-right').html('\
    <form action="" method="post" id="form" class="form-change-password">\
      <input type="password" class="password" name="password" placeholder="Current password">\
      <div class="error-password"></div>\
      <input type="password" class="new-password" name="newPassword" placeholder="New password">\
      <input type="password" class="comfirm-password" name="confirmPassword" placeholder="Confirm password">\
      <button type="button" class="btn-change-password js-change-password" disabled>Change password</button>\
    </form>\
  ');
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
  checkErrorFormPassword();

  //handle btn menu left choose item password
  $(document).on("click",".js-menu-password",function() {
    loadMainPage('change-password');
    checkErrorFormPassword();
  })

  $.validator.addMethod("validatePassword", function (value, element) {
    return this.optional(element) || /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,16}$/i.test(value);
  });

  //check error form change password
  function checkErrorFormPassword() {
    $(".form-change-password").validate({
      errorElement: 'li',
      rules: {
        password: {
          required: true,
        },
        newPassword: {
          required: true,
          validatePassword: true,
        },
        confirmPassword: {
          equalTo: ".new-password"
        },
      },
      messages: {
        password: {
          required: "Please enter your fullname",
        },
        newPassword: {
          required: "Please enter your password",
          validatePassword: "Enter your password must be between 8 and 15 characters and at least one numeric, one uppercase"
        },
        confirmPassword: "Enter Confirm Password Same as Password",
      },
      onkeyup: function() {
        if ($('.form-change-password').valid() == true) {
          $('.js-change-password').prop('disabled', false);
        } else {
          $('.js-change-password').prop('disabled', true);
        }
      }
    });
  }

  //handle btn create playlist
  $(document).on("click",".js-change-password",function() {
    var password = $('.password').val();
    var newPassword = $('.new-password').val();
    $.ajax({
      url: "../Server-API/ChangePassword.php",
      type: "post",
      dataType :"text",
      data: {
        idAccount: idAccount,
        password: password,
        newPassword: newPassword
      },
      success:function (response){
        if (response == 'succesful') {
          Swal.fire({
            title: 'Change password successfully',
            text: '',
            icon: 'success',
          }).then((result) => {
            $(".form-change-password")[0].reset();
          });
        } else {
          $('.error-password').html('<li>Password not correctly</li>');
        }
      }
    });
  });
});

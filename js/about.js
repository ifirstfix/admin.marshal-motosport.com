$(function(){
  
  get_about();

  $("#frm_about").validate({
      rules: {
        youtube_url: {
            required: true
          }
      },
      errorPlacement: function(error, element) {
      },
      errorClass: "help-inline text-danger",
      highlight: function(element) {
          $(element).closest('.form-group').addClass('has-error').removeClass('has-success');
          $(element).closest('.form-group').prevObject.addClass('is-invalid').removeClass('is-valid');
      },
      unhighlight: function(element) {
          $(element).closest('.form-group').removeClass('has-error').addClass('has-success');//.addClass('has-success');
          $(element).closest('.form-group').prevObject.removeClass('is-invalid').addClass('is-valid');
      },
      submitHandler: function(form, e) {
          e.preventDefault();
          var data = new FormData($(form)[0]);
          data.append("cmd", "update_about");
          $.ajax({
              type: "post",
              url: BASE_LANG + "service/about.php",
              data: data,
              cache: false,
              contentType: false,
              processData: false,
              dataType: "json",
              success: function(res){
                  if (res.status == true) {
                      alert_center('Update about', res.msg, "success")
                      get_about();
                  } else {
                      alert_center('Update about', res.msg, "error")
                  }
              }
          });
      } 
  });

});

function get_about(){
  $.ajax({
    type: "post",
    url: BASE_LANG + "service/about.php",
    data: {
        "cmd": "get_about"
    },
    dataType: "json",
    success: function(res) {
        if (res.status == true) {
            $('#iframe_src').attr('src', 'https://www.youtube.com/embed/' + res.data.YOUTUBE_URL + '?autoplay=' + res.data.YOUTUBE_AUTOPLAY + '&mute=1');
            $('#youtube_url').val(res.data.YOUTUBE_URL);
            $('input[name=auto_play]').attr("checked", (res.data.YOUTUBE_AUTOPLAY == '1') ? true : false);
        }
    }
});
}
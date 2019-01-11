$( document ).ready(function() {
  $('.contact-form').submit( function (e) {
    e.preventDefault();
    let his = $(this);
    let serialize = his.serializeArray();
    let data = {};
    $.each(serialize, function(i, field){
      data[field.name] = field.value;
    });
    $.ajax({
      url: "mail.php",
      type: "post",
      dataType: "json",
      data: data,
      beforeSend: function(){
        $('.spinner_container').addClass('visible');
      },
      success: function (e) {
        $('.spinner_container').removeClass('visible');
        console.log(e);
        if(e.error){
          console.log(e.error);
          $(".errorAnswer p").html(e.error);
        } else{
          $(".messages").addClass('visible');
          $(".messages p").html(e.success);
          setTimeout(function(){
            $(".messages").removeClass('visible');
          },3000);
          his.find('input').val('');
          his.find('textarea').val('');
        }
      }
    });
    return false;
  });
});

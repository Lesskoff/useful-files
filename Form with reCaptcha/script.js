$("#call-order-main").submit(function(e) {
  e.preventDefault();
  var it = $(this);
  var find = it.parents('section');
  var serialize = $(this).serializeArray();
  var data = {};
  $.each(serialize, function (i, field) {
    data[field.name] = field.value
  });
  $.ajax({
    url: $(this).attr('action'),
    dataType: "json",
    data: $(this).serialize(),
    type: $(this).attr('method'),
    success: function (e) {
      console.log(e);
      if(e.noRecaptchaError && e.success){
        find.find('.feedback-message').html('Спасибо, Ваша заявка принята').addClass('feedback-message-success');
        it.hide();
      } else if(!e.noRecaptchaError) {
        find.find('.feedback-message').html('Пожалуйста, пройдите проверку на робота').addClass('feedback-message-error');
        it.find('.g-recaptcha>div').addClass('g-recaptcha-error');
      }
    },
    error: function (xhr, str) {
      find.find('.feedback-message').html('Возникла ошибка, пожалуйста, попробуйте позднее').addClass('feedback-message-error');
      console.log('Ошибка отправки: ' + xhr.responseCode);
    }
  });
});

$(".НАЗВАНИЕ КЛАССА").click(function(){ 
	dataLayer.push({
		'event':'adv.event',
		'eventCategory':'НАЗВАНИЕ КАТЕГОРИИ',
		'eventAction':'НАЗВАНИЕ ДЕЙСТВИЯ',
		'eventLabel':'',
		'eventValue':0,
		'eventNonInteraction':'false'
	}); 
});



Пример:

jQuery('document').ready(function() {

	// Событие на отправку формы обратной связи на странице Kontakty
	// Проверка на событие, если отправка формы происходит при помощи AJAX (устанавливаем таймер)
	$('КАКАЯ_НИБУДЬ_КНОПКА').click(function() {
		function submited() {
			// Выполняем проверку, цепляемся за какое-то изменение в появляющихся сообщениях
			var check = jQuery('БЛОК_С_СООБЩЕНИЕМ').hasClass('СООБЩЕНИЕ_ОБ_УСПЕШНОЙ_ОТПРАВКЕ');
			if (check == true) {
				dataLayer.push({
					'event': 'adv.event',
					'eventCategory': 'formSubmit',
					'eventAction': 'feedback',
					'eventLabel': '',
					'eventValue': 0,
					'eventNonInteraction': 'false'
				});
				$('#sp_qc_submit').css('background', 'green');
				$('#sp_quickcontact94').append('<br> <span style="color: #4c8aab;font-size: 10px;">Okay</span>');
			}
		}

		setTimeout(submited, 3000);
	});
		
});
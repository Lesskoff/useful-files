<script>
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
</script>



Пример:

<script>
	$(document).load(function(){ 
		dataLayer.push({
			'event':'adv.event',
			'eventCategory':'formSubmit',
			'eventAction':'callBack',
			'eventLabel':'',
			'eventValue':0,
			'eventNonInteraction':'false'
		});
	});
</script>
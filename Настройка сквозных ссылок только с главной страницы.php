<?php
	if($_SERVER['REQUEST_URI'] == '/')
		echo '';
	else
		echo '';
?>



Пример записи без echo 

<div class="logo">
<?php
	if($_SERVER['REQUEST_URI'] == '/'):?>

	<?else:?>

	<?endif;?>





пример

<?php if($_SERVER['REQUEST_URI'] == '/') { ?>
			<div class="zavodd">
					<a href="http://www.zavodd.ru">
							Создание сайта
					</a>
					<a href="http://www.zavodd.ru" rel="nofollow">
							<img src="<?php global $gpath; echo $gpath;?>/images/zavodd-color.gif" 
								 alt="Web-студия Zavodd - создание сайтов в Хабаровске" 
								 title="Создание сайтов в веб студии Zavodd" />
					</a>
			</div>
			<!-- Настройка, чтобы отображение ссылки было только на главной -->
<?php } 
			else {?> 
				<div class="zavodd">
					<p>
							Создание сайта
					</p>
					<p>
							<img src="<?php global $gpath; echo $gpath;?>/images/zavodd-color.gif" 
								 alt="Web-студия Zavodd - создание сайтов в Хабаровске" 
								 title="Создание сайтов в веб студии Zavodd" />
					</p>
			</div>
<?php } ?>
			<!-- Настройка, чтобы отображение ссылки было только на главной end -->
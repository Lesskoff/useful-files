// нужно вставить в header в самое начало документа:
// require($_SERVER['DOCUMENT_ROOT'] . '/seo-redirect.php');

<?php
$advRedirect = array(
	'/news' => '/about_us/news/',
	);


if(isset($advRedirect[$_SERVER['REQUEST_URI']])){
	$redirect = 'http://' . $_SERVER['HTTP_HOST'] . $advRedirect[$_SERVER['REQUEST_URI']];
	header('HTTP/1.1 301 Moved Permanently');
	header('Location: ' . $redirect);
}
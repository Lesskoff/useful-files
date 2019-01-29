<?php
// require $_SERVER["DOCUMENT_ROOT"].'/seo-redirects.php'; // подгружаем файл с редиректами битых и неверных ссылок - Нужно вставить куда нибудь перед загрузкой сайта (например в index.php или header.php)

$links = [
	'/from' => '/to',
];


if(isset($links[$_SERVER["REQUEST_URI"]])){
	$redirect = "http://" . $_SERVER["HTTP_HOST"] . $links[$_SERVER["REQUEST_URI"]];
	header("Location: " . $redirect, true,  301); exit;
}
?>

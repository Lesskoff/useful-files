<?php
$links = array(
	'/from' => '/to',
	);


if(isset($links[$_SERVER['REQUEST_URI']])){
	$redirect = 'http://' . $_SERVER['HTTP_HOST'] . $links[$_SERVER['REQUEST_URI']];
	header('HTTP/1.1 301 Moved Permanently');
	header('Location: ' . $redirect);
}
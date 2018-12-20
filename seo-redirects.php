<?php
$links = [
	'/from' => '/to',
];


if(isset($links[$_SERVER["REQUEST_URI"]])){
	$redirect = "http://" . $_SERVER["HTTP_HOST"] . $links[$_SERVER["REQUEST_URI"]];
	header("Location: " . $redirect, true,  301); exit;
}
?>

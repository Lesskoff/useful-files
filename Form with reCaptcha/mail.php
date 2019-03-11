<?php

$msg = array(
	'noRecaptchaError' => false,
	'noErrors' => false,
);

if (isset($_POST['g-recaptcha-response']))
{

	$url = 'https://www.google.com/recaptcha/api/siteverify';
	$params = array(
		'secret' => "SECRET_SITEKEY,
		'response' => $_POST['g-recaptcha-response'],
		'remoteip' => $_SERVER['REMOTE_ADDR']
	);
	
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	
	$response = curl_exec($ch);
	if(!empty($response))
		$decoded_response = json_decode($response);
	
	// $success = false;
	
	if ($decoded_response && $decoded_response->success)
		$success = $decoded_response->success;
	
	if ($success)
		$msg['noRecaptchaError'] = true;
}

if(isset($_POST['name']) && !empty($_POST['name']) && isset($_POST['phone']) && !empty($_POST['phone']))
	$msg['noErrors'] = true;

if($msg['noErrors'] && $msg['noRecaptchaError']) {
	// Здесь можно написать скрипт отправки самой заявки, например, при помощи функции mail()
}

echo json_encode($msg);

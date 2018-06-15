<? 
	$_SESSION['g-recaptcha-response'] = '';
	if ($_POST['g-recaptcha-response']) {
		$_SESSION['g-recaptcha-response'] = htmlspecialcharsbx(substr($_POST['g-recaptcha-response'], 0, 3000));
	} 
?>
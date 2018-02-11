<?php 
require_once "recaptchalib.php";
require_once "phpmailer/PHPMailerAutoload.php";
$mail = new PHPMailer;
$mail->CharSet = 'utf-8';

$name = $_POST['user_name'];
$phone = $_POST['user_phone'];
$email = $_POST['user_email'];

$secret    = "YOUR_SECRET_CODE";
$reCaptcha = new ReCaptcha($secret);

$response = null;

// if submitted check response
if ($_POST["g-recaptcha-response"])
{
	$response = $reCaptcha->verifyResponse(
		$_SERVER["REMOTE_ADDR"],
		$_POST["g-recaptcha-response"]
	);
}

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.mail.ru';  																							// Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'iutas@bk.ru'; // Ваш логин от почты с которой будут отправляться письма
$mail->Password = 'PASSWORD'; // Ваш пароль от почты с которой будут отправляться письма
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465; // TCP port to connect to / этот порт может отличаться у других провайдеров

// Прикрепление файлов
if(isset($_FILES['uploaded_file']))
{
	if($_FILES['uploaded_file']['error'] == 0)
	{
		if($_FILES['uploaded_file']['size'] <= 10000000)
		{
			$mail->AddAttachment($_FILES['uploaded_file']['tmp_name'],$_FILES['uploaded_file']['name']);
		}
	}
}

$mail->setFrom('iutas@bk.ru'); // от кого будет уходить письмо?
$mail->addAddress('iutas@bk.ru');     // Кому будет уходить письмо 
//$mail->addAddress('ellen@example.com');               // Name is optional
//$mail->addReplyTo('info@example.com', 'Information');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');
//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Заявка с тестового сайта';
$mail->Body    = '' .$name . ' оставил заявку, его телефон ' .$phone. '<br>Почта этого пользователя: ' .$email;
$mail->AltBody = '';

if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']))
{
	if (isset($_POST['name']) && !empty($_POST['name']) && isset($_POST['phone']) && !empty($_POST['phone']) && isset($_POST['email']) && !empty($_POST['email']))
	{
		if(!$mail->send()) {
			echo '<p style="text-align:center; font-size:30px">Произошла ошибка</p>' . '<p style="text-align:center; font-size:20px">Позвонить нам: 8 (4212) 936-606, 8 (4212) 62-57-62 или</p>' . '<p style="text-align:center; font-size:20px"><a href="/">Вернуться на сайт</a></p>';
		} else {
			header('location: thank-you.html');
		}
	} else {
		echo '<p style="text-align:center; font-size:30px">Заполнены не все поля</p>' . '<p style="text-align:center; font-size:20px">Позвонить нам: 8 (4212) 936-606, 8 (4212) 62-57-62 или</p>' . '<p style="text-align:center; font-size:20px"><a href="/">Вернуться на сайт</a></p>';
	}
}
else
{
	echo '<p style="text-align:center; font-size:30px">Пожалуйста, пройдите проверку на робота</p>' . '<p style="text-align:center; font-size:20px"><a href="/">Вернуться на сайт</a></p>';
}
?>


<?php
header('Content-type: application/json');
$msg_box = ""; // в этой переменной будем хранить сообщения формы
$errors = array(); // контейнер для ошибок
// проверяем корректность полей
if (!$_POST['user_name']) $errors[] = "Поле 'Ваше имя' не заполнено!";
if (!$_POST['user_phone']) $errors[] = "Поле 'Ваш телефон' не заполнено!";
if (!$_POST['user_email']) $errors[] = "Поле 'Email' не заполнено!";

// если форма без ошибок
if (empty($errors)) {
    // собираем данные из формы
    $message = "<p>Имя пользователя: <b>" . $_POST['user_name'] . "</b></p>";
    $message .= "<p>Телефон пользователя: <b>" . $_POST['user_phone'] . "</b></p>";
    $message .= "<p>Email пользователя: <b>" . $_POST['user_email'] . "</b></p>";
    if ($_POST['user_text'])  $message .= "<p>Текст пользователя: <b>" . $_POST['user_text'] . "</b>";
    send_mail($message); // отправим письмо
    // выведем сообщение об успехе
    $msg_box = "ЗАЯВКА УСПЕШНО ОТПРАВЛЕНА!";
} else {
    // если были ошибки, то выводим их
    $err_box = "";
    foreach ($errors as $one_error) {
        $err_box .= $one_error ." <br/> ";
    }
}

echo json_encode(array(
    'error' => $err_box,
    'success' => $msg_box
));


// функция отправки письма
function send_mail($message)
{
    // почта, на которую придет письмо
    $mail_to = "iutas@bk.ru";
    // тема письма
    $subject = "Письмо с обратной связи";

    // заголовок письма
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n"; // кодировка письма
    $headers .= "From: Заявка с сайта <no-reply@test.com>\r\n"; // от кого письмо

    // отправляем письмо
    mail($mail_to, $subject, $message, $headers);
}

?>

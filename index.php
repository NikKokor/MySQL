<?php
require 'C:\Users\nikko\PhpstormProjects\MySQL\vendor\autoload.php';
require 'C:\Users\nikko\PhpstormProjects\MySQL\src\Database.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(dirname(__DIR__) . '\MySQL\templates');
$twig = new Environment($loader);

$Database = new Database();

$mode = $_GET['mode'];

if ($mode == 1) {              //Регистрация
    $login = $_GET['login'];
    $password = $_GET['password'];
    $repeat_password = $_GET['repeat_password'];

    if (($login == null or $login == "") && ($password == null or $password == ""))
        echo "Введите логин и пароль" . "<br>";
    else if ($password !== $repeat_password)
        echo "Пароли не совпадают" . "<br>";
    else if($Database->Registration($login, $password))
        echo "Аккаунт создан" . "<br>";
    else
        echo "Логин уже занят" . "<br>";
}
else if ($mode == 2) {         //Отправка сообщения
    $login = $_GET['login'];
    $password = $_GET['password'];
    $text = $_GET['text'];

    $user_id = $Database->Authorization($login, $password);

    $messages = $Database->LoadChat();

    if($user_id == -1)
        echo "Неверный логин или пароль" . "<br>";
    else if (strlen($text) > 255)
        echo "Длинна сообщения должна быть не больше 255 символов";
    else
        $Database->SaveMassage($user_id, $text);


    echo $twig->render('index.html', array('messages' => $messages));
}





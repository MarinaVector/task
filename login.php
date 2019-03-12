<?php

$email = $_POST['email'];
$password = $_POST['password'];
//проверка данных
foreach($_POST as $input) {
    if(empty($input)) {
        include 'errors.php';
      $errorMessage = 'Поля формы не должны быть пустыми.Вернитесь назад и корректно заполните все поля';
        exit;
    }
}
//подготовка и выполнение запроса к БД
$pdo = new PDO('mysql:host=127.0.0.1;dbname=bd', 'root', '');
$sql = 'SELECT id from users where email=:email AND password=:password';
$statement = $pdo->prepare($sql);
$statement->execute([
	':email'	=>	$email,
	':password'	=>	md5($password)
]);
$user = $statement->fetch(PDO::FETCH_ASSOC);
//Не нашли пользователя
if(!$user) {
    $errorMessage = 'Неправильный логин или пароль';
    include 'errors.php';
    exit;
}
//Нашли пользователя и записываем нужные данные в сессию
session_start();
$_SESSION['user_id'] = $user['id'];
$_SESSION['email'] = $user['email'];
//переадресовываем на создание списка задач
header('Location: /index.php');
exit;
    ?>

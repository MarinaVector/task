<?php
$username = $_POST['username']; 
$email = $_POST['email']; 
$password=$_POST['password']; 

 //удаляем лишние пробелы
    $username = trim($username);
    $password = trim($password);
$email = trim($email);


 // проверяем данные
foreach($_POST as $input) {
  if(empty($input)) {
     $errorMessage = 'Вернитесь назад и корректно заполните все поля';
    include 'errors.php';
        exit;
  }
}

 // подготовка и запрос к бд


$pdo = new PDO('mysql:host=127.0.0.1;dbname=bd', 'root', '');
$sql = 'SELECT id from users where email=:email';
$statement = $pdo->prepare($sql);
$statement->execute([':email' => $email]);
$user = $statement->fetchColumn();
if($user) {
  $errorMessage = 'Такой EMAIL уже существует';
    include 'errors.php';
  exit;
}


$sql = 'INSERT INTO users (username, email, password) VALUES (:username, :email, :password)';
$statement = $pdo->prepare($sql);

//ХЭШ ПАРОЛЯ

$_POST['password'] = md5($_POST['password']);
$result = $statement->execute($_POST);
if(!$result) {
$errorMessage = 'ОШИБКА РЕГИСТРАЦИИ!';
include 'errors.php';
  exit;
  }
  // переадр на авториз
  
  header('Location: /login-form.php'); 
  exit;
  
  

    ?>

<?php

require_once "models/User.php";

$name = $_POST['name'] ?? '';
$surname = $_POST['surname'] ?? '';
$password = $_POST['password'] ?? '';
$phone = $_POST['phone'] ?? '';
$email = $_POST['email'] ?? '';
$sex = $_POST['sex'] ?? '';

$user = new User($name, $surname, $password, $phone, $email, $sex);

$file = 'users.txt';
file_put_contents($file, $user->toJSON() . PHP_EOL, FILE_APPEND);

echo $user->toJSON();

?>

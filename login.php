<?php

require_once 'model/DatabaseManager.php';
require_once 'model/ConnectionDao.php';
require_once 'vendor/autoload.php';

use Dotenv\Dotenv;
use Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: *");

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);


$email = htmlspecialchars($_POST['email']);

$password = htmlspecialchars($_POST['password']);
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

// echo json_encode($email);

$pdo = ConnectionDao::getConnection();

$prepare = $pdo->prepare("select * from users where email = :email");
$prepare->bindParam(':email', $email);
$prepare->execute();
$userFound = $prepare->fetch();

if(!$userFound) {
  http_response_code(401);
}

if(!password_verify($password, $passwordHash)) {
  http_response_code(401);
}

$payload = [
  'exp' => time() + 10,
  'iat' => time(),
  'email' => $email
];

$encode = JWT::encode($payload, $_ENV['KEY'], 'HS256');

echo json_encode($encode);
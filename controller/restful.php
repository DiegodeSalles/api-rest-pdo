<?php

require_once __DIR__ . '/../model/ConnectionDao.php';
require_once __DIR__ . '/../model/DatabaseManager.php';
require_once __DIR__ . '/../model/User.php';
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use Firebase\JWT\JWT;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../model');
$dotenv->load();

function validateUser($data)
{
  $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);

  $user = new User();
  $user->setUsername($data['user']);
  $user->setPassword($data['password']);
  
  

  $pdo = ConnectionDao::getConnection();
  $prepare = $pdo->prepare('SELECT * from users where user = :user and password = :password');
  $prepare->bindParam(':user', $data['user']);
  $prepare->bindParam(':password', $data['password']);
  $prepare->execute();
  $userFound = $prepare->fetch(PDO::FETCH_ASSOC);

  if (!$userFound || !password_verify($user->getPassword(), $passwordHash)) {
    http_response_code(401);
  }

  $payload = [
    'exp' => time() + 10,
    'iat' => time(),
    'name' => $userFound['name'],
    'user' => $userFound['user'],
    'email' => $userFound['email'],
    'logged_in' => true
  ];

  $encode = JWT::encode($payload, $_ENV['KEY'], 'HS256');

  return $encode;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  if (isset($_GET['id'])) {

    getUserById($_GET['id']);
  } else {

    getAllUsers();
  }
} 
else if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $rawData = file_get_contents('php://input');
  $data = json_decode($rawData, true);

  $user = new User();
  $user->setUsername($data['user']);
  // $user->setName($data['name']);
  $user->setPassword($data['password']);
  // $user->setPhone($data['phone']);
  // $user->setEmail($data['email']);

  // insertUser($user);
  echo validateUser($data);
} 
else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

  $rawData = file_get_contents('php://input');
  $data = json_decode($rawData, true);

  $user = new User();
  $user->setId($_GET['id']);
  $user->setUsername($data['user']);
  $user->setName($data['name']);
  $user->setPassword($data['password']);
  $user->setPhone($data['phone']);
  $user->setEmail($data['email']);

  updateUser($user);
} else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

  deleteUser($_GET['id']);
}

function getAllUsers()
{
  try {

    $db = new DatabaseManager();

    http_response_code(200);
    echo json_encode($db->getUsers());
  } catch (Exception $e) {

    http_response_code(500);
    echo json_encode($e);
  }
}

function getUserById($id)
{
  try {

    $db = new DatabaseManager();

    http_response_code(200);
    echo json_encode($db->getUserbyId($id));
  } catch (Exception $e) {

    http_response_code(500);
    echo json_encode($e);
  }
}

function insertUser($user)
{
  try {

    $db = new DatabaseManager();
    $db->insertUser($user);

    http_response_code(200);
    echo json_encode(['message' => 'User created successfully.']);
  } catch (Exception $e) {

    http_response_code(500);
    echo json_encode($e);
  }
}

function deleteUser($id)
{
  try {

    $db = new DatabaseManager();
    $db->deleteUser($id);

    http_response_code(200);
    echo json_encode(['message' => 'User deleted successfully.']);
  } catch (Exception $e) {

    http_response_code(500);
    echo json_encode($e);
  }
}

function updateUser($user)
{
  try {

    $db = new DatabaseManager();
    $db->updateUser($user);

    http_response_code(200);
    echo json_encode(['message' => 'User created successfully.']);
  } catch (Exception $e) {

    http_response_code(500);
    echo json_encode($e);
  }
}

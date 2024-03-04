<?php

require_once __DIR__ . '/../model/DatabaseManager.php';
require_once __DIR__ . '/../model/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  if (isset($_GET['id'])) {

    getUserById($_GET['id']);
  } else {

    getAllUsers();
  }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $rawData = file_get_contents('php://input');
  $data = json_decode($rawData, true);

  $user = new User();
  $user->setUsername($data['user']);
  $user->setName($data['name']);
  $user->setPassword($data['password']);
  $user->setPhone($data['phone']);
  $user->setEmail($data['email']);

  insertUser($user);
} else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

  $rawData = file_get_contents('php://input');
  $data = json_decode($rawData, true);

  $user = new User();
  $user->setUsername($data['user']);
  $user->setName($data['name']);
  $user->setPassword($data['password']);
  $user->setPhone($data['phone']);
  $user->setEmail($data['email']);

  updateUser($_GET['id'], $user);
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

function updateUser($id, $array)
{
  try {

    $db = new DatabaseManager();
    $db->updateUser($id, $array);

    http_response_code(200);
    echo json_encode(['message' => 'User created successfully.']);
  } catch (Exception $e) {

    http_response_code(500);
    echo json_encode($e);
  }
}

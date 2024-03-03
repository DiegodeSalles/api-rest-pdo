<?php

require_once '../DatabaseManager.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  if (isset($_GET['id'])) {
    getUserById($_GET['id']);
  } else {
    getAllUsers();
  }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $rawData = file_get_contents('php://input');
  $data = json_decode($rawData, true);

  if (
    isset($data['user']) && !empty($data['user']) &&
    isset($data['password']) && !empty($data['password']) &&
    isset($data['name']) && !empty($data['name']) &&
    isset($data['phone']) && !empty($data['phone']) &&
    isset($data['email']) && !empty($data['email'])
  ) {
    insertUser($data);
  } else {
    http_response_code(400);
    echo json_encode(['error' => 'Missing or empty required fields.']);
  }
} else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
  if (isset($_GET['id'])) {

    $rawData = file_get_contents('php://input');
    $data = json_decode($rawData, true);
    $id = $_GET['id'];
    if (
      isset($data['password']) && !empty($data['password']) &&
      isset($data['name']) && !empty($data['name']) &&
      isset($data['phone']) && !empty($data['phone']) &&
      isset($data['email']) && !empty($data['email'])
    ) {
      updateUser($id, $data);
    } else {
      http_response_code(400);
      echo json_encode(['error' => 'Missing or empty required fields.']);
    }
  }
} else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
  deleteUser($_GET['id']);
}


function getAllUsers()
{
  try {
    $db = new DatabaseManager();

    echo json_encode($db->getUsers());
  } catch (Exception $e) {
    echo json_encode($e);
  }
}

function getUserById($id)
{
  try {
    $db = new DatabaseManager();

    echo json_encode($db->getUserbyId($id));
  } catch (Exception $e) {
    echo json_encode($e);
  }
}

function insertUser($user)
{
  try {
    $db = new DatabaseManager();
    $db->insertData($user);

    echo json_encode(['message' => 'User created successfully.']);
  } catch (Exception $e) {
    echo json_encode($e);
  }
}

function deleteUser($id)
{
  try {
    $db = new DatabaseManager();
    $db->deleteData($id);
  } catch (Exception $e) {
    echo json_encode($e);
  }
}

function updateUser($id, $array)
{
  try {
    $db = new DatabaseManager();
    $db->updateUser($id, $array);
  } catch (Exception $e) {
    echo json_encode($e);
  }
}

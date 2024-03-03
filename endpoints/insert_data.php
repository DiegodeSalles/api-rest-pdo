<?php

require_once '../DatabaseManager.php';

echo json_encode('teste');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $jsonData = file_get_contents('php://input');
  $data = json_decode($jsonData, true);

  if (
    isset($data['name']) && isset($data['email']) && isset($data['phone']) &&
    !empty($data['name']) && !empty($data['email']) && !empty($data['phone']) &&
    isset($data['user']) && isset($data['password']) && !empty($data['user']) && !empty($data['password'])
  ) {

    $dbManager = new DatabaseManager();
    $dbManager->insertData($data);

    echo json_encode(['message' => 'Data inserted successfully!']);
  } else {

    http_response_code(400);
    echo json_encode(['error' => 'Missing or empty required fields']);
  }
} else {

  http_response_code(405);
  echo json_encode(['error' => 'Method not allowed']);
}

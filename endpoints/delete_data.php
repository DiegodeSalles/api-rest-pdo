<?php

require_once '../DatabaseManager.php';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

  $id = $_GET['id'];
  $db = new DatabaseManager();
  $db->deleteData($id);
  echo json_encode(['message' => 'Data deleted successfully!']);
}

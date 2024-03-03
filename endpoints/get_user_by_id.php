<?php

require_once '../DatabaseManager.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

  $id = $_GET['id'];
  $db = new DatabaseManager();
  echo json_encode($db->getUserbyId($id));
}

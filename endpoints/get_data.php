<?php

require_once '../DatabaseManager.php';

$db = new DatabaseManager();

echo json_encode($db->getUsers());
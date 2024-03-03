<?php

require_once 'ConnectionDao.php';

class DatabaseManager
{

  private $conn;

  public function __construct()
  {
    try {
      $this->conn = ConnectionDao::getConnection();
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
  public function insertData($array)
  {
    try {

      $stmt = $this->conn->prepare('INSERT INTO users (name, email, phone, user, password) VALUES (:name, :email, :phone, :user, :password)');
      $stmt->bindParam(':name', $array['name']);
      $stmt->bindParam(':email', $array['email']);
      $stmt->bindParam(':phone', $array['phone']);
      $stmt->bindParam(':user', $array['user']);
      $stmt->bindParam(':password', $array['password']);

      $stmt->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
    } finally {
      ConnectionDao::closeConnection($this->conn);
    }
  }

  public function deleteData($id)
  {
    try {
      $stmt = $this->conn->prepare('DELETE FROM users WHERE id = :id');
      $stmt->bindParam(':id', $id);

      $stmt->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
    } finally {
      ConnectionDao::closeConnection($this->conn);
    }
  }

  public function getUsers()
  {
    try {
      $stmt = $this->conn->prepare('SELECT * FROM users');
      $stmt->execute();
      $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

      return $data;
    } catch (PDOException $e) {
      echo $e->getMessage();
    } finally {
      ConnectionDao::closeConnection($this->conn);
    }
  }


  public function getUserbyId($id)
  {
    try {
      $stmt = $this->conn->prepare('SELECT * FROM users WHERE id = :id');
      $stmt->bindParam(':id', $id);
      $stmt->execute();
      $data = $stmt->fetch(PDO::FETCH_ASSOC);

      return $data;
    } catch (PDOException $e) {
      echo $e->getMessage();
    } finally {
      ConnectionDao::closeConnection($this->conn);
    }
  }

  public function updateUser($id, $array)
  {
    try {
      $stmt = $this->conn->prepare("UPDATE users SET password=
       :password, name = :name, email = :email, phone = :phone WHERE id = :id");

      $stmt->bindParam(':id', $id);
      $stmt->bindParam(':password', $array['password']);
      $stmt->bindParam(':name', $array['name']);
      $stmt->bindParam(':email', $array['email']);
      $stmt->bindParam(':phone', $array['phone']);

      $stmt->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
    } finally {
      ConnectionDao::closeConnection($this->conn);
    }
  }
}

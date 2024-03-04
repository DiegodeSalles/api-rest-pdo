<?php

require_once 'ConnectionDao.php';
require_once 'User.php';

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

  public function insertUser(User $user)
  {
    try {

      $stmt = $this->conn->prepare('INSERT INTO users (name, email, phone, user, password) VALUES (:name, :email, :phone, :user, :password)');
      $stmt->bindParam(':name', $user->getName());
      $stmt->bindParam(':email', $user->getEmail());
      $stmt->bindParam(':phone', $user->getPhone());
      $stmt->bindParam(':user', $user->getUsername());
      $stmt->bindParam(':password', $user->getPassword());

      $stmt->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
    } finally {
      ConnectionDao::closeConnection($this->conn);
    }
  }

  public function deleteUser($id)
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

  public function updateUser($id, User $user)
  {
    try {
      $stmt = $this->conn->prepare("UPDATE users SET password=
       :password, name = :name, email = :email, phone = :phone WHERE id = :id");

      $stmt->bindParam(':id', $id);
      $stmt->bindParam(':password', $user->getPassword());
      $stmt->bindParam(':name', $user->getName());
      $stmt->bindParam(':email', $user->getEmail());
      $stmt->bindParam(':phone', $user->getPhone());

      $stmt->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
    } finally {
      ConnectionDao::closeConnection($this->conn);
    }
  }
}

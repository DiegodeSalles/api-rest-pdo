<?php

class User
{
  private $id;
  private $username;
  private $password;
  private $name;
  private $email;
  private $phone;

  public function getId()
  {
    return $this->id;
  }

  public function setId($id): self
  {
    $this->id = $id;

    return $this;
  }

  public function getUsername()
  {
    return $this->username;
  }

  public function setUsername($username): self
  {
    $this->username = $username;

    return $this;
  }

  public function getPassword()
  {
    return $this->password;
  }

  public function setPassword($password): self
  {
    $this->password = $password;

    return $this;
  }

  public function getName()
  {
    return $this->name;
  }

  public function setName($name): self
  {
    $this->name = $name;

    return $this;
  }

  public function getEmail()
  {
    return $this->email;
  }

  public function setEmail($email): self
  {
    $this->email = $email;

    return $this;
  }

  public function getPhone()
  {
    return $this->phone;
  }

  public function setPhone($phone): self
  {
    $this->phone = $phone;

    return $this;
  }
}

<?php
  declare(strict_types = 1);

  class User {
    public int $id;
    public string $username;
    public string $firstName;
    public string $lastName;
    public string $email;
    public int $id_department;
    public bool $is_agent;
    public bool $is_admin;

    public function __construct(int $id, string $username, string $firstName, string $lastName, string $email, int $id_department , bool $is_agent, bool $is_admin){
      $this->id = $id;
      $this->username = $username;
      $this->firstName = $firstName;
      $this->lastName = $lastName;
      $this->email = $email;
      $this->id_department = $id_department;
      $this->is_agent = $is_agent;
      $this->is_admin = $is_admin;
    }

    function name() {
      return $this->username;
    }

    function save($db) {
      $stmt = $db->prepare('
        UPDATE User SET firstName = ?, lastName = ?
        WHERE id = ?
      ');

      $stmt->execute(array($this->firstName, $this->lastName, $this->id));
    }
    
    static function getUserWithPassword(PDO $db, string $email, string $password) : ?User {
      $stmt = $db->prepare('
        SELECT id, username, firstName, lastName, email, id_department, is_agent, is_admin
        FROM User 
        WHERE lower(email) = ? AND password = ?
      ');

      $stmt->execute(array(strtolower($email), sha1($password)));
  
      if ($user = $stmt->fetch()) {
        return new User(
          $user['id'],
          $user['username'],
          $user['firstName'],
          $user['lastName'],
          $user['email'],
          $user['id_department'],
          $user['is_agent'],
          $user['is_admin']
        );
      } else return null;
    }

    static function getUser(PDO $db, int $id) : User {
      $stmt = $db->prepare('
        SELECT id, username, firstName, lastName, email, id_department, is_agent, is_admin
        FROM User 
        WHERE id = ?
      ');

      $stmt->execute(array($id));
      $user = $stmt->fetch();
      
      return new User(
        $user['id'],
        $user['username'],
        $user['firstName'],
        $user['lastName'],
        $user['email'],
        $user['id_department'],
        $user['is_agent'],
        $user['is_admin']
      );
    }

  }
?>
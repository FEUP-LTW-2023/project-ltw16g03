<?php
  declare(strict_types = 1);

  class users {
    public int $id;
    public string $username;
    public string $firstName;
    public string $lastName;
    public string $email;
    public bool $is_client;
    public bool $is_agent;
    public bool $is_admin;

    public function __construct(int $id, string $username, string $firstName, string $lastName, string $email, bool $is_client , bool $is_agent, bool $is_admin){
      $this->id = $id;
      $this->username = $username;
      $this->firstName = $firstName;
      $this->lastName = $lastName;
      $this->email = $email;
      $this->is_client = $is_client;
      $this->is_agent = $is_agent;
      $this->is_admin = $is_admin;
    }

    function name() {
      return $this->username;
    }

    function save($db) {
      $stmt = $db->prepare('
        UPDATE users SET firstName = ?, lastName = ?
        WHERE id = ?
      ');

      $stmt->execute(array($this->firstName, $this->lastName, $this->id));
    }
    
    static function getUserWithPassword(PDO $db, string $email, string $password) : ?users {
      $stmt = $db->prepare('
        SELECT id, username, firstName, lastName, email, is_client, is_agent, is_admin
        FROM users 
        WHERE lower(email) = ? AND password = ?
      ');

      $stmt->execute(array(strtolower($email), sha1($password)));
  
      if ($users = $stmt->fetch()) {
        return new users(
          $users['id'],
          $users['username'],
          $users['firstName'],
          $users['lastName'],
          $users['email'],
          $users['is_client'],
          $users['is_agent'],
          $users['is_admin']
        );
      } else return null;
    }

    static function getUser(PDO $db, int $id) : users {
      $stmt = $db->prepare('
        SELECT id, username, firstName, lastName, email, is_client, is_agent, is_admin
        FROM users 
        WHERE id = ?
      ');

      $stmt->execute(array($id));
      $customer = $stmt->fetch();
      
      return new users(
        $users['id'],
        $users['username'],
        $users['firstName'],
        $users['lastName'],
        $users['email'],
        $users['is_client'],
        $users['is_agent'],
        $users['is_admin']
      );
    }

  }
?>
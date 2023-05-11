<?php
  declare(strict_types = 1);

  class Department {
    public int $id;
    public string $name;

    public function __construct(int $id, string $name)
    { 
      $this->id = $id;
      $this->name = $name;
    }

    static function getDepartments(PDO $db, int $count) : array {
      $stmt = $db->prepare('SELECT id, name FROM Department LIMIT ?');
      $stmt->execute(array($count));
  
      $departments = array();
      while ($department = $stmt->fetch()) {
        $departments[] = new Department(
          intval($department['id']),
          $department['name']
        );
      }
  
      return $departments;
    }

    static function getAll(PDO $db){
      $stmt = $db->prepare('
        SELECT id, name
        FROM Department
        ORDER by created_at desc
      ');

      $stmt->execute();
      $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $row;
    }

    static function searchDepartments(PDO $db, string $search, int $count) : array {
      $stmt = $db->prepare('SELECT id, name FROM Department WHERE name LIKE ? LIMIT ?');
      $stmt->execute(array($search . '%', $count));
  
      $departments = array();
      while ($department = $stmt->fetch()) {
        $departments[] = new Department(
          intval($department['id']),
          $department['name']
        );
      }
  
      return $departments;
    }

    static function getDepartment(PDO $db, int $id) : Department {
      $stmt = $db->prepare('SELECT id, name FROM Department WHERE id = ?');
      $stmt->execute(array($id));
  
      $department = $stmt->fetch();
  
      return new Department(
        $department['id'], 
        $department['name']
      );
    }  

    static function create(PDO $db, string $name) : int {

      $sql = "INSERT INTO Department (name) VALUES (:name)";
      $stmt= $db->prepare($sql);
      $stmt->bindValue('name', $name, PDO::PARAM_STR);
      $stmt->execute();
      
      //Return new Department id
      $sql = "SELECT id from Department ORDER BY ID DESC LIMIT 1";
      $stmt= $db->prepare($sql);
      $stmt->execute();
      $id = $stmt->fetch();
      return intval($id['id']);
    }
  }
  
?>
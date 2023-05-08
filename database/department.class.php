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
          $department['id'],
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
          $department['id'],
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

    static function addDepartment(PDO $db, string $name): bool {
      try {
        $stmt = $db->prepare('INSERT INTO Department (name) VALUES (?)');
        $stmt->execute([$name]);
    
        if ($stmt->rowCount() > 0) {
          return true; 
        } else {
          return false; 
        }
      } catch(PDOException $e) {
        return false; 
      }
    }
  }
  
?>
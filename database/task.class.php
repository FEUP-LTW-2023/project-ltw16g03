<?php
  declare(strict_types = 1);

  class Task {
    public int $id;
    public string $title;
    public string $description;
    public bool $is_completed;
    public int $id_user;
    
    public function __construct(int $id, string $title, string $description, bool $is_completed, int $id_user)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->is_completed = $is_completed;
        $this->id_user = $id_user;
    }

    /*function edit($db) {
      $stmt = $db->prepare('
        UPDATE Ticket SET id_department = ?, title = ?, description = ?, ticket_status = ?, updated_at = ?
        WHERE id = ?
      ');

      $stmt->execute(array($this->id_department, $this->title, $this->description, $this->ticket_status, $this->updated_at, $this->id));
    }*/

    static function getTasksbyUser(PDO $db, int $id_user){
      $stmt = $db->prepare('
        SELECT id, title, description, is_completed
        FROM Task
        WHERE id_user = ?
        ORDER by is_completed, id desc
      ');

      $stmt->execute(array($id_user));
      $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $row;
    }

    static function create(PDO $db, string $title, string $description, int $id_user) : int {

      $sql = "INSERT INTO Task (title, description, id_user) VALUES (:title, :description, :id_user)";
      $stmt= $db->prepare($sql);
      $stmt->bindValue('title', $title, PDO::PARAM_STR);
      $stmt->bindValue('description', $description, PDO::PARAM_STR);
      $stmt->bindValue('id_user', $id_user, PDO::PARAM_INT);
      $stmt->execute();
      
      //Return new task id
      $sql = "SELECT id from Task ORDER BY ID DESC LIMIT 1";
      $stmt= $db->prepare($sql);
      $stmt->execute();
      $id = $stmt->fetch();
      return intval($id['id']);
    }
  
  }
?>
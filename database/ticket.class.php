<?php
  declare(strict_types = 1);

  class Ticket {
    public int $id;
    public string $title;
    public string $descriptions;
    public int $ticket_status;
    public datetime $created_at;
    public datetime $updated_at;
    public string $id_department;
    
    public function __construct(int $id, string $id_department, string $title, string $descriptions, string $ticket_status, datetime $created_at, datetime $updated_at)
    {
        $this->id = $id;
        $this->id_department = $id_department;
        $this->title = $title;
        $this->descriptions = $descriptions;
        $this->ticket_status = $ticket_status;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    function edit($db) {
      $stmt = $db->prepare('
        UPDATE Ticket SET id_department = ?, title = ?, description = ?, ticket_status = ?, updated_at = ?
        WHERE id = ?
      ');

      $stmt->execute(array($this->id_department, $this->title, $this->descriptions, $this->ticket_status, $this->updated_at, $this->id));
    }
    
    
    static function get(PDO $db, int $id) : Ticket {
      $stmt = $db->prepare('
        SELECT id, id_department, title, description, ticket_status, created_at, updated_at, user_id
        FROM Ticket 
        WHERE id = ?
      ');

      $stmt->execute(array($id));
      $ticket = $stmt->fetch();
      
      return new Ticket(
        $ticket['id'],
        $ticket['id_department'],
        $ticket['title'],
        $ticket['description'],
        $ticket['ticket_status'],
        $ticket['created_at'],
        $ticket['udpated_at'],
        $ticket['user_id'],
      );
    }

    static function getAll(PDO $db){
      $stmt = $db->prepare('
        SELECT id, title, descriptions, id_department
        FROM Ticket 
        ORDER by created_at desc
      ');

      $stmt->execute();
      $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $row;
    }

    static function getTicketsbyUser(PDO $db, int $user_id) : Ticket {
      $stmt = $db->prepare('
        SELECT id, id_department, title, description, ticket_status, created_at, updated_at, user_id
        FROM Ticket 
        WHERE user_id = ?
      ');

      $stmt->execute(array($user_id));
      $ticket = $stmt->fetch();
      
      return new Ticket(
        $ticket['id'],
        $ticket['id_department'],
        $ticket['title'],
        $ticket['description'],
        $ticket['ticket_status'],
        $ticket['created_at'],
        $ticket['udpated_at'],
        $ticket['user_id'],
      );
    }

    static function delete(PDO $db, int $id) {
      $stmt = $db->prepare('
        DELETE 
        FROM Ticket 
        WHERE id = ?
      ');

      $stmt->execute(array($id));
    }

    static function create(PDO $db, string $id_department, string $title, string $descriptions) : int {

      $sql = "INSERT INTO Ticket (title, descriptions, id_department) VALUES (:title, :descriptions, :id_department)";
      $stmt= $db->prepare($sql);
      $stmt->bindValue('title', $title, PDO::PARAM_STR);
      $stmt->bindValue('descriptions', $descriptions, PDO::PARAM_STR);
      $stmt->bindValue('id_department', $id_department, PDO::PARAM_INT);
      $stmt->execute();
      
      //checkar nome ticket sempre diferente
      
      //Return new ticket id
      $sql = "SELECT id from Ticket ORDER BY ID DESC LIMIT 1";
      $stmt= $db->prepare($sql);
      $stmt->execute();
      $id = $stmt->fetch();
      return intval($id['id']);
    }
  }
?>
<?php
  declare(strict_types = 1);

  class Ticket {
    public int $id;
    public string $title;
    public string $description;
    public string $ticket_status;
    public datetime $created_at;
    public datetime $updated_at;
    public int $id_user;
    public int $id_agent;
    public int $id_department;
    
    public function __construct(int $id, string $title, string $description, string $ticket_status, datetime $created_at, datetime $updated_at, int $id_user, int $id_agent, int $id_department)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->ticket_status = $ticket_status;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->id_user = $id_user;
        $this->id_agent = $id_agent;
        $this->id_department = $id_department;
    }

    function edit($db) {
      $stmt = $db->prepare('
        UPDATE Ticket SET id_department = ?, title = ?, description = ?, ticket_status = ?, updated_at = ?
        WHERE id = ?
      ');

      $stmt->execute(array($this->id_department, $this->title, $this->description, $this->ticket_status, $this->updated_at, $this->id));
    }
    
    
    static function get(int $id) : Ticket {
      global $dbh;
      $stmt = $dbh->prepare('
        SELECT id, title, description, ticket_status, created_at, updated_at, id_user, id_agent, id_department
        FROM Ticket 
        WHERE id = ?
      ');

      $stmt->execute(array($id));
      $ticket = $stmt->fetch();
      
      return new Ticket(
        $ticket['id'],
        $ticket['title'],
        $ticket['description'],
        $ticket['ticket_status'],
        $ticket['created_at'],
        $ticket['udpated_at'],
        $ticket['id_user'],
        $ticket['id_agent'],
        $ticket['id_department']
      );
    }

    static function getAll(PDO $db){
      $stmt = $db->prepare('
        SELECT id, title, description, id_department
        FROM Ticket 
        ORDER by updated_at desc
      ');

      $stmt->execute();
      $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $row;
    }

    static function getTicketsbyUser(PDO $db, int $id_user){
      $stmt = $db->prepare('
        SELECT id, title, description, id_department
        FROM Ticket 
        WHERE id_user = ?
        ORDER by updated_at desc
      ');

      $stmt->execute(array($id_user));
      $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $row;
    }

    static function delete(PDO $db, int $id) {
      $stmt = $db->prepare('
        DELETE 
        FROM Ticket 
        WHERE id = ?
      ');

      $stmt->execute(array($id));
    }

    static function create(PDO $db, int $id_department, string $title, string $description, int $id_user) : int {

      $sql = "INSERT INTO Ticket (title, description, id_department, id_user) VALUES (:title, :description, :id_department, :id_user)";
      $stmt= $db->prepare($sql);
      $stmt->bindValue('title', $title, PDO::PARAM_STR);
      $stmt->bindValue('description', $description, PDO::PARAM_STR);
      $stmt->bindValue('id_department', $id_department, PDO::PARAM_INT);
      $stmt->bindValue('id_user', $id_user, PDO::PARAM_INT);
      $stmt->execute();
      
      //checkar nome ticket sempre diferente
      
      //Return new ticket id
      $sql = "SELECT id from Ticket ORDER BY ID DESC LIMIT 1";
      $stmt= $db->prepare($sql);
      $stmt->execute();
      $id = $stmt->fetch();
      return intval($id['id']);
    }

    static function getTicketsByHashtag(PDO $db, string $hashtag) : array {
      $stmt = $db->prepare('SELECT t.id, t.title, t.descriptions, t.ticket_status, t.created_at, t.updated_at, t.id_user, t.id_agent, t.id_department
                            FROM Ticket AS t
                            INNER JOIN Ticket_Hashtag AS th ON t.id = th.id_ticket
                            INNER JOIN Hashtag AS h ON th.id_hashtag = h.id
                            WHERE h.tag = ?');
      $stmt->execute(array($hashtag));
    
      $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
      return $tickets;
  }
  
  }
?>
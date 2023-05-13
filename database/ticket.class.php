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
    public string $feedback;
    public string $client_answer;
    
    public function __construct(int $id, string $title, string $description, string $ticket_status, datetime $created_at, datetime $updated_at, int $id_user, int $id_agent, int $id_department, string $feedback, string $client_answer)
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
        $this->feedback = $feedback;
        $this->client_answer = $client_answer;
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
        SELECT id, title, description, ticket_status, created_at, updated_at, id_user, id_agent, id_department, feedback, client_answer
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
        $ticket['id_department'],
        $ticket['feedback'],
        $ticket['client_answer']
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

    static function getTicketsbyDepartment(PDO $db, int $id_department) {
      $stmt = $db->prepare('
        SELECT id, title, description
        FROM Ticket 
        WHERE id_department = ?
        ORDER by updated_at desc
      ');

      $stmt->execute(array($id_department));
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

    static function create(PDO $db, string $id_department, string $title, string $description, int $id_user) : int {

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

    static function getTicket(int $id) {
      global $dbh;
    try {
      $stmt = $dbh->prepare('SELECT id, title, description, ticket_status, id_department, id_agent, id_user, feedback, client_answer FROM Ticket WHERE id = ?');
      $stmt->execute(array($id));
      return $stmt->fetch();
    
    }catch(PDOException $e) {
      return null;
    }
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
  
  static function updateTicketAgent($ticketId, $agentId) {
    $userAgent = isAgent(getUserID());

    if ($userAgent) {
        try {
            global $dbh;

            // Check if the agent ID exists in the User table
            $agentExistsStmt = $dbh->prepare('SELECT COUNT(*) FROM User WHERE id = :agentId');
            $agentExistsStmt->bindParam(':agentId', $agentId, PDO::PARAM_INT);
            $agentExistsStmt->execute();
            $agentExists = $agentExistsStmt->fetchColumn();

            if ($agentExists) {
                // Prepare and execute the update statement
                $stmt = $dbh->prepare('UPDATE Ticket SET id_agent = :agentId WHERE id = :ticketId');
                $stmt->bindParam(':agentId', $agentId, PDO::PARAM_INT);
                $stmt->bindParam(':ticketId', $ticketId, PDO::PARAM_INT);
                $stmt->execute();

                // Check if the update was successful
                if ($stmt->rowCount() > 0) {
                    return true; // Ticket agent updated successfully
                } else {
                    return false; // No ticket found with the given ID
                }
            } else {
                return false; // Agent ID does not exist in the User table
            }
        } catch (PDOException $e) {
            echo 'Error updating ticket agent: ' . $e->getMessage();
            return false; // An error occurred while updating the ticket agent
        }
    } else {
        echo 'Only agents can update ticket agents.';
        return false; // User is not an agent
    }
}

static function updateTicketDepartment($ticketId, $newDepartmentId) {
  $userAgent = isAgent(getUserID());

  if ($userAgent) {
      try {
          global $dbh;

          // Prepare and execute the update statement
          $stmt = $dbh->prepare('UPDATE Ticket SET id_department = :newDepartmentId WHERE id = :ticketId');
          $stmt->bindParam(':newDepartmentId', $newDepartmentId, PDO::PARAM_INT);
          $stmt->bindParam(':ticketId', $ticketId, PDO::PARAM_INT);
          $stmt->execute();

          // Check if the update was successful
          if ($stmt->rowCount() > 0) {
              return true; // Ticket department updated successfully
          } else {
              return false; // No ticket found with the given ID
          }
      } catch (PDOException $e) {
          echo 'Error updating ticket department: ' . $e->getMessage();
          return false; // An error occurred while updating the ticket department
      }
  } else {
      echo 'Only agents can update ticket departments.';
      return false; // User is not an agent
  }
}

  }
?>
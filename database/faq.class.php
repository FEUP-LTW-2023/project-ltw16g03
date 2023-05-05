<?php
  declare(strict_types = 1);

  class Faq {
    public int $id;
    public string $title;
    public string $description;
    
    public function __construct(int $id, string $title, string $description)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
    }

    static function getAll(PDO $db){
      $stmt = $db->prepare('
        SELECT id, title, description
        FROM Faq 
        ORDER by id asc
      ');

      $stmt->execute();
      $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $row;
    }
  }
?>
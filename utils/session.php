<?php
  class Session {
    private array $messages;

    public function __construct() {
      session_start();

      $this->messages = isset($_SESSION['messages']) ? $_SESSION['messages'] : array();
      unset($_SESSION['messages']);
    }

    public function isLoggedIn() : bool {
      return isset($_SESSION['id']);    
    }

    public function logout() {
      session_destroy();
    }

    public function getId() : ?int {
      return isset($_SESSION['id']) ? $_SESSION['id'] : null;    
    }

    public function getName() : ?string {
      return isset($_SESSION['name']) ? $_SESSION['name'] : null;
    }

    public function isAgent(PDO $db, int $id) : bool {
      $stmt = $db->prepare('SELECT is_agent FROM users WHERE id = :id');
      $stmt->execute(array('id' => $id));
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      return $result['is_agent'] ? true : false;
    }

    public function isAdmin(PDO $db, int $id) : bool {
      $stmt = $db->prepare('SELECT is_admin FROM users WHERE id = :id');
      $stmt->execute(array('id' => $id));
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      return $result['is_admin'] ? true : false;
    }

    public function setId(int $id) {
      $_SESSION['id'] = $id;
    }

    public function setName(string $name) {
      $_SESSION['name'] = $name;
    }

    public function addMessage(string $type, string $text) {
      $_SESSION['messages'][] = array('type' => $type, 'text' => $text);
    }

    public function getMessages() {
      return $this->messages;
    }
  }
?>
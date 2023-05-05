<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/ticket.class.php');

  $db = getDatabaseConnection();

  $ticket_id = Ticket::create($db, $_POST['department'], $_POST['name'], $_POST['description']);

  if ($ticket_id) {
    $session->addMessage('success', 'Ticket successful!');
    header("Location: ../pages/ticketpage.php?id=$ticket_id");
  } else {
    $session->addMessage('error', 'Wrong password!');
    header('Location: ../ticketpage.php');
  }

?>
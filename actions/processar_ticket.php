<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/init.php');

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/ticket.class.php');


  $ticket_id = Ticket::create($dbh, $_POST['department'], $_POST['name'], $_POST['description']);

  if ($ticket_id) {
    $session->addMessage('success', 'Ticket successful!');
    header("Location: ../pages/ticketpage.php?id=$ticket_id");
  } else {
    $session->addMessage('error', 'Wrong password!');
    header('Location: ../ticketpage.php');
  }

?>
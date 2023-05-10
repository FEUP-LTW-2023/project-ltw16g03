<?php

    require_once(__DIR__ . '/../templates/header.tpl.php');
    require_once(__DIR__ . '/../templates/footer.tpl.php');
    include_once("../database/ticket.class.php");

    $_SESSION['ticketinfo'] = Ticket::getTicket(intval($_GET['id']));

    drawHeader();
?>

<h1><?php echo htmlentities($_SESSION['ticketinfo']['title']) ?></h1>

<label>- Description:</label>
<h3><?php echo htmlentities($_SESSION['ticketinfo']['description']) ?></h3>

<label>- Ticket Status:</label>
<h3><?php echo htmlentities($_SESSION['ticketinfo']['ticket_status']) ?></h3>


<?php
    drawFooter();
?>
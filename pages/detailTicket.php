<?php

    require_once(__DIR__ . '/../templates/header.tpl.php');
    require_once(__DIR__ . '/../templates/footer.tpl.php');
    include_once("../database/ticket.class.php");
    include_once("../database/department.class.php");
    include_once("../database/user.class.php");

    $_SESSION['ticketinfo'] = Ticket::getTicket(intval($_GET['id']));
    $depart = Department::getName($_SESSION['ticketinfo']['id_department']);
    $us = getUserna($_SESSION['ticketinfo']['id_user']);
    $ag = getUserna($_SESSION['ticketinfo']['id_agent']);

    drawHeader();
?>

<h1><?php echo htmlentities($_SESSION['ticketinfo']['title']) ?></h1>

<label>- Description:</label>
<h3><?php echo htmlentities($_SESSION['ticketinfo']['description']) ?></h3>

<label>- Ticket Status:</label>
<h3><?php echo htmlentities($_SESSION['ticketinfo']['ticket_status']) ?></h3>

<label>- Department:</label>
<h3><?php echo htmlentities($depart) ?></h3>

<label>- Agent working on ticket:</label>
<h3><?php 
if($ag == null){
    echo htmlentities("This ticket has no agent working on it");
}else{
    echo htmlentities($ag);
}
?></h3>

<label>- Ticket created by:</label>
<h3><?php echo htmlentities($us) ?></h3>


<?php
    drawFooter();
?>
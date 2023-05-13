<?php
require_once(__DIR__ . '/../utils/init.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../database/ticket.class.php');

$ticketId = $_POST['ticketId'];
$userId = getUserID();
$assig = 'Assigned';

// Call the updateTicketAgent function
$result = Ticket::updateTicketAgent($ticketId, $userId, $assig);

if ($result) {
    echo 'success';
} else {
    echo 'failure';
}
?>

<?php
require_once(__DIR__ . '/../utils/init.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');

function updateTicketDepartment($ticketId, $newDepartmentId) {
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
?>

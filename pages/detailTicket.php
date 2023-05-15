<?php

require_once(__DIR__ . '/../templates/header.tpl.php');
require_once(__DIR__ . '/../templates/footer.tpl.php');
include_once("../database/ticket.class.php");
include_once("../database/department.class.php");
include_once("../database/user.class.php");
include_once("../database/reply.class.php");

$_SESSION['ticketinfo'] = Ticket::getTicket(intval($_GET['id']));
$depart = Department::getName($_SESSION['ticketinfo']['id_department']);
$replies = Reply::getRepliesByTicket($dbh, $_SESSION['ticketinfo']['id']);
$us = getUserna($_SESSION['ticketinfo']['id_user']);
$ag = getUserna($_SESSION['ticketinfo']['id_agent']);

$ticketId = $_SESSION['ticketinfo']['id'];
$hashtags = Ticket::getTicketHashtags($dbh, $ticketId);


drawHeader();

?>

<h1><?php echo htmlentities($_SESSION['ticketinfo']['title']) ?></h1>

<h2>Ticket Information</h2>
<ul>
    <li>Client: <?php echo htmlentities($us) ?></li>
    <li>Status: <?php echo htmlentities($_SESSION['ticketinfo']['ticket_status']) ?></li>
    <li>Department: <?php echo htmlentities($depart) ?></li>
    <li>Assigned to: <?php echo ($ag == null) ? htmlentities("This ticket has no agent working on it") : htmlentities($ag); ?></li>
</ul>

<label>- Ticket Status:</label>
<h3><?php echo htmlentities($_SESSION['ticketinfo']['ticket_status']) ?></h3>

<label>- Department:</label>
<h3><?php echo htmlentities($depart) ?></h3>

<label>- Hashtags:</label>
<?php foreach ($hashtags as $hashtag): ?>
    <span class="hashtag"><?php echo htmlentities($hashtag); ?></span>
<?php endforeach; ?><br>


<label>- Agent working on ticket:</label>
<h3><?php 
if ($ag == null) {
    echo htmlentities("This ticket has no agent working on it");
} else {
    echo htmlentities($ag);
}
?></h3>

<label>- Ticket created by:</label>
<h3><?php echo htmlentities($us) ?></h3>

<label>- Agent feedback:</label>
<h3><?php 
if ($ag == null) {
    echo htmlentities("This ticket has no agent so there is no feedback");
} else if($_SESSION['ticketinfo']['feedback'] == null){
    echo htmlentities("This ticket's agent didn't give a feedback yet");
} else{
    echo htmlentities($_SESSION['ticketinfo']['feedback']);
}
?></h3>

<label>- Client answer to agent's feedback:</label>
<h3><?php 
if ($ag == null) {
    echo htmlentities("This ticket has no agent so there is no feedback and no answer from the client");
} else if($_SESSION['ticketinfo']['feedback'] == null){
    echo htmlentities("This ticket's agent didn't give a feedback so there is no answer from the client");
} else if ($_SESSION['ticketinfo']['client_answer'] == null){
    echo htmlentities("This ticket's client didn't give an answer to the agent's feedback yet");
} else{
    echo htmlentities($_SESSION['ticketinfo']['client_answer']);
}
?></h3>

<?php
// Check if the ticket has no assigned agent and the user is an agent
if ($ag == null && isAgent(getUserID())) {
    echo '<button onclick="assignTicket()">Assign Ticket</button>';
}

if ($_SESSION['ticketinfo']['id_agent'] == getUserID() && $_SESSION['ticketinfo']['ticket_status'] != 'Closed') {
    // Display the dropdown list of departments
    $departments = Department::getAll($dbh);

    echo '<label>Change ticket department:</label>';
    echo '<select id="departmentSelect">';
    foreach ($departments as $department) {
        echo '<option value="' . $department['id'] . '">' . $department['name'] . '</option>';
    }
    echo '</select>';
    echo '<button onclick=updateDepartment()>Change Department</button>';

}
?>
<br>
<?php
if ($_SESSION['ticketinfo']['id_agent'] == getUserID() && $_SESSION['ticketinfo']['ticket_status'] != 'Closed') {
    echo '<button onclick="closeTicket()">Close this Ticket</button><hr />';
}else if($_SESSION['ticketinfo']['id_agent'] == getUserID() && $_SESSION['ticketinfo']['ticket_status'] == 'Closed'){
    echo '<button onclick="reopenTicket()">Reopen this Ticket</button><hr />';
}
?>
<h2>Ticket Details</h2>

<div style="padding: 20px; background: #eee; border: 1px solid #ccc; margin-bottom:10px;">
<h3 style="margin-top: 0"><?php echo htmlentities($us); ?> <span style="font-style: italic; font-size: 10px; display:inline-block"><?php echo htmlentities($_SESSION['ticketinfo']['created_at']) ?></span></h3>
<?php echo htmlentities($_SESSION['ticketinfo']['description']) ?>
</div>

<?php

if($replies) {
    foreach($replies as $reply) {
        ?>

        <div style="padding: 20px; background: <?php echo (getUserna($reply['id_user']) == $ag) ? '#fff' : '#eee'; ?>; border: 1px solid #ccc; margin-bottom:10px;">
        <h3 style="margin-top: 0"><?php echo getUserna($reply['id_user']); ?> <span style="font-style: italic; font-size: 10px; display:inline-block"><?php echo htmlentities($reply['created_at']) ?>
</span></h3>
        <?php echo htmlentities($reply['content']) ?>
        </div>

        <?php
    }
} else {
    ?>
    <h4>No replies yet.</h4c>
    <?php
}

?>



<?php
if($_SESSION['userID'] == $_SESSION['ticketinfo']['id_agent'] || $_SESSION['userID'] == $_SESSION['ticketinfo']['id_user']):
    if($_SESSION['ticketinfo']['ticket_status'] != 'Closed'):
?>

    <h2>Reply to Ticket</h2>
    <form>
    <textarea id="reply" style="width: 100%; height: 100px"></textarea>
    <input type="submit" value="Reply to Client" />
    </form>

<?php
    endif;
endif;
?>


<script>
    function assignTicket() {
        // Call the updateTicketAgent function via an AJAX request
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../actions/action_update_ticket_agent.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = xhr.responseText;
                if (response === 'success') {
                    // Reload the page without changing the URL
                    window.location.reload(false);
                } else {
                    alert('Failed to assign ticket.');
                }
            }
        };
        xhr.send('ticketId=<?php echo $_GET['id']; ?>');
    }

    function closeTicket() {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../actions/action_close_ticket_status.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = xhr.responseText;
                if (response === 'success') {
                    // Reload the page without changing the URL
                    window.location.reload(false);
                } else {
                    alert('Failed to update ticket status.');
                }
            }
        };
        xhr.send('ticketId=<?php echo $_GET['id']; ?>');
    }

    function reopenTicket() {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../actions/action_reopen_ticket_status.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = xhr.responseText;
                if (response === 'success') {
                    // Reload the page without changing the URL
                    window.location.reload(false);
                } else {
                    alert('Failed to update ticket status.');
                }
            }
        };
        xhr.send('ticketId=<?php echo $_GET['id']; ?>');
    }
    
    function updateDepartment() {
        var departmentId = document.getElementById('departmentSelect').value;
        var ticketId = <?php echo $_GET['id']; ?>;

        // Call the updateTicketDepartment function via an AJAX request
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../actions/action_update_ticket_department.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = xhr.responseText;
                window.location.reload(false);
            }
        };
        xhr.send('ticketId=' + ticketId + '&newDepartmentId=' + departmentId);
    }

    // Attach the event listener to the button
    document.getElementById('changeDepartmentBtn').addEventListener('click', updateDepartment);
</script>


<?php
drawFooter();
?>

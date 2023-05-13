<?php

    require_once(__DIR__ . '/../templates/header.tpl.php');
    require_once(__DIR__ . '/../templates/footer.tpl.php');
    include_once("../database/user.class.php");
    include_once("../database/department.class.php");

    $_SESSION['userinfo'] = getUserAdmin(intval($_GET['id']));
    $depart = Department::getName($_SESSION['userinfo']['id_department']);

    drawHeader();
?>

<h1>Profile of <?php echo htmlentities($_SESSION['userinfo']['username']) ?></h1>

<label>- First Name:</label>
<h3><?php echo htmlentities($_SESSION['userinfo']['firstName']) ?></h3>
<label>- Last Name:</label>
<h3><?php echo htmlentities($_SESSION['userinfo']['lastName']) ?></h3>
<label>- Username:</label>
<h3><?php echo htmlentities($_SESSION['userinfo']['username']) ?></h3>
<label>- Email:</label>
<h3><?php echo htmlentities($_SESSION['userinfo']['email']) ?></h3>
<label>- Department:</label>
<?php
if(($_SESSION['userinfo']['is_agent'] == true || $_SESSION['userinfo']['is_admin'] == true) && $_SESSION['userinfo']['id_department'] != null){
?>
<h3><?php echo htmlentities($depart) ?>
<br>
<br>
<?php
if ($_SESSION['userinfo']['is_agent'] == true || $_SESSION['userinfo']['is_admin'] == true) {
    // Display the dropdown list of departments
    $departments = Department::getAll($dbh);

    echo '<label>Change user department:</label>';
    echo '<select id="departmentSelect">';
    foreach ($departments as $department) {
        echo '<option value="' . $department['id'] . '">' . $department['name'] . '</option>';
    }
    echo '</select>';
    echo '<button onclick=updateDepartment()>Change Department</button>';

}
?>
</h3>
<?php }else if (($_SESSION['userinfo']['is_agent'] == true || $_SESSION['userinfo']['is_admin'] == true) && $_SESSION['userinfo']['id_department'] == null){?>
<h3>
<?php 
echo htmlentities("This user doesnt have a department") 
?></h3>
<?php }else{?>
<h3>
<?php 
echo htmlentities("This user is not an agent or admin to have a department") 
?></h3>
<?php }?>
<label>- Agent:</label>
<h3>
<?php 
if($_SESSION['userinfo']['is_agent']==true){
    echo htmlentities("This user is an agent");
}else{
    echo htmlentities("This user is not an agent");
}
?></h3>
<label>- Admin:</label>
<h3><?php if($_SESSION['userinfo']['is_admin']==true){
    echo htmlentities("This user is an admin");
}else{
    echo htmlentities("This user is not an admin");
}
?></h3>

<script>
     
    function updateDepartment() {
        var departmentId = document.getElementById('departmentSelect').value;
        var userId = <?php echo $_GET['id']; ?>;

        // Call the updateTicketDepartment function via an AJAX request
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../actions/action_update_user_department.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = xhr.responseText;
                window.location.reload(false);
            }
        };
        xhr.send('userId=' + userId + '&newDepartmentId=' + departmentId);
    }

    // Attach the event listener to the button
    document.getElementById('changeDepartmentBtn').addEventListener('click', updateDepartment);
</script>

<?php
    drawFooter();
?>
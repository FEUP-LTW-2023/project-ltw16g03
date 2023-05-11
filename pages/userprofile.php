<?php

    require_once(__DIR__ . '/../templates/header.tpl.php');
    require_once(__DIR__ . '/../templates/footer.tpl.php');
    include_once("../database/user.class.php");
    include_once("../database/department.class.php");

    $_SESSION['userinfo'] = getUserAdmin(intval($_GET['id']));
    $depart = Department::getName($_SESSION['userinfo']['id_department']);

    drawHeader();
?>

<h1>Profile of <?php echo htmlentities($_SESSION['userinfo']['username']) ?> <a href="../pages/editprofileAdmin.php?id=<?=$_SESSION['userinfo']['id']?>" class="button">Edit Profile</a></h1>

<label>- First Name:</label>
<h3><?php echo htmlentities($_SESSION['userinfo']['firstName']) ?></h3>
<label>- Last Name:</label>
<h3><?php echo htmlentities($_SESSION['userinfo']['lastName']) ?></h3>
<label>- Username:</label>
<h3><?php echo htmlentities($_SESSION['userinfo']['username']) ?></h3>
<label>- Email:</label>
<h3><?php echo htmlentities($_SESSION['userinfo']['email']) ?></h3>
<label>- Department:</label>
<h3><?php echo htmlentities($depart) ?></h3>
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

<?php
    drawFooter();
?>
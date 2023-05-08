<?php
    include_once(__DIR__.'/../includes/init.php');
    require_once(__DIR__ . '/../templates/header.tpl.php');
    require_once(__DIR__ . '/../templates/footer.tpl.php');
    include_once("../database/user.class.php");

    $_SESSION['userinfo'] = getUser($_SESSION['username']);
    drawHeader();
?>

<h1>Profile of <?php echo htmlentities($_SESSION['userinfo']['username']) ?></h1> <a href="/pages/edit_profile.php"><button id="edit_profile">Edit Profile</button></a>

<label>- First Name:</label>
<h3><?php echo htmlentities($_SESSION['userinfo']['firstName']) ?></h3>
<label>- Last Name:</label>
<h3><?php echo htmlentities($_SESSION['userinfo']['lastName']) ?></h3>
<label>- Username:</label>
<h3><?php echo htmlentities($_SESSION['userinfo']['username']) ?></h3>
<label>- Email:</label>
<h3><?php echo htmlentities($_SESSION['userinfo']['email']) ?></h3>

<?php
    drawFooter();
?>
<?php
    include_once(__DIR__.'../utils/init.php');
    require_once(__DIR__ . '/../templates/header.tpl.php');
    require_once(__DIR__ . '/../templates/footer.tpl.php');
    include_once("../database/user.class.php");

    $_SESSION['userinfo'] = getUserAdmin(intval($_GET['id']));
    drawHeader();
?>

<h1>Personal Information</h1>
<div class="content">
    <div id="account">
        <div id="fields">
            <form action="../actions/action_update_user_admin.php" method="post" class="register_form">
                <label>Department</label>
                <select name="department" id="department" required>
                    <?php
                    require_once(__DIR__ . '/../actions/getAll_departments.php');
                    for($i = 0; $i < count($departments); $i++) {
                    ?>
                        <option value=<?=$departments[$i]['id']?>> <?=$departments[$i]['name']?></option>
                    <?php } ?> 
                </select>
                <input name="id_department" class="w3-input w3-border" type="text" placeholder="Department" value="<?php 
                $depart = Department::getName($_SESSION['userinfo']['id_department']);
                echo htmlentities($depart) ?>" required="required">
                <label>Agent</label>
                <input name="is_agent" class="w3-input w3-border" type="text" placeholder="is_agent" value="<?php echo htmlentities($_SESSION['userinfo']['is_agent']) ?>" required="required">
                <label>Admin</label>
                <input name="is_admin" class="w3-input w3-border" type="text" placeholder="is_admin" value="<?php echo htmlentities($_SESSION['userinfo']['is_admin']) ?>" required="required">           
                <input type="submit" name="Submit" value="Update">
            </form>
        </div>
    </div>
</div>

<?php
    drawFooter();
?>
<?php

  require_once(__DIR__ . '/../utils/init.php');

  require_once(__DIR__ . '/../database/connection.db.php');

  require_once(__DIR__ . '/../database/department.class.php');

  require_once(__DIR__ . '/../templates/header.tpl.php');
  require_once(__DIR__ . '/../templates/footer.tpl.php');
  require_once(__DIR__ . '/../templates/department.tpl.php');
  require_once(__DIR__ . '/../database/user.class.php');

  $isADMIN = isAdmin(getUserID());
 
  $departments = Department::getDepartments($dbh, 14);

  drawHeader();
  drawDepartments($departments, $isADMIN);
  drawFooter();
?>
<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');

  require_once(__DIR__ . '/../database/department.class.php');

  require_once(__DIR__ . '/../templates/header.tpl.php');
  require_once(__DIR__ . '/../templates/footer.tpl.php');
  require_once(__DIR__ . '/../templates/department.tpl.php');

  $db = getDatabaseConnection();

  $departments = Department::getDepartments($db, 8);

  drawHeader($session);
  drawDepartments($departments);
  drawFooter();
?>
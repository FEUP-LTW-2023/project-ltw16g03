<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/department.class.php');

  $db = getDatabaseConnection();

  $departments = Department::searchDepartments($db, $_GET['search'], 8);

  echo json_encode($departments);
?>
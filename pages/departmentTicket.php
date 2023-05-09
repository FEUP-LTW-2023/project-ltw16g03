<?php

  require_once(__DIR__ . '/../utils/init.php');

  require_once(__DIR__ . '/../database/connection.db.php');

  require_once(__DIR__ . '/../database/ticket.class.php');
  require_once(__DIR__ . '/../database/department.class.php');

  require_once(__DIR__ . '/../templates/header.tpl.php');
  require_once(__DIR__ . '/../templates/footer.tpl.php');
  require_once(__DIR__ . '/../templates/department.tpl.php');


  $department = Department::getDepartment($dbh, intval($_GET['id']));
  $tickets = Ticket::getTicketsbyDepartment($dbh, intval($_GET['id']));

  drawHeader();
  drawDepartment($department, $tickets);
  drawFooter();
?>
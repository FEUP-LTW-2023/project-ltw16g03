<?php

//declare(strict_types = 1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/faq.class.php');

$db = getDatabaseConnection();

$faqs = Faq::getAll($db);

?>
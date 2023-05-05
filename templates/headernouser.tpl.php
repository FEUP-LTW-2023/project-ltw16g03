<?php 
  declare(strict_types = 1); 

  require_once(__DIR__ . '/../utils/session.php');
?>

<?php function drawHeader() { ?>
    <!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>HelpDesk - Trouble Tickets</title>
        <link rel="stylesheet" href="../css/ticketpage.css">
        <link rel="stylesheet" href="../css/common.css"> 
        <link rel="stylesheet" href="../css/novo_ticket.css"> 
        <link rel="stylesheet" href="../css/login.css"> 
        <link rel="stylesheet" href="../css/register.css">
        <script src="../javascript/script.js" defer></script>
    </head>
    <body>
        <header>
            <h1>HelpDesk</h1>
        </header>
        <main>
<?php } ?>
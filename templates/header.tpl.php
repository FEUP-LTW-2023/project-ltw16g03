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
    </head>
    <body>
        <header>
            <h1><a href = "/pages/ticketpage.php">HelpDesk</a></h1>
            <section class = "logout-edit">
            <button id="logout">Logout</button> 
            <button id="logout">Edit Profile</button>
            </section>
            <nav>
            <ul>
                <li><a href="/pages/ticketpage.php">My Tickets</a></li>
                <li><a href="#">Departments</a></li>
                <li><a href="#">Agents</a></li>
                <li><a href="#">FAQ</a></li>
                <li><a href="#">About us</a></li>
            </ul>
            </nav>
        </header>
        <main>
<?php } ?>
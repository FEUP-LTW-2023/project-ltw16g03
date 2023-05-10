<?php
  declare(strict_types = 1);
  require_once(__DIR__ . '/../templates/header.tpl.php');
  require_once(__DIR__ . '/../templates/footer.tpl.php');

  drawHeader();
?>
  <section class="tickets">
      <h2>My Tickets 
        <a href="novo_ticket.php" class="button">Criar Novo Ticket</a>
      </h2> 

      <ul>
        <?php  
        require_once(__DIR__ . '/../actions/getUser_tickets.php');
        if(count($tickets) == 0){
          echo "<h3>No tickets from this user</h3>";
        }

        for($i = 0; $i < count($tickets); $i++) { 
        ?>
        <li>
          <div class="ticket" id="<?=$tickets[$i]['id']?>">
            <h3> <?=$tickets[$i]['title']?></h3>
            <p> <?=$tickets[$i]['description']?> </p>
            <p> <?=$tickets[$i]['id_department']?> </p>
            <a href="../pages/detailTicket.php?id=<?=$tickets[$i]['id']?>" class="button">Detalhes</a>
          </div>
        </li>
        <?php } ?>   
      </ul>
    </section>
  
<?php
  drawFooter();
?>


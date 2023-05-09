<?php
  declare(strict_types = 1);
  require_once(__DIR__ . '/../templates/header.tpl.php');
  require_once(__DIR__ . '/../templates/footer.tpl.php');

  drawHeader();
?>

  <!--<section class="newticket">
    <div class="ticket-form">
      <h2>Criar Novo Ticket</h2>
        <form action="../actions/processar_ticket.php" method="post">  Ação e método do formulário, a ser processado no servidor
          <label for="nome">Nome:</label>
          <input type="text" id="nome" name="nome" required>
          <label for="descricao">Descrição:</label>
          <textarea id="descricao" name="descricao" required></textarea>
          <input type="submit" value="Enviar">
        </form>
      </div>
  </section>-->
  <section class="tickets">
      <h2>Tickets Abertos 
        <a href="novo_ticket.php" class="button">Criar Novo Ticket</a>
      </h2> 

      <ul>
        <?php  
        require_once(__DIR__ . '/../actions/getUser_tickets.php');
        if(count($tickets) == 0){
          echo "<h3>Não há tickets abertos</h3>";
        }

        for($i = 0; $i < count($tickets); $i++) { 
        ?>
        <li>
          <div class="ticket" id="<?=$tickets[$i]['id']?>">
            <h3> <?=$tickets[$i]['title']?></h3>
            <p> <?=$tickets[$i]['description']?> </p>
            <p> <?=$tickets[$i]['id_department']?> </p>
            <a href="" class="button">Detalhes</a>
          </div>
        </li>
        <?php } ?>   
      </ul>
    </section>
  
<?php
  drawFooter();
?>


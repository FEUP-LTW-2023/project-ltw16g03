<?php
declare(strict_types = 1);
require_once(__DIR__ . '/../templates/header.tpl.php');
require_once(__DIR__ . '/../templates/footer.tpl.php');

drawHeader();
?>

  <div class="ticket-form">
    <h2>Criar Novo Ticket</h2>
      <form action="/actions/processar_ticket.php" method="post"> <!-- Ação e método do formulário, a ser processado no servidor -->
        <label for="nome">Nome:</label>
        <input type="text" id="name" name="name" required>
        <label for="departments">Choose a department:</label>
    <select name="department" id="department" required>
    <option value = "none"> </option>
    <?php
    require_once(__DIR__ . '/../actions/getAll_departments.php');
    for($i = 0; $i < count($departments); $i++) {
      ?>
          <option value=<?=$departments[$i]['id']?>> <?=$departments[$i]['name']?></option>
    <?php } ?> 
  </select>
  <label for="hashtags">Hashtags:</label>
  <?php
  require_once(__DIR__ . '/../actions/getAll_hashtags.php');
  for($i = 0; $i < count($hashtags); $i++) {
    ?>
        <input type="checkbox" name="hashtag" value=<?=$hashtags[$i]['id']?>> <?=$hashtags[$i]['tag']?>
  <?php } ?> 
    <label for="descricao">Descrição:</label>
    <textarea id="description" name="description" required></textarea>
    <input type="submit" value="Enviar">

      </form>
  </div>
 
<?php
    drawFooter();
?>




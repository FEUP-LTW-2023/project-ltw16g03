<?php
  declare(strict_types = 1);
  require_once(__DIR__ . '/../templates/header.tpl.php');
  require_once(__DIR__ . '/../templates/footer.tpl.php');

  drawHeader();
?>
  <section class="tickets">
      <h2>Frequently Asked Question (FAQ)</h2> 

      <ul>
        <?php  
        require_once(__DIR__ . '/../actions/getAll_faqs.php');
        if(count($faqs) == 0){
          echo "<h3>No FAQ</h3>";
        }

        for($i = 0; $i < count($faqs); $i++) { 
        ?>
        <li>
          <div class="ticket" id="<?=$faqs[$i]['id']?>">
            <h3> <?=$faqs[$i]['title']?></h3>
            <p> <?=$faqs[$i]['description']?> </p>
          </div>
        </li>
        <?php } ?>   
      </ul>
    </section>
  
<?php
  drawFooter();
?>


<?php
  declare(strict_types = 1);
  require_once(__DIR__ . '/../templates/header.tpl.php');
  require_once(__DIR__ . '/../templates/footer.tpl.php');

  drawHeader();
?>
  <section class="tickets">
      <h2>My Tasks 
        <a href="nova_task.php" class="button">Create new Task</a>
      </h2> 

      <ul>
        <?php  
        require_once(__DIR__ . '/../actions/getUser_tasks.php');
        if(count($tasks) == 0){
          echo "<h3>No tasks from this user</h3>";
        }

        for($i = 0; $i < count($tasks); $i++) { 
            if($tasks[$i]['is_completed'] == true){
                $comp = "-- Task done --";
            }else{
                $comp = "-- Task to do --";
            }
        ?>
        <li>
          <div class="ticket" id="<?=$tasks[$i]['id']?>">
            <h3> <?=$tasks[$i]['title']?></h3>
            <p> <?=$tasks[$i]['description']?> </p>
            <p> <?=$comp?> </p>
            <a href="../pages/detailTicket.php?id=<?=$tickets[$i]['id']?>" class="button">Detalhes</a>
          </div>
        </li>
        <?php } ?>   
      </ul>
    </section>
  
<?php
  drawFooter();
?>
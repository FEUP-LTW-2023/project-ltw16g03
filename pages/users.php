<?php
  declare(strict_types = 1);
  require_once(__DIR__ . '/../templates/header.tpl.php');
  require_once(__DIR__ . '/../templates/footer.tpl.php');

  drawHeader();
?>
  <section class="tickets">
      <h2>Website Users</h2> 

      <ul>
        <?php  
        require_once(__DIR__ . '/../actions/getAll_users.php');
        if(count($users) == 0){
          echo "<h3>No users in this website</h3>";
        }

        for($i = 0; $i < count($users); $i++) { 
        ?>
        <li>
          <div class="ticket" id="<?=$users[$i]['id']?>">
            <h3> <?=$users[$i]['username']?></h3>
            <a href="../pages/userprofile.php?id=<?=$users[$i]['id']?>" class="button">See Profile</a>
          </div>
        </li>
        <?php } ?>   
      </ul>
    </section>
  
<?php
  drawFooter();
?>


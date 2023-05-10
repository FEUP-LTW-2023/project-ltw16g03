<?php 
  declare(strict_types = 1); 

  require_once(__DIR__ . '/../database/department.class.php')
?>

<?php function drawdepartments(array $departments) { ?>
  <header>
    <h2>Departments</h2>
    <input id="searchdepartment" type="text" placeholder="search" onchange> 
  </header>
  <section id="departments">
    <?php foreach($departments as $department) { ?> 
      <article>
        <img src="https://picsum.photos/id/1/200/300?<?=$department->id?>">
        <a href="../pages/departmentTicket.php?id=<?=$department->id?>"><?=$department->name?></a>
      </article>
    <?php } ?>
  </section>
<?php } ?>

<?php function drawDepartment(Department $department, array $tickets) { ?>
  <h2><?=$department->name?></h2>
  <section id="tickets">
    <?php foreach ($tickets as $ticket) { 
      $id_t = $ticket['id'];
      $title_t = $ticket['title'];
      $description_t = $ticket['description'];
    ?>
    <div class="ticket" id="<?=$id_t?>">
      <h3> <?=$title_t?></h3>
      <p> <?=$description_t?> </p>
      <a href="" class="button">Detalhes</a>
    </div>
    <?php } ?>
  </section>
<?php } ?>
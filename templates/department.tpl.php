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
    <article>
      <?=$ticket->id?>
      <a href="../pages/ticketpage.php?id=<?=$id_t?>"><?=$title_t?></a>
      <p class="info"> Description of the ticket: <?=$description_t?></p>
    </article>
    <?php } ?>
  </section>
<?php } ?>
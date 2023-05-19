<?php 
  declare(strict_types = 1); 

  require_once(__DIR__ . '/../database/department.class.php');
  require_once(__DIR__ . '/../actions/getAll_hashtags.php');

?>

<?php function drawdepartments(array $departments, bool $isADMIN) { ?>
  <header>
    <h2>Departments
    <?php
    if($isADMIN==true){
  ?>
    <a href="/pages/novo_department.php" class="button">Add Department</a>
  <?php
  }?>
    </h2>
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

<?php
function drawDepartment(Department $department, array $tickets, array $hashtags) {
?>
  <h2><?= $department->name ?></h2>

  <form method="POST" action="">
    <label for="status">Filter by Status:</label>
    <select name="status" id="status">
      <option value="all">All</option>
      <option value="Open">Open</option>
      <option value="Assigned">Assigned</option>
      <option value="Closed">Closed</option>
    </select>

    <label for="hashtags">Filter by Hashtags:</label>
    <?php
    require_once(__DIR__ . '/../actions/getAll_hashtags.php');
    for ($i = 0; $i < count($hashtags); $i++) {
    ?>
      <input type="checkbox" name="hashtags[]" value="<?= $hashtags[$i]['id'] ?>"> <?= $hashtags[$i]['tag'] ?>
    <?php
    }
    ?>

    <input type="submit" value="Apply Filter">
    <input type="button" value="Reset Filter" onclick="location.href='departmentTicket.php?id=<?= $_GET['id'] ?>'">
  </form>

  <section id="tickets">
    <?php 
    if (count($tickets) == 0) {
      echo "<h3>No tickets from this Department</h3>";
    }
    
    foreach ($tickets as $ticket) { 
      $id_t = $ticket['id'];
      $title_t = $ticket['title'];
      $description_t = $ticket['description'];
      $status_t = $ticket['ticket_status'];
    ?>
    <div class="ticket" id="<?= $id_t ?>">
      <h3><?= $title_t ?></h3>
      <p><?= $description_t ?></p>
      <p>-- <?= $status_t ?> --</p>
      <a href="../pages/detailTicket.php?id=<?= $ticket['id'] ?>" class="button">Details</a>
    </div>
    <?php } ?>
  </section>
<?php
}
?>



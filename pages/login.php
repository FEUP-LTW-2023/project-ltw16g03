<?php
  declare(strict_types = 1);
  require_once(__DIR__ . '/../templates/headernouser.tpl.php');
  require_once(__DIR__ . '/../templates/footer.tpl.php');

  drawHeader();
?>
  <section id = "login">
  <h2>Login</h2>
    <form action="../actions/action_login.php" method="post">
      <label for="email">Email:</label>
      <input type="email" name="email" placeholder="email">
      <br>
      <label for="password">Password:</label>
      <input type="password" name="password" placeholder="password">
      <br>
      <input type="submit" value="Login">
    </form>
    <p>Don't have an account? <a href="/pages/register.php">Register here</a>.</p>
  </section>
<?php
  drawFooter();
?>
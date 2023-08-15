<!DOCTYPE html>
<html lang="fr">
<?php
include_once(__DIR__ . '/templates/head.php');
?>

<body class="position-relative ">
  <?php
  include_once(__DIR__ . '/templates/header.php');
  ?>
  <main class="container-fluid">
    <?php require_once(dirname(__FILE__) . '/core/router.php') ?>
  </main>

  <?php
  include_once(__DIR__ . '/templates/footer.php');
  ?>

</body>

</html>
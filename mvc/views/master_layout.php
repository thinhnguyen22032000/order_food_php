<?php
if (!isset($_COOKIE['username'])) {
  $domain = Domain::get();
  header("location: $domain/auth/login");
}
?>
<?php require './mvc/views/inc/header.php'  ?>

<!-- sitemap -->

<nav class="navbar navbar-default p-2 mb-4 bg-light">
  <ul class="nav d-flex" style="line-height: initial">
    <?php
    $i = 0;
    if (isset($GLOBALS['navigate'])) {
      foreach ($GLOBALS['navigate'] as $nav => $value) { ?>
        <li class="mr-3"><a class="" href="<?= $value ?>"><h6><?=$nav?></h6></a></li><?=++$i<count($GLOBALS['navigate'])?'<li class="mr-3">></li>':null?>
    <?php
      }
    }
    ?>
  </ul>
</nav>
<!-- end sitemap -->

<!-- content -->
<div class="mb-4">
  <div class="row justify-content-md-center">
    <div class="col-12">
      <?php require_once "./mvc/views/pages/" . $data["Page"] . ".php" ?>
    </div>
  </div>
</div>
<!--end content -->
<?php require './mvc/views/inc/footer.php' ?>
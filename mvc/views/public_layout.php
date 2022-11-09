<?php
if (isset($_COOKIE['username'])) {
    $domain = Domain::get();
    header("location: $domain/manager/index");
}
?>
<?php require './mvc/views/inc/header.php'?>
<!-- content -->
<div class="mb-4">

    <div class="row justify-content-md-center">
        <div class="col-12">
            <?php require_once "./mvc/views/pages/" . $data["Page"] . ".php" ?>
        </div>
    </div>
</div>
<!-- content -->
<?php require './mvc/views/inc/footer.php'?>
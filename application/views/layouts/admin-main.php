<?php 
use ItForFree\SimpleMVC\Config;


$User = Config::getObject('core.user.class');

?>
<!DOCTYPE html>
<html lang="ru">
    <?php include('includes/main/head.php'); ?>
    <body>
        <div class="container">
            <?php include('includes/admin-main/nav.php'); ?>
            <?= $CONTENT_DATA ?>
            <?php include('includes/main/footer.php'); ?>
        </div>
    </body>
</html>


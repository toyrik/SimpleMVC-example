<?php 
use ItForFree\SimpleMVC\Config;


$User = Config::getObject('core.user.class');

?>
<!DOCTYPE html>
<html lang="ru">
    <?php include('includes/main/head.php'); ?>
    <body>
        <div class="container">
            <header><a href="/"><img id="logo" src="img/logo.jpg" alt="Widget News" /></a></header>
            <?php include('includes/main/nav.php'); ?>
            <?php include('includes/admin-main/nav.php'); ?>
            <?= $CONTENT_DATA ?>
            <?php include('includes/main/footer.php'); ?>
        </div>
    </body>
</html>


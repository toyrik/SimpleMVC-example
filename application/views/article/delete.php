<?php 
use ItForFree\SimpleMVC\Config;

$Url = Config::getObject('core.url.class');
?>

<?php include('includes/admin-article-nav.php'); ?>

<h2><?= $title ?></h2>

<form method="post" action="<?= $Url::link("admin/article/delete&id=". $_GET['id'])?>" >
    Вы уверены, что хотите удалить статью <?=$Article->title?>?
    <br>
    <input type="hidden" name="id" value="<?= $Article->id ?>">
    <input type="submit" class="btn btn-danger" name="delete" value="Удалить">
    <input type="submit" class="btn btn-light" name="cancel" value="Вернуться"><br>
</form>

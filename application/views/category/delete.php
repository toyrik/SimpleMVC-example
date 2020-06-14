<?php 
use ItForFree\SimpleMVC\Config;

$Url = Config::getObject('core.url.class');
?>

<?php include('includes/admin-category-nav.php'); ?>

<h2><?= $deleteCategoryTitle ?></h2>

<form method="post" action="<?= $Url::link("admin/category/delete&id=". $_GET['id'])?>" >
    Вы уверены, что хотите удалить категорию <?=$deleteCategory->name?>?
    
    <input type="hidden" name="id" value="<?= $deleteCategory->id ?>">
    <input type="submit" name="deleteCategory" value="Удалить">
    <input type="submit" name="cancel" value="Вернуться"><br>
</form>
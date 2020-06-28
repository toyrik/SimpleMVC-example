<?php 
use ItForFree\SimpleMVC\Config;

$Url = Config::getObject('core.url.class');
?>

<?php include('includes/admin-subcategory-nav.php'); ?>

<h2><?= $deleteSubcategoryTitle ?></h2>

<form method="post" action="<?= $Url::link("admin/subcategory/delete&id=". $_GET['id'])?>" >
    <div class="card-title">Вы уверены, что хотите удалить подкатегорию <strong><?=$deleteSubcategory->name?></strong>?</div>
    
    <input type="hidden" name="id" value="<?= $deleteSubcategory->id ?>">
    <input type="submit" name="deleteSubcategory" value="Удалить">
    <input type="submit" name="cancel" value="Вернуться"><br>
</form>
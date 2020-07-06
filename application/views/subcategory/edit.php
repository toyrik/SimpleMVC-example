<?php 
use ItForFree\SimpleMVC\Config;

$Url = Config::getObject('core.url.class');
$User = Config::getObject('core.user.class');
?>

<?php include('includes/admin-subcategory-nav.php'); ?>

<h2><?= $editSubcategoryTitle ?>
    
</h2>

<form id="editUser" method="post" action="<?= $Url::link('admin/subcategory/edit&id=' . $_GET['id'])?>">
    <h5>Название подкатегории</h5>
    <input type="text" name="name" class="form-control"  placeholder="Введите название подкатегории" value="<?= $viewSubcategory->name ?>"><br>
    <h5>Описание подкатегории</h5>
    <textarea name="description" class="form-control"  placeholder="email"><?= $viewSubcategory->description ?></textarea><br>
    <div class="form-group">
        <label for="category">Родительская категория</label>
        <select class="form-control" name="categoryId" id="category">
        <?php foreach ($categories as $category) { ?>
            <option value="<?= $category->id ?>"><?= $category->name ?></option>
        <?php } ?>
        </select>

    </div>

    <input type="hidden" name="id" value="<?= $_GET['id']?>">
    <input type="submit" class="btn btn-success" name="saveChanges" value="Сохранить">
    <input type="submit" class="btn btn-danger" name="cancel" value="Назад">
</form>
<span class="btn btn-danger">
    <?= $User->returnIfAllowed('admin/subcategory/delete',
        '<a class="text-black-50" href=' . $Url::link('admin/subcategory/delete&id=' . $_GET['id'])
        . '>Удалить</a>')?>
</span>
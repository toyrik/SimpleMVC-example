<?php include 'includes/admin-subcategory-nav.php'; ?>
<h2><?= $subcategoryTitle ;?></h2>
<form id="addSubcategory" method="post" action="<?= \ItForFree\SimpleMVC\Url::link("admin/subcategory/add")?>">

    <div class="form-group">
        <label for="name">Название подкатегории</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="Введите название подкатегории">
    </div>
    <div class="form-group">
        <label for="description">Описание подкатегории</label>
        <textarea class="form-control"  name="description" id="description" placeholder="Введите описание подкатегории"></textarea>
    </div>
    <div class="form-group">
        <label for="category">Родительская категория</label>
        <select class="form-control" name="categoryId" id="category">
        <?php foreach ($categories as $category) { ?>
            <option value="<?= $category->id ?>"><?= $category->name ?></option>
        <?php } ?>
        </select>
        
<?php
//echo '<pre>';
//print_r($categories);
////print_r($subcategories);
//echo '</pre>';
?>
    </div>

    <input type="submit" class="btn btn-primary" name="saveNewSubcategory" value="Сохранить">
    <input type="submit" class="btn" name="cancel" value="Назад">
</form>


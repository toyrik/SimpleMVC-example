<?php
use ItForFree\SimpleMVC\Config;
use ItForFree\SimpleMVC\Url;

$User = Config::getObject('core.user.class');

include 'includes/admin-subcategory-nav.php';
?>
<h2>Список категорий</h2>
<?php if(!empty($subcategories)): ?>
<table class="table">
    <thead>
    <tr>
      <th scope="col">id</th>
      <th scope="col">Name</th>
      <th scope="col">Description</th>
      <th scope="col">Родительская категория</th>
      <th colspan="2" scope="col">Действия</th>
    </tr>
     </thead>
    <tbody>
    <?php foreach($subcategories as $key => $subcategory): ?>
    <tr class="pointer" onclick="location='<?php echo Url::link('admin/subcategory/index&id=' . $subcategory->id) ?>'">
        <td> <?= $subcategory->id ?> </td>
        <td> <?= $subcategory->name ?> </td>
        <td>  <?= $subcategory->description ?> </td>
        <td>  <?= $categories[$subcategory->categoryId] ?> </td>
        <td>  <?= $User->returnIfAllowed('admin/subcategory/edit',
                    '<a href=' . Url::link('admin/subcategory/edit&id=' . $subcategory->id)
                    . '>[Редактировать]</a>')?></td>
        <td> <?= $User->returnIfAllowed("admin/subcategory/delete", 
                    "<a href=" . Url::link("admin/subcategory/delete&id=". $subcategory->id) 
                    . ">[Удалить]</a>");?></td>
    </tr>
    <?php endforeach; ?>
    
    </tbody>
</table>

<?php else:?>
    <p> Список подкатегорий пуст. </p>
<?php endif; ?>
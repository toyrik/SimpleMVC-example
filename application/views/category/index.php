<?php
use ItForFree\SimpleMVC\Config;
use ItForFree\SimpleMVC\Url;

$User = Config::getObject('core.user.class');

include 'includes/admin-category-nav.php';
?>
<h2>Список категорий</h2>
<?php if(!empty($categories)): ?>
<table class="table">
    <thead>
    <tr>
      <th scope="col">id</th>
      <th scope="col">Name</th>
      <th scope="col">Description</th>
      <th colspan="2" scope="col">Действия</th>
    </tr>
     </thead>
    <tbody>
    <?php foreach($categories as $category): ?>
    <tr class="pointer" onclick="location='<?php echo Url::link('admin/category/index&id=' . $category->id) ?>'">
        <td> <?= $category->id ?> </td>
        <td> <?= $category->name ?> </td>
        <td>  <?= $category->description ?> </td>
        <td>  <?= $User->returnIfAllowed('admin/category/edit',
                    '<a href=' . Url::link('admin/category/edit&id=' . $category->id)
                    . '>[Редактировать]</a>')?></td>
    <td> <?= $User->returnIfAllowed("admin/category/delete", 
                    "<a href=" . Url::link("admin/category/delete&id=". $category->id) 
                    . ">[Удалить]</a>");?></td>
    </tr>
    <?php endforeach; ?>
    
    </tbody>
</table>

<?php else:?>
    <p> Список категорий пуст. </p>
<?php endif; ?>
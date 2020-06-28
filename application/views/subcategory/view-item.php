<?php 
use ItForFree\SimpleMVC\Config;

$User = Config::getObject('core.user.class');
?>

<?php include('includes/admin-subcategory-nav.php'); ?>

<h2><?= $viewSubcategory->name ?></h2>
    

<div class="card" style="width: 100%; min-width: 320px; margin-bottom: 80px">
    <div class="card-body">
        <p>Описание: <?= $viewSubcategory->description ?></p>
    </div>
</div>
<span class="btn btn-warning btn-sm">
        <?= $User->returnIfAllowed("admin/subcategory/edit",
            "<a class=\"text-black-50\" href=" . \ItForFree\SimpleMVC\Url::link("admin/subcategory/edit&id=". $viewSubcategory->id)
            . ">[Редактировать]</a>")?></span>

        <?= $User->returnIfAllowed('admin/subcategory/delete',
   '<span class="btn btn-danger btn-sm">
                <a class="text-black-50" href=' . \ItForFree\SimpleMVC\Url::link('admin/subcategory/delete&id=' . $viewSubcategory->id)
            . '>[Удалить]</a></span>')?>
    </span>

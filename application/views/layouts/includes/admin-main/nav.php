
<?php 
use ItForFree\SimpleMVC\Config;
use ItForFree\SimpleMVC\Url;

$User = Config::getObject('core.user.class');


//vpre($User->explainAccess("homepage/index"));

?>

<nav class="navbar navbar-expand-lg navbar-light bg-light"> <!-- Меню оформленное с помощью  twitter bootstrap -->
 <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
 </button>
 <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
        <?php  if ($User->isAllowed("admin/adminusers/index")): ?>
        <li class="nav-item ">
            <a class="nav-link" href="<?= Url::link("admin/adminusers/index") ?>"> Пользователи </a>
        </li>
        <?php endif; ?>
                
        <?php  if ($User->isAllowed("admin/category/index")): ?>
            <li class="nav-item ">
                <a class="nav-link" href="<?= Url::link("admin/category/index") ?>"> Категории </a>
            </li>
        <?php endif; ?>
            
        <?php  if ($User->isAllowed("admin/subcategory/index")): ?>
            <li class="nav-item ">
                <a class="nav-link" href="<?= Url::link("admin/subcategory/index") ?>"> Подкатегории </a>
            </li>
        <?php endif; ?>
        
    </ul>
   </div>
</nav>


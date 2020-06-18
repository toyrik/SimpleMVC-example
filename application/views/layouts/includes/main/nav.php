
<?php 
use ItForFree\SimpleMVC\Config;
use ItForFree\SimpleMVC\Url;

$User = Config::getObject('core.user.class');


//ppre($User->explainAccess("admin/adminusers/index"));

?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark"> <!-- Меню оформленное с помощью  twitter bootstrap -->
 <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
 </button>
 <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav main-nav">
        <?php  if ($User->isAllowed("admin/adminusers/index")): ?>
        <li class="nav-item ">
            <a class="nav-link" href="<?= Url::link("admin/adminusers/index") ?>"> Управление </a>
        </li>
        <?php endif; ?>
        <?php  if ($User->isAllowed("login/login")): ?>
        <li class="nav-item user">
            <a class="nav-link" href="<?= Url::link("login/login") ?>">[Вход]</a>
        </li>
        <?php endif; ?>
        <?php  if ($User->isAllowed("login/logout")): ?>
        <li class="nav-item user">
            <a class="nav-link" href="<?= Url::link("login/logout") ?>">Выход (<?= $User->userName ?>)</a>
        </li>
        <?php endif; ?>
    </ul>
   </div>
</nav>


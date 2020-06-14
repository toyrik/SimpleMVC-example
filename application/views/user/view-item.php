<?php 
use ItForFree\SimpleMVC\Config;

$User = Config::getObject('core.user.class');
include('includes/admin-users-nav.php'); 
?>

<h2><?= $viewAdminusers->login ?></h2> 
<p>Зарегистрирован <?= $viewAdminusers->timestamp ?></p>
<p>E-mail: <?= $viewAdminusers->email ?></p>

    <span>
        <?= $User->returnIfAllowed("admin/adminusers/edit", "<a href=" . \ItForFree\SimpleMVC\Url::link("admin/adminusers/edit&id=". $viewAdminusers->id)             . ">[Редактировать]</a>");?>
    </span>
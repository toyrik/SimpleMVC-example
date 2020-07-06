<?php
namespace application\controllers\admin;

use ItForFree\SimpleMVC\Config;
use ItForFree\SimpleMVC\mvc\Controller;
use ItForFree\SimpleMVC\Url;

class ArticleController extends Controller
{
    public $layoutPath = 'admin-main.php';
    protected $rules = [ 
         ['allow' => true, 'roles' => ['admin']],
         ['allow' => false, 'roles' => ['?', '@']],
    ];
    
    public function indexAction()
    {
        $this->view->render('articles/index.php');
    }
    
    public function addAction()
    {
        $this->view->render('articles/add.php');
    }
    
    public function editAction()
    {
        $this->view->render('articles/edit.php');
    }
    
    public function deleteAction()
    {
        $this->view->render('articles/delete.php');
    }
}

<?php
namespace application\controllers\admin;

use application\models\Article;
use application\models\Adminusers;
use application\models\Category;
use application\models\Subcategory;
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
        $Url = Config::get('core.url.class');
        $Article = new Article();
        $articleId = $_GET['id'] ?? null;
        
        if ($articleId) {
            $Article = $Article->getById($_GET['id']);
            if (isset($Article->id)) {
                $Article->getArticleAuthors();
                $categories = Category::getListAssoc();
                $this->view->addVar('categories', $categories);
                $subcategories = Subcategory::getListAssoc();
                $this->view->addVar('subcategories', $subcategories);
                $users = Adminusers::getListAssoc();
                $this->view->addVar('users', $users);
                $this->view->addVar('Article', $Article);
                $this->view->render('article/view-item.php');
            } else {
                $this->redirect($Url::link('admin/article/index'));
            }
        } else { // выводим полный список

            $articles = $Article->getList()['results'];
            $categories = Category::getListAssoc();
            $subcategories = Subcategory::getListAssoc();
            $this->view->addVar('articles', $articles);
            $this->view->addVar('categories', $categories);
            $this->view->addVar('subcategories', $subcategories);
            $this->view->render('article/index.php');
        }
    }
    
    public function addAction()
    {
        $Url = Config::get('core.url.class');
        if (!empty($_POST)) {
            if (!empty($_POST['saveNew'])) {
                $Article = new Article();
                $Article = $Article->loadFromArray($_POST);
                $Article->insert();
                $this->redirect($Url::link('admin/article/index'));
            }
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link('admin/article/index'));
            }
        }
        else {
            $title = 'Добавление новой статьи';

            $categories = Category::getListAssoc();
            $subcategories = (new Subcategory())->getListShort();
            $users = Adminusers::getListAssoc();
            $this->view->addVar('users', $users);
            $this->view->addVar('categories', $categories);
            $this->view->addVar('subcategories', $subcategories);
            $this->view->addVar('title', $title);
            $this->view->render('article/add.php');
        }
    }
    
    public function editAction()
    {
        
        $id = $_GET['id'];
        $Url = Config::get('core.url.class');

        if (!empty($_POST)) { // это выполняется нормально.

            if (!empty($_POST['saveChanges'] )) {
                $Article = new Article();
                $Article = $Article->loadFromArray($_POST);
                $Article->update();
                $this->redirect($Url::link("admin/article/index&id=$id"));
            }
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/article/index&id=$id"));
            }
        }
        else {
            $Article = new Article();
            $Article = $Article->getById($id);
            if (isset($Article->id)) {
                $Article->unixDate();
                $Article->getArticleAuthors();
                $title = 'Редактирование статьи';
                $categories = Category::getListAssoc();
                $subcategories = (new Subcategory())->getListShort();
                $users = Adminusers::getListAssoc();
                $this->view->addVar('users', $users);
                $this->view->addVar('categories', $categories);
                $this->view->addVar('subcategories', $subcategories);
                $this->view->addVar('Article', $Article);
                $this->view->addVar('title', $title);
                $this->view->render('article/edit.php');
            } else {
                $this->redirect($Url::link('admin/article/index'));
            }
        }

    }
    
    public function deleteAction()
    {
        $id = $_GET['id'];
        $Url = Config::get('core.url.class');

        if (!empty($_POST)) {
            if (!empty($_POST['delete'])) {
                $Article = new Article();
                $Article = $Article->loadFromArray($_POST);
                $Article->delete();
                $this->redirect($Url::link('admin/article/index'));
            }
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/article/edit&id=$id"));
            }
        }
        else {
            $Article = new Article();
            $Article = $Article->getById($id);
            if (isset($Article->id)) {
                $title = 'Удаление статьи';
                $this->view->addVar('Article', $Article);
                $this->view->addVar('title', $title);
                $this->view->render('article/delete.php');
            } else {
                $this->redirect($Url::link('admin/article/index'));
            }
        }
    }
}

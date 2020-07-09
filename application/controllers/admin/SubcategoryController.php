<?php
namespace application\controllers\admin;

use application\models\Subcategory;
use application\models\Category;
use ItForFree\SimpleMVC\Config;

class SubcategoryController extends \ItForFree\SimpleMVC\mvc\Controller
{
    public $layoutPath = 'admin-main.php';
    
    protected $rules = [ 
         ['allow' => true, 'roles' => ['admin']],
         ['allow' => false, 'roles' => ['?', '@']],
    ];
    
    public function indexAction()
    {
        $Url = Config::get('core.url.class');
        $Subcategory = new Subcategory();
        $subcategoryId = $_GET['id'] ?? null;
        
        if ($subcategoryId){
            $Subcategory = $Subcategory->getById($_GET['id']);
            $this->view->addVar('viewSubcategory', $Subcategory);
            $this->view->render('subcategory/view-item.php');
        }else{
            $subcategories = $Subcategory->getList()['results'];
            $categories = Category::getListAssoc();
            $this->view->addVar('subcategories', $subcategories);
            $this->view->addVar('categories', $categories);
            $this->view->render('subcategory/index.php');
        }
    }
    
    public function addAction()
    {
       $Url = Config::get('core.url.class');
        if (!empty($_POST)) {
            if (!empty($_POST['saveNewSubcategory'])) {
                $Subcategory = new Subcategory();
                $Subcategory = $Subcategory->loadFromArray($_POST);
                $Subcategory->insert();
                $this->redirect($Url::link('admin/subcategory/index'));
            } 
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link('admin/subcategory/index'));
            }
        }
        else {
            $addSubcategoryTitle = 'Добавление новой подкатегории';
            $category = new Category();
            $data = $category->getList();
            $categories = $data['results'];
            
            $this->view->addVar('categories', $categories);
            $this->view->addVar('subcategoryTitle', $addSubcategoryTitle);
            $this->view->render('subcategory/add.php');
        }
    }
    
    public function editAction()
    {
        $id = $_GET['id'];
        $Url = Config::get('core.url.class');
        
        if (!empty($_POST)) { 
            if (!empty($_POST['saveChanges'] )) {
                $Subcategory = new Subcategory();
                $Subcategory = $Subcategory->loadFromArray($_POST);
                $Subcategory->update();
                $this->redirect($Url::link("admin/subcategory/index&id=$id"));
            } 
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/subcategory/index&id=$id"));
            }
        }
        else {
            $Subcategory = new Subcategory();
            $Subcategory = $Subcategory->getById($id);
            $editSubcategoryTitle = 'Редактирование подкатегории';
            $category = new Category();
            $data = $category->getList();
            $categories = $data['results'];
            
            $this->view->addVar('categories', $categories);            
            $this->view->addVar('viewSubcategory', $Subcategory);
            $this->view->addVar('editSubcategoryTitle', $editSubcategoryTitle);
            
            $this->view->render('subcategory/edit.php');
        }
    }
    
    public function deleteAction()
    {
        $id = $_GET['id'];
        $Url = Config::get('core.url.class');
        
        if (!empty($_POST)) {
            if (!empty($_POST['deleteSubcategory'])) {
                $Subcategory = new Subcategory();
                $deleteSubcategory = $Subcategory->loadFromArray($_POST);
                $deleteSubcategory->delete();
                
                $this->redirect($Url::link("admin/subcategory/index"));
              
            }
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/subcategory/edit&id=$id"));
            }
        }
        else {
            
            $Subcategory = new Subcategory();
            $deleteSubcategory = $Subcategory->getById($id);
            $deleteSubcategoryTitle = "Удаление подкатегории";
            
            $this->view->addVar('deleteSubcategoryTitle', $deleteSubcategoryTitle);
            $this->view->addVar('deleteSubcategory', $deleteSubcategory);
            
            $this->view->render('subcategory/delete.php');
        }
    }
}

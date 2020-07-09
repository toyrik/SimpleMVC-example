<?php
namespace application\controllers;

use application\models\Article;
use application\models\Category;
use application\models\Subcategory;
use ItForFree\SimpleMVC\Config;

class HomepageController extends \ItForFree\SimpleMVC\mvc\Controller
{
    /**
     * @var string Название страницы
     */
    public $homepageTitle = "Домашняя страница";
    
    public $layoutPath = 'main.php';
    
        
    /**
     * Выводит на экран страницу "Домашняя страница"
     */
    public function indexAction()
    {
        $contentFirstSymbols = Config::get('core.home.firstContent');
        $homepageNumArticles = Config::get('core.home.NumArticles');
        $articles = (new Article())->getListWithParam($homepageNumArticles, null, false)['results'];
        $categories = Category::getListAssoc();
        $subcategories = Subcategory::getListAssoc();
        $this->view->addVar('articles', $articles);
        $this->view->addVar('categories', $categories);
        $this->view->addVar('subcategories', $subcategories);
        $this->view->addVar('contentFirstSymbols', $contentFirstSymbols);
        $this->view->addVar('homepageTitle', $this->homepageTitle); // передаём переменную по view
        $this->view->render('homepage/index.php');
    }
}


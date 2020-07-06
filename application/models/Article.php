<?php
namespace application\models;

use ItForFree\SimpleMVC\mvc\Model;
use PDO;

/**
 * Description of Article
 *
 * @author toyrik
 */
class Article extends BaseExampleModel
{
    /**
     * Имя таблицы категорий
     * @var string 
     */
    public $tableName = 'articles';
    
    /**
     * Критерий сортировки
     * @var string
     */
    public $orderBy = 'publicationDate ASC';
    
    /**
     * Дата публикации
     * @var int
     */
    public $publicationDate = null;
    
    /**
     * Дата публикации
     * @var int
     */
    public $categoryId = null;
    
    /**
     * Дата публикации
     * @var int
     */
    public $subcategoryId = null;
    
    /**
     * Название категории
     * @var string|null 
     */
    public $title = null;
    
    /**
     * Короткое описание категории
     * @var string|null 
     */
    public $summary = null;
    
    /**
     * Короткое описание категории
     * @var string|null 
     */
    public $content = null;
    
    /**
     * Дата публикации
     * @var int
     */
    public $isActive = null;
    
    /**
     * Дата публикации
     * @var int
     */
    public $authors = null;
    
    /**
     * Добавление новой статьи в базу данных
     */
    public function insert()
    {
        
    }
    
    /**
     * Обновление статьи
     */
    public function update()
    {
        
    }
    
    
    
    
}

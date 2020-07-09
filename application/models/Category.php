<?php
namespace application\models;

use PDO;

/**
 * Description of Category
 *
 * @author toyrik
 */
class Category extends BaseExampleModel
{
    /**
     * Имя таблицы категорий
     * @var string 
     */
    public $tableName = 'categories';
    
    /**
     * Критерий сортировки
     * @var string
     */
    public $orderBy = 'name ASC';
    
    /**
     * Название категории
     * @var string|null 
     */
    public $name = null;
    
    /**
     * Короткое описание категории
     * @var string|null 
     */
    public $description = null;
    
    /**
     * Вставляем текущий объект Category в базу данных и устанавливаем его ID
     */
    public function insert()
    {
        $sql = "INSERT INTO $this->tableName (name, description) VALUES (:name, :description)";
        $st = $this->pdo->prepare($sql);
        $st->bindValue(":name", $this->name, PDO::PARAM_STR);
        $st->bindValue(":description", $this->description, PDO::PARAM_STR);
        $st->execute();
        $this->id = $this->pdo->lastInsertId();
    }
    
    /**
     * Обновляем текущий объект Category в базе данных
     */
    public function update()
    {
        if(is_null($this->id)) trigger_error ("Category::update(): Попытка обновить объект с отсутствующим ID", E_USER_ERROR);
        $sql = "UPDATE $this->tableName SET name=:name, description=:description WHERE id=:id";
        $st = $this->pdo->prepare($sql);
        $st->bindValue(":id", $this->id, PDO::PARAM_INT);
        $st->bindValue(":name", $this->name, PDO::PARAM_STR);
        $st->bindValue(":description", $this->description, PDO::PARAM_STR);
        $st->execute();
    }
    
    public static function getListAssoc()
    {
        $thisEl = new static();
        $sql = "SELECT id, name FROM $thisEl->tableName ORDER BY $thisEl->orderBy";
        
        $st = $thisEl->pdo->prepare($sql);
        $st->execute();
        $list = $st->fetchAll(\PDO::FETCH_KEY_PAIR);
        
        return $list;
        
    }
}

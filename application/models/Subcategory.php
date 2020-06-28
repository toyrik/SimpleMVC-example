<?php
namespace application\models;

use PDO;


class Subcategory extends BaseExampleModel
{   
    /**
     * @var string Имя обрабатываемой таблицы 
     */
    public $tableName = 'subcategory';
    
    
    /**
     *  @var string Имя поля по котору сортируем
     */
    public $orderBy = 'id';
    
    /**
     * Название Подкатегории
     * @var string|null 
     */
    public $name = null;
    
    /**
     * Короткое описание Подкатегории
     * @var string|null 
     */
    public $description = null;
    
    /**
     * Идентификатор категории - родителя
     * @var int|null 
     */
    public $categoryId = null;
    
    /**
     * Вставляем текущий объект Subcategory в базу данных и устанавливаем его ID
     */
    public function insert()
    {
        $sql = "INSERT INTO $this->tableName (name, description, categoryId) VALUES (:name, :description, :categoryId)";
        $st = $this->pdo->prepare($sql);
        $st->bindValue(":name", $this->name, PDO::PARAM_STR);
        $st->bindValue(":description", $this->description, PDO::PARAM_STR);
        $st->bindValue(":categoryId", $this->categoryId, PDO::PARAM_INT);
        $st->execute();
        $this->id = $this->pdo->lastInsertId();
    }
    
    /**
     * Обновляем текущий объект Subcategory в базе данных
     */
    public function update()
    {
        if(is_null($this->id)) trigger_error ("Subcategory::update(): Попытка обновить объект с отсутствующим ID", E_USER_ERROR);
        $sql = "UPDATE $this->tableName SET name=:name, description=:description, categoryID=:categoryId WHERE id=:id";
        $st = $this->pdo->prepare($sql);
        
        $st->bindValue(":id", $this->id, PDO::PARAM_INT);
        $st->bindValue(":name", $this->name, PDO::PARAM_STR);
        $st->bindValue(":description", $this->description, PDO::PARAM_STR);
        $st->bindValue(":categoryId", $this->categoryId, PDO::PARAM_INT);
        $st->execute();
    }
}

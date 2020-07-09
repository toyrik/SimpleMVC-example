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
     * Добавление новой статьи в БД
     */
    public function insert()
    {
        // Вставляем статью
        $sql = "INSERT INTO $this->tableName ( publicationDate, categoryId, subcategoryId, title, summary, content, isActive)" .
            'VALUES ( FROM_UNIXTIME(:publicationDate), :categoryId, :subcategoryId, :title, :summary, :content, :isActive )';
        $st = $this->pdo->prepare($sql);
        $st->bindValue(":publicationDate", $this->publicationDate, PDO::PARAM_INT);
        $st->bindValue(":categoryId", $this->categoryId, PDO::PARAM_INT);
        $st->bindValue(":subcategoryId", $this->subcategoryId, PDO::PARAM_INT);
        $st->bindValue(":title", $this->title, PDO::PARAM_STR);
        $st->bindValue(":summary", $this->summary, PDO::PARAM_STR);
        $st->bindValue(":content", $this->content, PDO::PARAM_STR);
        $st->bindValue(":isActive", $this->isActive, PDO::PARAM_INT);
        $st->execute();

        $this->id = $this->pdo->lastInsertId();

        if ($this->authors) {
            $this->insertAuthors();
        }
    }
    
    /**
     * Обновление статьи
     */
    public function update()
    {
        // Обновляем статью
        $sql = "UPDATE $this->tableName SET publicationDate=FROM_UNIXTIME(:publicationDate),"
            . ' categoryId=:categoryId, subcategoryId=:subcategoryId, title=:title, summary=:summary,'
            . ' content=:content, isActive=:isActive WHERE id = :id';
        $st = $this->pdo->prepare($sql);
        $st->bindValue(":publicationDate", $this->publicationDate, PDO::PARAM_INT);
        $st->bindValue(":categoryId", $this->categoryId, PDO::PARAM_INT);
        $st->bindValue(":subcategoryId", $this->subcategoryId, PDO::PARAM_INT);
        $st->bindValue(":title", $this->title, PDO::PARAM_STR);
        $st->bindValue(":summary", $this->summary, PDO::PARAM_STR);
        $st->bindValue(":content", $this->content, PDO::PARAM_STR);
        $st->bindValue(":id", $this->id, PDO::PARAM_INT);
        $st->bindValue(":isActive", $this->isActive, PDO::PARAM_INT);
        $st->execute();

        $this->deleteAuthors();

        if ($this->authors) {
            $this->insertAuthors();
        }
    }
    
    /**
     * Добавление списка авторов статьи в БД
     */
    private function insertAuthors()
    {
        foreach ($this->authors as $author) {
            $sql = 'INSERT INTO articles_users (article_id, user_id) VALUES (:articleId, :authorId)';
            $st = $this->pdo->prepare($sql);
            $st->bindValue(':authorId', $author, PDO::PARAM_INT);
            $st->bindValue(':articleId', $this->id, PDO::PARAM_INT);
            $st->execute();
        }
    }
    
    /**
     * Удаление пользователя из авторов статьи
     */
    private function deleteAuthors()
    {
        $sql = 'DELETE FROM articles_users WHERE article_id = :id';
        $st = $this->pdo->prepare($sql);
        $st->bindValue(':id', $this->id, PDO::PARAM_INT);
        $st->execute();
    }
    
    /**
     * Получение массива авторов статьи из БД
     */
    public function getArticleAuthors()
    {
        $sql = 'SELECT user_id, login FROM articles_users' .
            ' JOIN users ON user_id = users.id WHERE article_id = :id';
        $st = $this->pdo->prepare($sql);
        $st->bindValue(':id', $this->id, PDO::PARAM_INT);
        $st->execute();
        $this->authors = $st->fetchAll(PDO::FETCH_KEY_PAIR);
    }
    
    public function unixDate(): void
    {
        $publicationDate = explode('-', $this->publicationDate);

        if (count($publicationDate) === 3) {
            [$y, $m, $d] = $publicationDate;
            $this->publicationDate = mktime(0, 0, 0, $m, $d, $y);
        }
    }
    
    public function getListWithParam($numRows = 1000000,
                                   $categoryId = [], $allArticles = true, $order = 'publicationDate DESC')
    {
        $categoryType = $categoryId['type'] ?? false;
        $categoryValue = $categoryId['value'] ?? '';

        $categoryClause = $categoryType ? "$categoryType = :$categoryType" : '';
        if ($categoryType === 'subcategoryId' && $categoryValue === 'none') {
            $categoryClause = 'subcategoryId IS NULL';
        }
        $activeClause = !$allArticles ? 'isActive = 1' : '';
        $filter = '';
        if ($categoryClause && $activeClause) {
            $filter = "WHERE $categoryClause AND $activeClause";
        } elseif ($categoryClause || $activeClause) {
            $filter = "WHERE $categoryClause $activeClause";
        }
        $sql = "SELECT SQL_CALC_FOUND_ROWS *, UNIX_TIMESTAMP(publicationDate) 
                AS publicationDate
                FROM articles $filter
                ORDER BY  $order  LIMIT :numRows";

        $st = $this->pdo->prepare($sql);

//                        Здесь $st - текст предполагаемого SQL-запроса, причём переменные не отображаются
        $st->bindValue(':numRows', $numRows, PDO::PARAM_INT);

        if (($categoryType && $categoryValue !== 'none')) {
            $st->bindValue(":$categoryType", $categoryValue, PDO::PARAM_INT);
        }

        $st->execute(); // выполняем запрос к базе данных

//                        Здесь $st - текст предполагаемого SQL-запроса, причём переменные не отображаются
        $list = array();

        while ($row = $st->fetch()) {
            $article = new self($row);
            $list[] = $article;
        }

        // Получаем общее количество статей, которые соответствуют критерию
        $sql = 'SELECT FOUND_ROWS() AS totalRows';
        $totalRows = $this->pdo->query($sql)->fetch();

        $sql = 'SELECT article_id, user_id, login FROM articles_users' .
            ' JOIN users ON user_id = users.id ORDER BY article_id';
        $st = $this->pdo->query($sql);

        $authors = [];
        while ($author = $st->fetch(PDO::FETCH_ASSOC)) {
            $authors[$author['article_id']][$author['user_id']] = $author['login'];
        }
        $this->pdo = null;

        foreach ($list as $article) {
            if (isset($authors[$article->id])) {
                $article->authors = $authors[$article->id];
            }
        }

        return [
            'results' => $list,
            'totalRows' => $totalRows[0]
        ];
    }
}

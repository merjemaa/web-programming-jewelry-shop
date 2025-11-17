<?php
require_once 'BaseDao.php';

class CategoryDao extends BaseDao {
    public function __construct() {
        parent::__construct("categories");
    }

    public function getByName($name) {
        $stmt = $this->connection->prepare("SELECT * FROM categories WHERE name = :name");
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getActiveCategories() {
        $stmt = $this->connection->prepare("
            SELECT DISTINCT c.* FROM categories c 
            INNER JOIN products p ON c.id = p.category_id 
            WHERE p.is_active = 1
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>
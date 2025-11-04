<?php
require_once 'BaseDao.php';

class ProductDao extends BaseDao {
    public function __construct() {
        parent::__construct("products");
    }

    public function getByExternalId($external_id) {
        $stmt = $this->connection->prepare("SELECT * FROM products WHERE external_id = :external_id");
        $stmt->bindParam(':external_id', $external_id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getByCategory($category_id) {
        $stmt = $this->connection->prepare("SELECT * FROM products WHERE category_id = :category_id AND is_active = 1");
        $stmt->bindParam(':category_id', $category_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function searchProducts($search_term) {
        $stmt = $this->connection->prepare("SELECT * FROM products WHERE name LIKE :search OR description LIKE :search AND is_active = 1");
        $search_term = "%$search_term%";
        $stmt->bindParam(':search', $search_term);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>
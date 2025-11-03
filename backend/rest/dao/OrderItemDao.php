<?php
require_once 'BaseDao.php';

class OrderItemDao extends BaseDao {
    public function __construct() {
        parent::__construct("order_items");
    }

    public function getByOrderId($order_id) {
        $stmt = $this->connection->prepare("
            SELECT oi.*, p.name, p.image_url 
            FROM order_items oi 
            INNER JOIN products p ON oi.product_id = p.id 
            WHERE oi.order_id = :order_id
        ");
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getByProductId($product_id) {
        $stmt = $this->connection->prepare("SELECT * FROM order_items WHERE product_id = :product_id");
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>
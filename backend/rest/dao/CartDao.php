<?php
require_once 'BaseDao.php';

class CartDao extends BaseDao {
    public function __construct() {
        parent::__construct("cart_items");
    }

    public function getByUserId($user_id) {
        $stmt = $this->connection->prepare("
            SELECT ci.*, p.name, p.price, p.image_url, p.external_id 
            FROM cart_items ci 
            INNER JOIN products p ON ci.product_id = p.id 
            WHERE ci.user_id = :user_id
        ");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getCartItem($user_id, $product_id) {
        $stmt = $this->connection->prepare("SELECT * FROM cart_items WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function updateQuantity($user_id, $product_id, $quantity) {
        $stmt = $this->connection->prepare("
            UPDATE cart_items 
            SET quantity = :quantity 
            WHERE user_id = :user_id AND product_id = :product_id
        ");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':quantity', $quantity);
        return $stmt->execute();
    }

    public function clearUserCart($user_id) {
        $stmt = $this->connection->prepare("DELETE FROM cart_items WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        return $stmt->execute();
    }
}
?>
<?php
require_once 'BaseDao.php';

class SubscriberDao extends BaseDao {
    public function __construct() {
        parent::__construct("subscribers");
    }

    public function getByEmail($email) {
        $stmt = $this->connection->prepare("SELECT * FROM subscribers WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getActiveSubscribers() {
        $stmt = $this->connection->prepare("SELECT * FROM subscribers ORDER BY subscribed_at DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>
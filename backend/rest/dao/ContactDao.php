<?php
require_once 'BaseDao.php';

class ContactDao extends BaseDao {
    public function __construct() {
        parent::__construct("contacts");
    }

    public function getByEmail($email) {
        $stmt = $this->connection->prepare("SELECT * FROM contacts WHERE email = :email ORDER BY submitted_at DESC");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getRecentContacts($limit = 10) {
        $stmt = $this->connection->prepare("SELECT * FROM contacts ORDER BY submitted_at DESC LIMIT :limit");
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>
<?php
require_once __DIR__ . '/../dao/ContactDao.php';

class ContactService extends BaseService {
    public function __construct() {
        parent::__construct(new ContactDao());
    }
}
?>
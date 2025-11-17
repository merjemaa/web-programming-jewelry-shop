<?php
require_once __DIR__ . '/../dao/CategoryDao.php';

class CategoryService extends BaseService {
    public function __construct() {
        parent::__construct(new CategoryDao());
    }
}
?>
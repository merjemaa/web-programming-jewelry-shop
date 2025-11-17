<?php
require_once __DIR__ . '/../dao/ProductDao.php';

class ProductService extends BaseService {
    public function __construct() {
        parent::__construct(new ProductDao());
    }
}
?>
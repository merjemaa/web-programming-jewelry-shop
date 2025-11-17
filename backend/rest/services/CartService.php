<?php
require_once __DIR__ . '/../dao/CartDao.php';

class CartService extends BaseService {
    public function __construct() {
        parent::__construct(new CartDao());
    }
}
?>
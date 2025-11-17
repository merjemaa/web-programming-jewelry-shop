<?php
require_once __DIR__ . '/../dao/OrderItemDao.php';

class OrderItemService extends BaseService {
    public function __construct() {
        parent::__construct(new OrderItemDao());
    }
}
?>
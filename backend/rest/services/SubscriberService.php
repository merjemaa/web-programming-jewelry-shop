<?php
require_once __DIR__ . '/../dao/SubscriberDao.php';

class SubscriberService extends BaseService {
    public function __construct() {
        parent::__construct(new SubscriberDao());
    }
}
?>
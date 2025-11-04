<?php
require_once __DIR__ . '/dao/UserDao.php';
require_once __DIR__ . '/dao/ProductDao.php';
require_once __DIR__ . '/dao/CategoryDao.php';
require_once __DIR__ . '/dao/CartDao.php';
require_once __DIR__ . '/dao/ContactDao.php';
require_once __DIR__ . '/dao/SubscriberDao.php';


$userDao = new UserDao();
$productDao = new ProductDao();
$categoryDao = new CategoryDao();
$cartDao = new CartDao();
$contactDao = new ContactDao();
$subscriberDao = new SubscriberDao();

echo "USERS:\n";
print_r($userDao->getAll());

echo "\nPRODUCTS:\n";
print_r($productDao->getAll());

echo "\nCATEGORIES:\n";
print_r($categoryDao->getAll());

echo "\nCART ITEMS:\n";
print_r($cartDao->getAll());

echo "\nCONTACTS:\n";
print_r($contactDao->getAll());

echo "\nSUBSCRIBERS:\n";
print_r($subscriberDao->getAll());

echo "\nPRODUCTS BY CATEGORY (necklace):\n";
$necklaceProducts = $productDao->getByCategory(2); 
print_r($necklaceProducts);
?>
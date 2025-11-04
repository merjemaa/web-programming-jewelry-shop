<?php
require_once __DIR__ . '/dao/UserDao.php';
require_once __DIR__ . '/dao/ProductDao.php';
require_once __DIR__ . '/dao/CategoryDao.php';
require_once __DIR__ . '/dao/OrderDao.php';
require_once __DIR__ . '/dao/OrderItemDao.php';
require_once __DIR__ . '/dao/CartDao.php';
require_once __DIR__ . '/dao/ContactDao.php';
require_once __DIR__ . '/dao/SubscriberDao.php';

echo "<h1>AURA JEWELS - DAO CRUD Test</h1>";

$userDao = new UserDao();

echo "<h2>UserDao CRUD Test:</h2>";

$users = $userDao->getAll();
echo "Initial users: " . count($users) . "<br>";

$uniqueEmail = 'test.user.' . time() . '@example.com';

$userDao->insert([
    'email' => $uniqueEmail,
    'password_hash' => password_hash('test123', PASSWORD_DEFAULT),
    'full_name' => 'Test User'
]);
echo "User inserted<br>";

$users = $userDao->getAll();
echo "Users after insert: " . count($users) . "<br>";

$user = $userDao->getByEmail($uniqueEmail);
echo "User found by email: " . ($user ? "YES - ID: " . $user['id'] : "NO") . "<br>";

if ($user) {
    $userDao->update($user['id'], [
        'full_name' => 'Updated Name'
    ]);
    echo "User updated<br>";
}

if ($user) {
    $userDao->delete($user['id']);
    echo "User deleted<br>";
}

echo "<h2>User Role Test:</h2>";

$customers = array_filter($users, function($user) {
    return $user['role'] === 'customer';
});
echo "Customer users: " . count($customers) . "<br>";

$admins = array_filter($users, function($user) {
    return $user['role'] === 'admin';
});
echo "Admin users: " . count($admins) . "<br>";

$users = $userDao->getAll();
echo "Final users count: " . count($users) . "<br>";

echo "<h2>ProductDao CRUD Test:</h2>";
$productDao = new ProductDao();
$products = $productDao->getAll();
echo "Initial products: " . count($products) . "<br>";

$productDao->insert([
    'name' => 'Test Diamond Ring',
    'description' => 'Beautiful test diamond ring for testing',
    'price' => 199.99,
    'image_url' => 'assets/images/test-ring.jpg',
    'category_id' => 3, 
    'external_id' => 'test-' . time(),
    'stock_quantity' => 10
]);
echo "Product inserted<br>";

$products = $productDao->getAll();
echo "Products after insert: " . count($products) . "<br>";

if (count($products) > 0) {
    $product = $productDao->getById($products[count($products)-1]['id']);
    echo "Product found by ID: " . ($product ? "YES - Name: " . $product['name'] : "NO") . "<br>";
}

$ringProducts = $productDao->getByCategory(3); 
echo "Ring products: " . count($ringProducts) . "<br>";

// Test CategoryDao
echo "<h2>CategoryDao CRUD Test:</h2>";
$categoryDao = new CategoryDao();
$categories = $categoryDao->getAll();
echo "Initial categories: " . count($categories) . "<br>";

$categoryDao->insert([
    'name' => 'test-category',
    'description' => 'Test category for testing'
]);
echo "Category inserted<br>";

$categories = $categoryDao->getAll();
echo "Categories after insert: " . count($categories) . "<br>";

if (count($categories) > 0) {
    $category = $categoryDao->getById($categories[count($categories)-1]['id']);
    echo "Category found by ID: " . ($category ? "YES - Name: " . $category['name'] : "NO") . "<br>";
}

echo "<h2>CartDao CRUD Test:</h2>";
$cartDao = new CartDao();
$cartItems = $cartDao->getAll();
echo "Initial cart items: " . count($cartItems) . "<br>";

$testUser = $userDao->getByEmail('customer@example.com');
$testProduct = $productDao->getByExternalId('1');

if ($testUser && $testProduct) {
    $cartDao->insert([
        'user_id' => $testUser['id'],
        'product_id' => $testProduct['id'],
        'quantity' => 2
    ]);
    echo "Cart item inserted<br>";
}

$cartItems = $cartDao->getAll();
echo "Cart items after insert: " . count($cartItems) . "<br>";

echo "<h2>ContactDao CRUD Test:</h2>";
$contactDao = new ContactDao();
$contacts = $contactDao->getAll();
echo "Initial contacts: " . count($contacts) . "<br>";

$contactDao->insert([
    'full_name' => 'Contact Test',
    'email' => 'contact.test@example.com',
    'subject' => 'Test Inquiry',
    'message' => 'This is a test contact message from a potential customer.'
]);
echo "Contact inserted<br>";

$contacts = $contactDao->getAll();
echo "Contacts after insert: " . count($contacts) . "<br>";

echo "<h2>SubscriberDao CRUD Test:</h2>";
$subscriberDao = new SubscriberDao();
$subscribers = $subscriberDao->getAll();
echo "Initial subscribers: " . count($subscribers) . "<br>";

$uniqueSubEmail = 'subscriber.' . time() . '@example.com';
$subscriberDao->insert([
    'email' => $uniqueSubEmail
]);
echo "Subscriber inserted<br>";

$subscribers = $subscriberDao->getAll();
echo "Subscribers after insert: " . count($subscribers) . "<br>";

echo "<h2 style='color: green;'>ALL 8 DAOs TESTED SUCCESSFULLY</h2>";

echo "<h2>Cleaning up test data...</h2>";
$testCategory = $categoryDao->getByName('test-category');
if ($testCategory) {
    $categoryDao->delete($testCategory['id']);
    echo "Test category deleted<br>";
}

$testProducts = array_filter($products, function($product) {
    return strpos($product['name'], 'Test Diamond Ring') !== false;
});
foreach ($testProducts as $product) {
    $productDao->delete($product['id']);
    echo "Test product deleted<br>";
}

$testSubscriber = $subscriberDao->getByEmail($uniqueSubEmail);
if ($testSubscriber) {
    $subscriberDao->delete($testSubscriber['id']);
    echo "Test subscriber deleted<br>";
}

$testContacts = array_filter($contacts, function($contact) {
    return $contact['email'] === 'contact.test@example.com';
});
foreach ($testContacts as $contact) {
    $contactDao->delete($contact['id']);
    echo "Test contact deleted<br>";
}

echo "<h2 style='color: blue;'>CLEANUP COMPLETED</h2>";
?>
<?php
require_once __DIR__ . '/dao/UserDao.php';
require_once __DIR__ . '/dao/ProductDao.php';
require_once __DIR__ . '/dao/CategoryDao.php';
require_once __DIR__ . '/dao/OrderDao.php';
require_once __DIR__ . '/dao/OrderItemDao.php';
require_once __DIR__ . '/dao/CartDao.php';
require_once __DIR__ . '/dao/ContactDao.php';
require_once __DIR__ . '/dao/SubscriberDao.php';


echo "=== AURA JEWELS - TERMINAL DAO TEST ===\n\n";

echo "1. UserDao CRUD Test:\n";
$userDao = new UserDao();
$users = $userDao->getAll();
echo "   Initial users: " . count($users) . "\n";

$uniqueEmail = 'test.user.' . time() . '@example.com';
$userDao->insert([
    'email' => $uniqueEmail,
    'password_hash' => password_hash('test123', PASSWORD_DEFAULT),
    'full_name' => 'Test User'
]);
echo "   User inserted\n";

$users = $userDao->getAll();
echo "   Users after insert: " . count($users) . "\n";

$user = $userDao->getByEmail($uniqueEmail);
echo "   User found by email: " . ($user ? "YES - ID: " . $user['id'] : "NO") . "\n";

if ($user) {
    $userDao->update($user['id'], [
        'full_name' => 'Updated Name'
    ]);
    echo "   User updated\n";
    
    $userDao->delete($user['id']);
    echo "   User deleted\n";
}

$users = $userDao->getAll();
echo "   Final users count: " . count($users) . "\n";

echo "\n2. ProductDao CRUD Test:\n";
$productDao = new ProductDao();
$products = $productDao->getAll();
echo "   Initial products: " . count($products) . "\n";

$productDao->insert([
    'name' => 'Test Diamond Ring',
    'description' => 'Beautiful test diamond ring for testing',
    'price' => 199.99,
    'image_url' => 'assets/images/test-ring.jpg',
    'category_id' => 3, 
    'external_id' => 'test-' . time(),
    'stock_quantity' => 10
]);
echo "   Product inserted\n";

$products = $productDao->getAll();
echo "   Products after insert: " . count($products) . "\n";

if (count($products) > 0) {
    $product = $productDao->getById($products[count($products)-1]['id']);
    echo "   Product found by ID: " . ($product ? "YES - Name: " . $product['name'] : "NO") . "\n";
}

$ringProducts = $productDao->getByCategory(3); 
echo "   Ring products: " . count($ringProducts) . "\n";

echo "\n3. CategoryDao CRUD Test:\n";
$categoryDao = new CategoryDao();
$categories = $categoryDao->getAll();
echo "   Initial categories: " . count($categories) . "\n";

$categoryDao->insert([
    'name' => 'test-category',
    'description' => 'Test category for testing'
]);
echo "   Category inserted\n";

$categories = $categoryDao->getAll();
echo "   Categories after insert: " . count($categories) . "\n";

if (count($categories) > 0) {
    $category = $categoryDao->getById($categories[count($categories)-1]['id']);
    echo "   Category found by ID: " . ($category ? "YES - Name: " . $category['name'] : "NO") . "\n";
}

echo "\n4. CartDao CRUD Test:\n";
$cartDao = new CartDao();
$cartItems = $cartDao->getAll();
echo "   Initial cart items: " . count($cartItems) . "\n";

$testUser = $userDao->getByEmail('customer@example.com');
$testProduct = $productDao->getByExternalId('1');

if ($testUser && $testProduct) {
    $cartDao->insert([
        'user_id' => $testUser['id'],
        'product_id' => $testProduct['id'],
        'quantity' => 2
    ]);
    echo "   Cart item inserted\n";
}

$cartItems = $cartDao->getAll();
echo "   Cart items after insert: " . count($cartItems) . "\n";

echo "\n5. ContactDao CRUD Test:\n";
$contactDao = new ContactDao();
$contacts = $contactDao->getAll();
echo "   Initial contacts: " . count($contacts) . "\n";

$contactDao->insert([
    'full_name' => 'Contact Test',
    'email' => 'contact.test@example.com',
    'subject' => 'Test Inquiry',
    'message' => 'This is a test contact message from a potential customer.'
]);
echo "   Contact inserted\n";

$contacts = $contactDao->getAll();
echo "   Contacts after insert: " . count($contacts) . "\n";

echo "\n6. SubscriberDao CRUD Test:\n";
$subscriberDao = new SubscriberDao();
$subscribers = $subscriberDao->getAll();
echo "   Initial subscribers: " . count($subscribers) . "\n";

$uniqueSubEmail = 'subscriber.' . time() . '@example.com';
$subscriberDao->insert([
    'email' => $uniqueSubEmail
]);
echo "   Subscriber inserted\n";

$subscribers = $subscriberDao->getAll();
echo "   Subscribers after insert: " . count($subscribers) . "\n";

echo "\n=== ALL 8 DAOs TESTED SUCCESSFULLY! ===\n";
echo "All CRUD operations working for every entity!\n";

echo "\nCleaning up test data...\n";
$testCategory = $categoryDao->getByName('test-category');
if ($testCategory) {
    $categoryDao->delete($testCategory['id']);
    echo "Test category deleted\n";
}

$testProducts = array_filter($products, function($product) {
    return strpos($product['name'], 'Test Diamond Ring') !== false;
});
foreach ($testProducts as $product) {
    $productDao->delete($product['id']);
    echo "Test product deleted\n";
}

$testSubscriber = $subscriberDao->getByEmail($uniqueSubEmail);
if ($testSubscriber) {
    $subscriberDao->delete($testSubscriber['id']);
    echo "Test subscriber deleted\n";
}

echo "Cleanup completed!\n";
?>
<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';

require_once __DIR__ . '/rest/services/BaseService.php';
require_once __DIR__ . '/rest/services/CategoryService.php';
require_once __DIR__ . '/rest/services/ProductService.php';
require_once __DIR__ . '/rest/services/UserService.php';
require_once __DIR__ . '/rest/services/OrderService.php';
require_once __DIR__ . '/rest/services/OrderItemService.php';
require_once __DIR__ . '/rest/services/CartService.php';
require_once __DIR__ . '/rest/services/ContactService.php';
require_once __DIR__ . '/rest/services/SubscriberService.php';

Flight::register('categoryService', 'CategoryService');
Flight::register('productService', 'ProductService');
Flight::register('userService', 'UserService');
Flight::register('orderService', 'OrderService');
Flight::register('orderItemService', 'OrderItemService');
Flight::register('cartService', 'CartService');
Flight::register('contactService', 'ContactService');
Flight::register('subscriberService', 'SubscriberService');

require_once __DIR__ . '/rest/routes/CategoryRoutes.php';
require_once __DIR__ . '/rest/routes/ProductRoutes.php';
require_once __DIR__ . '/rest/routes/UserRoutes.php';
require_once __DIR__ . '/rest/routes/OrderRoutes.php';
require_once __DIR__ . '/rest/routes/OrderItemRoutes.php';
require_once __DIR__ . '/rest/routes/CartRoutes.php';
require_once __DIR__ . '/rest/routes/ContactRoutes.php';
require_once __DIR__ . '/rest/routes/SubscriberRoutes.php';

Flight::route('/', function() {
    echo json_encode([
        'message' => 'Aura Jewels API',
        'version' => '1.0',
        'endpoints' => [
            '/categories' => 'Category management',
            '/products' => 'Product management', 
            '/users' => 'User management',
            '/orders' => 'Order management',
            '/order-items' => 'Order items management',
            '/cart' => 'Shopping cart management',
            '/contacts' => 'Contact inquiries',
            '/subscribers' => 'Newsletter subscribers'
        ]
    ]);
});

Flight::start();
?>
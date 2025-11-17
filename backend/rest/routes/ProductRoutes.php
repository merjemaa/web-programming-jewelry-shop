<?php
Flight::route('GET /products', function(){
    $productService = new ProductService();
    $products = $productService->get_all();
    echo json_encode($products);
});

Flight::route('GET /products/active', function(){
    $productService = new ProductService();
    $products = $productService->get_active_products();
    echo json_encode($products);
});

Flight::route('GET /products/@id', function($id){
    $productService = new ProductService();
    $product = $productService->get_by_id($id);
    echo json_encode($product);
});

Flight::route('GET /products/category/@category_id', function($category_id){
    $productService = new ProductService();
    $products = $productService->get_by_category($category_id);
    echo json_encode($products);
});

Flight::route('POST /products', function(){
    $data = Flight::request()->data->getData();
    $productService = new ProductService();
    $result = $productService->add($data);
    echo json_encode(['success' => $result]);
});

Flight::route('PUT /products/@id', function($id){
    $data = Flight::request()->data->getData();
    $productService = new ProductService();
    $result = $productService->update($id, $data);
    echo json_encode(['success' => $result]);
});

Flight::route('DELETE /products/@id', function($id){
    $productService = new ProductService();
    $result = $productService->delete($id);
    echo json_encode(['success' => $result]);
});
?>
<?php
Flight::route('GET /cart/user/@user_id', function($user_id){
    $cartService = new CartService();
    $cartItems = $cartService->get_by_user($user_id);
    echo json_encode($cartItems);
});

Flight::route('POST /cart', function(){
    $data = Flight::request()->data->getData();
    $cartService = new CartService();
    $result = $cartService->add($data);
    echo json_encode(['success' => $result]);
});

Flight::route('POST /cart/add', function(){
    $data = Flight::request()->data->getData();
    $cartService = new CartService();
    $result = $cartService->add_to_cart($data['user_id'], $data['product_id'], $data['quantity'] ?? 1);
    echo json_encode(['success' => $result]);
});

Flight::route('PUT /cart/@id', function($id){
    $data = Flight::request()->data->getData();
    $cartService = new CartService();
    $result = $cartService->update($id, $data);
    echo json_encode(['success' => $result]);
});

Flight::route('DELETE /cart/@id', function($id){
    $cartService = new CartService();
    $result = $cartService->delete($id);
    echo json_encode(['success' => $result]);
});
?>
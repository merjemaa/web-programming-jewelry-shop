<?php
Flight::route('GET /orders', function(){
    $orderService = new OrderService();
    $orders = $orderService->get_all();
    echo json_encode($orders);
});

Flight::route('GET /orders/@id', function($id){
    $orderService = new OrderService();
    $order = $orderService->get_by_id($id);
    echo json_encode($order);
});

Flight::route('GET /orders/user/@user_id', function($user_id){
    $orderService = new OrderService();
    $orders = $orderService->get_by_user($user_id);
    echo json_encode($orders);
});

Flight::route('POST /orders', function(){
    $data = Flight::request()->data->getData();
    $orderService = new OrderService();
    $result = $orderService->add($data);
    echo json_encode(['success' => $result]);
});

Flight::route('PUT /orders/@id', function($id){
    $data = Flight::request()->data->getData();
    $orderService = new OrderService();
    $result = $orderService->update($id, $data);
    echo json_encode(['success' => $result]);
});

Flight::route('DELETE /orders/@id', function($id){
    $orderService = new OrderService();
    $result = $orderService->delete($id);
    echo json_encode(['success' => $result]);
});
?>
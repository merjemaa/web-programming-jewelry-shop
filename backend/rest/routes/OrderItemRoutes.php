<?php
Flight::route('GET /order-items', function(){
    $orderItemService = new OrderItemService();
    $orderItems = $orderItemService->get_all();
    echo json_encode($orderItems);
});

Flight::route('GET /order-items/@id', function($id){
    $orderItemService = new OrderItemService();
    $orderItem = $orderItemService->get_by_id($id);
    echo json_encode($orderItem);
});

Flight::route('GET /order-items/order/@order_id', function($order_id){
    $orderItemService = new OrderItemService();
    $orderItems = $orderItemService->get_by_order($order_id);
    echo json_encode($orderItems);
});

Flight::route('POST /order-items', function(){
    $data = Flight::request()->data->getData();
    $orderItemService = new OrderItemService();
    $result = $orderItemService->add($data);
    echo json_encode(['success' => $result]);
});

Flight::route('PUT /order-items/@id', function($id){
    $data = Flight::request()->data->getData();
    $orderItemService = new OrderItemService();
    $result = $orderItemService->update($id, $data);
    echo json_encode(['success' => $result]);
});

Flight::route('DELETE /order-items/@id', function($id){
    $orderItemService = new OrderItemService();
    $result = $orderItemService->delete($id);
    echo json_encode(['success' => $result]);
});
?>
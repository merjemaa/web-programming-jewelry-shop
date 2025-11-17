<?php
Flight::route('GET /subscribers', function(){
    $subscriberService = new SubscriberService();
    $subscribers = $subscriberService->get_all();
    echo json_encode($subscribers);
});

Flight::route('GET /subscribers/@id', function($id){
    $subscriberService = new SubscriberService();
    $subscriber = $subscriberService->get_by_id($id);
    echo json_encode($subscriber);
});

Flight::route('GET /subscribers/email/@email', function($email){
    $subscriberService = new SubscriberService();
    $subscriber = $subscriberService->get_by_email($email);
    echo json_encode($subscriber);
});

Flight::route('POST /subscribers', function(){
    $data = Flight::request()->data->getData();
    $subscriberService = new SubscriberService();
    $result = $subscriberService->add($data);
    echo json_encode(['success' => $result]);
});

Flight::route('PUT /subscribers/@id', function($id){
    $data = Flight::request()->data->getData();
    $subscriberService = new SubscriberService();
    $result = $subscriberService->update($id, $data);
    echo json_encode(['success' => $result]);
});

Flight::route('DELETE /subscribers/@id', function($id){
    $subscriberService = new SubscriberService();
    $result = $subscriberService->delete($id);
    echo json_encode(['success' => $result]);
});
?>
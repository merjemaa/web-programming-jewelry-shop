<?php
Flight::route('GET /contacts', function(){
    $contactService = new ContactService();
    $contacts = $contactService->get_all();
    echo json_encode($contacts);
});

Flight::route('GET /contacts/recent', function(){
    $contactService = new ContactService();
    $contacts = $contactService->get_recent_submissions();
    echo json_encode($contacts);
});

Flight::route('GET /contacts/@id', function($id){
    $contactService = new ContactService();
    $contact = $contactService->get_by_id($id);
    echo json_encode($contact);
});

Flight::route('POST /contacts', function(){
    $data = Flight::request()->data->getData();
    $contactService = new ContactService();
    $result = $contactService->add($data);
    echo json_encode(['success' => $result]);
});

Flight::route('PUT /contacts/@id', function($id){
    $data = Flight::request()->data->getData();
    $contactService = new ContactService();
    $result = $contactService->update($id, $data);
    echo json_encode(['success' => $result]);
});

Flight::route('DELETE /contacts/@id', function($id){
    $contactService = new ContactService();
    $result = $contactService->delete($id);
    echo json_encode(['success' => $result]);
});
?>
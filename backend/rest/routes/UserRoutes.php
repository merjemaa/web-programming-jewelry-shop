<?php
Flight::route('GET /users', function(){
    $userService = new UserService();
    $users = $userService->get_all();
    echo json_encode($users);
});

Flight::route('GET /users/@id', function($id){
    $userService = new UserService();
    $user = $userService->get_by_id($id);
    echo json_encode($user);
});

Flight::route('GET /users/email/@email', function($email){
    $userService = new UserService();
    $user = $userService->get_by_email($email);
    echo json_encode($user);
});

Flight::route('POST /users', function(){
    $data = Flight::request()->data->getData();
    $userService = new UserService();
    $result = $userService->add($data);
    echo json_encode(['success' => $result]);
});

Flight::route('PUT /users/@id', function($id){
    $data = Flight::request()->data->getData();
    $userService = new UserService();
    $result = $userService->update($id, $data);
    echo json_encode(['success' => $result]);
});

Flight::route('DELETE /users/@id', function($id){
    $userService = new UserService();
    $result = $userService->delete($id);
    echo json_encode(['success' => $result]);
});
?>
<?php
Flight::route('GET /categories', function(){
    $categoryService = Flight::categoryService();
    $categories = $categoryService->get_all();
    echo json_encode($categories);
});

Flight::route('GET /categories/@id', function($id){
    $categoryService = Flight::categoryService();
    $category = $categoryService->get_by_id($id);
    echo json_encode($category);
});

Flight::route('POST /categories', function(){
    $data = Flight::request()->data->getData();
    $categoryService = Flight::categoryService();
    $result = $categoryService->add($data);
    echo json_encode(['success' => $result]);
});

Flight::route('PUT /categories/@id', function($id){
    $data = Flight::request()->data->getData();
    $categoryService = Flight::categoryService();
    $result = $categoryService->update($id, $data);
    echo json_encode(['success' => $result]);
});

Flight::route('DELETE /categories/@id', function($id){
    $categoryService = Flight::categoryService();
    $result = $categoryService->delete($id);
    echo json_encode(['success' => $result]);
});
?>
<?php 
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $id = $_POST["id"];
    $response = [
        'success'=>true,
        'message' => "suc ".$id,
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

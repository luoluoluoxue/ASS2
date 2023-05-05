<?php

$host = 'localhost';

$username = 'root';
$password = '';
$dbName = 'ass2';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);
} catch (PDOException $e) {
    $response["code"] = 404;
    $response["message"] = "Failed to connect to database";
    echo json_encode($response);
    exit;
}

//  2: Get store information
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $query = "SELECT id, store_nickname AS name, store_description AS description FROM tb_store_info WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$id]);

    $store_info = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$store_info) {
    $response["code"] = 404;

    echo json_encode($response);

    }
    $data["id"]=$store_info["id"];
    $data["name"]=$store_info["name"];
    $data["description"]=$store_info["description"];
    $response['data'] = $data;
    $response['code'] = 200;
    $response['message'] = "Show all store information successfully";
    echo json_encode($response);
}
    

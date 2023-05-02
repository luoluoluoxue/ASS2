<?php

$host = 'localhost';

$username = 'root';
$password = '';
$dbName = 'ass2';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);
} catch (PDOException $e) {
    die("Failed to connect to the database: " . $e->getMessage());
}

//  2: Get store information
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $query = "SELECT id, store_nickname AS name, store_description AS description FROM tb_store_info WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$id]);

    $store_info = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$store_info) {
        http_response_code(404);
        die();
    }

    http_response_code(200);
    header('Content-Type: application/json');
    echo json_encode($store_info);
}

// Interface 3: Update store information
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $name = $_POST['name'];
    $description = $_POST['description'];

    $query = "UPDATE tb_store_info SET store_nickname = ?, store_description = ? WHERE id = ?";
    $stmt = $db->prepare($query);

    if ($stmt->execute([$name, $description, $id])) {
        http_response_code(200);
    } else {
        http_response_code(404);
    }
}

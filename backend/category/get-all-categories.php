<?php

// get all categories
// get up database connection

$host= "localhost";
$username = "root";
$password = "";
$dbName = "ass2";


try {
    $conn = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
      http_response_code(500);
    echo json_encode(['error' => 'Failed to connect to database: ' . $e->getMessage()]);
    exit;
}

//The total number of categories
$totalCount = $conn->query("SELECT COUNT(*) FROM tb_category")->fetchColumn();

// all categories and product counts
$stmt = $conn->query("SELECT tb_category.id, tb_category.name, COUNT(tb_item.id) AS productNumber FROM tb_category LEFT JOIN tb_item ON tb_category.id = tb_item.category_id GROUP BY tb_category.id");

if ($stmt->rowCount() > 0) {
 
    $response = array();
    $response['list'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $response['total'] = $totalCount;

 
    header('Content-Type: application/json');
    http_response_code(200);
    echo json_encode($response);
} else {
  
    header('Content-Type: application/json');
    http_response_code(404);
    echo json_encode(array('message' => 'No categories found'));
}
?>

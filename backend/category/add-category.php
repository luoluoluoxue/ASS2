<?php

//add category
// Set up database connection
$host = "localhost";
$username = "root";
$password = "";
$dbName = "ass2";

try {
$conn = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(404);
    echo json_encode(['error' => 'Failed to connect to database: ' . $e->getMessage()]);
    exit;
}

// Check if name parameter exists in request 
if (isset($_POST['name'])) {
    $name = $_POST['name'];

    $check="SELECT COUNT(*) FROM tb_category WHERE name = ?";

    $stmt = $conn->prepare($check);
    $stmt->execute([$name]);
    $count = $stmt->fetchColumn();
    //echo json_encode($count);


    // Check whether the category already exists
    if ($count>0){
        header('Content-Type: application/json');
        http_response_code(404); 
        echo json_encode(array('message' => 'This category already exists '));
        exit;
    }
    $sql="INSERT INTO tb_category (name) VALUES (?)";
    $stmts = $conn->prepare($sql);
    //$stmts = $conn->query($sql);
    $stmts->execute([$name]);
      
    header('Content-Type: application/json');
    http_response_code(200);
    echo json_encode(array('message' => 'Category added successfully'));
} else {
      
    header('Content-Type: application/json');
    http_response_code(404);
    echo json_encode(array('message' => 'Missing required parameter: name'));
}
?>

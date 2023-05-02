<?php
// Set up database connection
$host = "localhost";
$username = "root";
$password = "";
$dbName = "ass2";


$conn = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Check if name parameter exists in request body
if (isset($_POST['name'])) {
    $name = $_POST['name'];

    
    $stmt = $conn->query("INSERT INTO tb_category (name) VALUES (?)");
    $stmt->execute([$name]);
      
    header('Content-Type: application/json');
    http_response_code(200);
    echo json_encode(array('message' => 'Category added successfully'));
} else {
      
    header('Content-Type: application/json');
    http_response_code(404);
    echo json_encode(array('message' => 'Missing required parameter: name'));
}
?>

<?php
// Set up database connection
$host = "localhost";
$username = "root";
$password = "";
$dbName = "ass2";


$conn = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Check if id and name parameters exist in request body
if (isset($_POST['id']) && isset($_POST['name'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];

    // Update the category in the database
    $stmt = $conn->prepare("UPDATE tb_category SET name = ? WHERE id = ?");
    $stmt->execute([$name, $id]);

  
    header('Content-Type: application/json');
    http_response_code(200);
    echo json_encode(array('message' => 'Category updated successfully'));
} else {
        
    header('Content-Type: application/json');
    http_response_code(404);
    echo json_encode(array('message' => 'Missing required parameters: id and/or name'));
}

?>

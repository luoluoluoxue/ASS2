<?php
// Establish database connection
$host = "localhost";
$dbName = "ass2";
$username = "root";
$password = "";

$db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (!isset($_GET['id'])) {
    http_response_code(404); 
    die("Error: 'id' parameter is missing");
}

$sql = "DELETE FROM tb_category WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(":id", $_GET['id']);

if ($stmt->execute()) {
    http_response_code(200); 
    echo "Category deleted successfully";
} else {
    http_response_code(404); 
    echo "Error: Category not found or could not be deleted";
}

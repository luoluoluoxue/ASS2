<?php
// Set up database connection
$host = "localhost";
$username = "root";
$password = "";
$dbName = "ass2";

try{
$conn = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (PDOException $e){
    $response["code"] = 404;
    $response["message"] = "Failed to connect to database";
    echo json_encode($response);
    exit;
}

// get the raw POST data
$postData = file_get_contents("php://input");

// decode the JSON data
$data = json_decode($postData);

// access the decoded data as a PHP object
$name = $data->name;
$id = $data->id;

// Check if id and name parameters exist in request body
if (!empty($id)&& !empty($name)) {


    // Update the category in the database
    $stmt = $conn->prepare("UPDATE tb_category SET name = ? WHERE id = ?");
    $stmt->execute([$name, $id]);

    $response['code'] = 200;
    $response['message'] = "Category updated successfully";
    echo json_encode($response);
} else {
    $response["code"] = 404;
    $response["message"] = "Missing required parameters: id and/or name";
    echo json_encode($response);   
}

?>

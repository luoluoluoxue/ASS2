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
// get the raw POST data
$postData = file_get_contents("php://input");

// decode the JSON data
$data = json_decode($postData);

// access the decoded data as a PHP object
    $id = $data->id;
    $name = $data->name;
    $description = $data->description;

    if (!empty($id)&&!empty($name)&&!empty($description)) {

    $query = "UPDATE tb_store_info SET store_nickname = ? , store_description = ? WHERE id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt->execute([$name,$description,$id])) {
    $response['code'] = 200;
    $response['message'] = "Update store successfully";
     echo json_encode($response);

    } else {

        $response['code'] = 404;
    $response['message'] = "Update store wrong";
     echo json_encode($response);

    }
}

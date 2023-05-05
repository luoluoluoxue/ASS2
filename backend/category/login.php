<?php

$host = "localhost";
$username = "root";
$password = "";
$dbName = "ass2";



// 连接数据库
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);
}catch (PDOException $e) {
    $response["code"] = 404;
    $response["message"] = "Failed to connect to database";
    echo json_encode($response);
    exit;
}

// get the raw POST data
$postData = file_get_contents("php://input");

// decode the JSON data
$data = json_decode($postData);
$name = $data->username;
// access the decoded data as a PHP object
$pass = $data->password;


$sql = 'SELECT id, username FROM tb_user WHERE username = :username AND password = :password';
$stmt = $conn->prepare($sql);
$stmt->bindParam(':username', $name);
$stmt->bindParam(':password', $pass);


if ($stmt->execute()) {
 
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $response["id"]=$user["id"];
    $response["username"]=$user["username"];
    if ($user) {

    $response["code"] = 200;
    $response["message"] = "Username and password is match successfully";
    echo json_encode($response);

        exit();
    } else {
    $response["code"] = 404;
    $response["message"] = "Username and password is not match successfully";
    echo json_encode($response);
        exit();
    }
} else {
     $response["code"] = 404;
       echo json_encode($response);
    $response["message"] = "Database query error";

    exit();
}

?>

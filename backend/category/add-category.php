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

// Check if name parameter exists in request 
if (!empty($name)) {
   
    $check="SELECT COUNT(*) FROM tb_category WHERE name = '$name'";
    $stmt = $conn->prepare($check);
    $stmt->execute();
    $count = $stmt->fetchColumn();


    // Check whether the category already exists
    if ($count>0){

        $response["code"] = 404;
        $response["message"] = "This category already exists";
        echo json_encode($response);
        exit;
    }
    $sql="INSERT INTO tb_category (name) VALUES (?)";
    $stmts = $conn->prepare($sql);
    $stmts=$stmts->execute([$name]);
    if ($stmts!=false){
        $response["code"] = 200;
    $response["message"] = "Category added successfully";
    $response["state"]=$stmts;
    echo json_encode($response);
    exit;

    }else {
}   $response["code"] = 404;
    $response["message"] = "false";
    $response["state"]=$stmts;
    echo json_encode($response);

} else {
    
    $response["code"] = 404;
    $response["message"] = "Missing required parameter: name";
    echo json_encode($response);

}
?>

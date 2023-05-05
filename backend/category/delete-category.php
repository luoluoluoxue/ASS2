<?php
// Establish database connection
$host = "localhost";
$dbName = "ass2";
$username = "root";
$password = "";

try {
$conn = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    $response["code"] = 404;
    $response["message"] = "Failed to connect to database";
    echo json_encode($response);
    exit;
}
$id=$_GET['id'];
if (!empty($id)){

    $sql = "DELETE FROM tb_category WHERE id =$id";

    //$count="SELECT COUNT(tb_item.id) AS productNumber FROM tb_category LEFT JOIN tb_item ON tb_category.id = tb_item.category_id GROUP BY tb_category.id";
    $count="SELECT COUNT(*) FROM tb_item WHERE category_id = $id";
    $test=$conn->query($count);


    if ($test->fetchColumn()>0){
    $response["code"] = 404;
    $response["data"]=$test->fetchColumn();
    $response["message"] = "Some products use this category, please modify them first";
    echo json_encode($response);
        exit;
    }   
        $stmt = $conn->query($sql);
        $stmt->execute();
        $response["code"] = 200;
        $response["message"] = "Category deleted successfully";
        echo json_encode($response);
} else {
    $response["code"] = 404;
    $response["message"] = "Category not found or could not be deleted";
    echo json_encode($response);

}

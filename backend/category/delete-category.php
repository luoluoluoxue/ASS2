<?php
// Establish database connection
$host = "localhost";
$dbName = "ass2";
$username = "root";
$password = "";

try {
$conn = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}catch (PDOException $e) {
    http_response_code(404);
    echo json_encode(['error' => 'Failed to connect to database: ' . $e->getMessage()]);
    exit;
}

if (isset($_POST['id'])) {

    $id=$_POST['id'];
    $sql = "DELETE FROM tb_category WHERE id =$id";

//$stmt = $conn->prepare($sql);
//$stmt->bindParam(":id", $_GET['id']);

    $count="SELECT COUNT(tb_item.id) AS productNumber FROM tb_category LEFT JOIN tb_item ON tb_category.id = tb_item.category_id GROUP BY tb_category.id";
    $test=$conn->query($count);


    if ($test->fetchColumn()>0){
        header('Content-Type: application/json');
        http_response_code(404); 
        echo json_encode(array('message' => 'Some products use this category, please modify them first '));
        exit;
    }   
        $stmt = $conn->query($sql);
        $stmt->execute();
        header('Content-Type: application/json');
        http_response_code(200); 
        echo json_encode(array('message' => 'Category deleted successfully'));

        //echo "Category deleted successfully";
} else {
    header('Content-Type: application/json');
    http_response_code(404); 
    //echo "Error: Category not found or could not be deleted";
    echo json_encode(array('message' => 'Category not found or could not be deleted'));
}

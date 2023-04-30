<?php

//open database by PDO

$dbms='mysql';     //DBMS type
$host='localhost'; //Host name
$dbName='lab2';    //database name
$user='root';      //database user
$pass='';          //database password
$dsn="$dbms:host=$host;dbname=$dbName";

//这里面数据库名字字段啥的都是胡写的 到时候再改
try {
    $con = new PDO("mysql:host=localhost; dbname=can302ass","root",""); 
} catch (PDOException $e) {
    die ("Error!: " . $e->getMessage() . "<br/>");
}


//a safe method to recieve post data
function mypost($str) { 
    $val = !empty($_POST[$str]) ? $_POST[$str] : '';
    return $val;
}       

//约束大概是 user-coupon coupon_hold(user)--coupon_id(coupon)
//receive query parameters.
$user_id = mypost('user_id');
$coupon_hold = mypost('coupon_hold');
$c_name=mypost('c_name');

//add the received data to database
if (isset($_POST['add'])) {
    $sql = "INSERT INTO `user` (`user_id`, `coupon_hold`) VALUES (NULL, '".$coupon_hold."');set @auto_id = 0;UPDATE user set user_id = (@auto_id := @auto_id +1);
    ALTER TABLE user AUTO_INCREMENT = 1; ";
    $query1=$con->exec($sql);
     if($query1){
        echo "add success";
    }else{
        echo "Error: add " ;
    }
    $sql = "SELECT *, c_name FROM user, coupon where user.coupon_hold = coupon.`Coupon_id`";
    $query = $con->query($sql);
} 

//query the data from database
if (isset($_POST['search'])) {
    $sql = "SELECT * FROM user WHERE user_id LIKE '%".$user_id."%'";
    $query = $con->query($sql);
} 
else {
    $sql = "SELECT *, c_name FROM user, coupon where user.coupon_hold = coupon.`Coupon_id`";
    $query = $con->query($sql);
}
//delete
if (isset($_POST['delete'])) {
     $sql = "Delete from user where user_id = '".$user_id."'; set @auto_id = 0;UPDATE user set user_id = (@auto_id := @auto_id +1);
    ALTER TABLE user AUTO_INCREMENT = 1;" ;
     $query1=$con->exec($sql);
     if($query1){
        echo "delete success";
    }else{
        echo "Error: dele " ;
    }
    $sql = "SELECT *, c_name FROM user, coupon where user.coupon_hold = coupon.`Coupon_id`";
    $query = $con->query($sql);
} 

//update
if(isset($_POST['update'])){
$sql = "update user set coupon_hold='{$coupon_hold}' 
where user_id={$user_id}" ;
$query1 = $con->query($sql);
if($query1){
        echo "update success";
    }else{
        echo "Error:up " ;
    }
    $sql = "SELECT *, c_name FROM user, coupon where user.coupon_hold = coupon.`Coupon_id`";
    $query = $con->query($sql);

}

?>

<?php

namespace app\controller;

use pdo\Pdo;
use think\facade\Config;

class update_customer
{

    /*更新顾客信息*/
    public function index()
    {
        
                 // 创建 PDO 连接
                //open database by PDO
        $dbms='sqlite';     //DBMS type
        $host=''; //Host name
        $dbName='数据库名字叫啥.db';    //database name
        $user='';      //database user
        $pass='';          //database password
        $dsn="$dbms:$dbName";

        try {
            $con = new PDO($dsn, $user, $pass);
        } catch (PDOException $e) {
            die ("Error!: " . $e->getMessage() . "<br/>");
        }


        // 获取请求参数
        $id = $_POST['id'];
        $name = $_POST['name'];
        $address = $_POST['address'];
        $payment = $_POST['payment'];

        // SQL，更新 tb_customer_info 表中 id 为 $id 的
        $sql = "SELECT * FROM tb_customer_info WHERE  id=? and user_nickname=? and default_address=? and default_payment_type=?";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$id,$name, $address, $payment]);
        //$order_list = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if ($result) {
            // 更新成功
            return json(['code' => 200, 'result' =>[]],200);
        } else {
            // 更新失败
            return json(['code' => 404, 'result' => 'fail'],404);
        }

    }

}

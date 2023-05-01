<?php

namespace app\controller;

use pdo\Pdo;
use think\facade\Config;

class get_order_history
{
    /*分页获取某用户的订单历史*/
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
        $customerId = $_GET['customerId'];
        $page = $_GET['page'];
        $limit = $_GET['limit'];

        // 计算数据库查询语法中的 offset 和 limit 参数
        $offset = ($page - 1) * $limit;

        // 查询 tb_order 表和 tb_customer_info 表，获取某个用户的订单历史
        $sql_customer =
        "SELECT 
            user_id as id, user_nickname as name, default_address as address, default_payment_type as payment
        FROM 
            tb_customer_info 
        WHERE 
            id=?";
        $stmt_customer = $pdo->prepare($sql_customer);
        $stmt_customer->execute([$customerId]);
        $customer_info = $stmt_customer->fetch(\PDO::FETCH_ASSOC);

        // 查询当前页的用户信息
        $stmt_order = $pdo->prepare(
        'SELECT 
            id, time, user_id as userId, shipping_address as address, status, tracking_number as trackingNumber
            FROM 
                tb_order 
            WHERE 
                user_id=:customerId 
            LIMIT :limit OFFSET :offset');
        $stmt_order->bindParam(':customerId', $customerId, \PDO::PARAM_INT);
        $stmt_order->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt_order->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt_order->execute();
        $order_list = $stmt_order->fetchAll(\PDO::FETCH_ASSOC);

        // 查询满足条件的订单数目
        $sql_total = "SELECT COUNT(*) AS count FROM tb_order WHERE user_id=?";
        $stmt_total = $pdo->prepare($sql_total);
        $stmt_total->execute([$customerId]);
        $total = $stmt_total->fetch(\PDO::FETCH_ASSOC)['count'];

        // 返回响应数据
        if ($customer_info && $order_list) {
            $response_data = [
                'customer' => $customer_info,
                'list' => $order_list,
                'total' => $total,
            ];
            return json(['code' => 200, 'result' => $response_data],200);
        } else {
            return json(['code' => 404, 'result' => "fail"],404);
        }

    }

}

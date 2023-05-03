<?php

//update-customer
    /**更新顾客信息*/
  
        // 创建 PDO 连接
         try {
            $pdo = new PDO("mysql:host=localhost; dbname=testcostumer","root","");
        } catch (PDOException $e) {
            die ("Error!: " . $e->getMessage() . "<br/>");
        }

        $request_body = file_get_contents('php://input');
        $data = json_decode($request_body, true);

        // 获取请求参数
        $id = isset($data['id'])?$data['id']:'';
        $name = isset($data['name'])?$data['name']:'';
        $address = isset($data['address'])?$data['address']:'';
        $payment = isset($data['payment'])?$data['payment']:'';

        if(!empty($id) && !empty($name) && !empty($address) && !empty($payment)){
            // 构造 SQL 语句，更新 tb_customer_info 表中 id 为 $id 的记录
            $sql = "SELECT * FROM tb_customer_info WHERE  id=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);
            $customer_info = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            if($customer_info){
                // 构造 SQL 语句，更新 tb_customer_info 表中 id 为 $id 的记录
                $sql = "UPDATE tb_customer_info SET user_nickname=?, default_address=?, default_payment_type=? WHERE id=?";
                $stmt = $pdo->prepare($sql);
                $res = $stmt->execute([$name, $address, $payment, $id]);
                if ($res!=false) {
                    // 更新成功
                    $result['code']=200;
                    $result['message']="success";
                    echo json_encode($result);
                } else {
                    // 更新失败
                    $result['code']=404;
                    $result['message']="fail";
                    echo json_encode($result);
                }
            }else{
                // 更新失败
                $result['code']=404;
                $result['message']="fail";
                echo json_encode($result);
            }
        }else{
            // 更新失败
            $result['code']=404;
            $result['message']="fail";
            echo json_encode($result);
        }
?>

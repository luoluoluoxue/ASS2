<?php
//get-customer
    /**根据分页信息获取用户*/

        // 创建 PDO 连接
        /*$config=Config::get('database')['connections']['mysqlPDO'];
        $pdo = new \PDO("mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}",$config['user'],$config['password']);*/

        try {
            $pdo = new PDO("mysql:host=localhost; dbname=ass2","root","");
        } catch (PDOException $e) {
            die ("Error!: " . $e->getMessage() . "<br/>");
        }
        
        // 获取请求参数
        $page = $_GET['page']; // 默认为第一页
        $limit = $_GET['limit']; // 默认一次请求 ** 条数据

        // 计算分页偏移量
        $offset = ($page - 1) * $limit;

        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        // 查询当前页的用户信息
        $stmt = $pdo->prepare('SELECT user_id as id, user_nickname as name, default_address as address, default_payment_type as payment FROM tb_customer_info LIMIT :limit OFFSET :offset');
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        $list = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // 查询 tb_customer_info 表中总条目数
        $countStmt = $pdo->prepare('SELECT COUNT(*) FROM tb_customer_info');
        $countStmt->execute();
        $total = $countStmt->fetchColumn();
        $list=[
            'list' => $list,
            'total' => $total
        ];
        // 返回响应数据
        if (isset($list['list']) && isset($list['total']) && !empty($list['list']) && !empty($list['total'])){
            $result['code']=200;
            $result['message']="success";
            $data['list']=$list['list'];
            $data['total']=$total;
            $result['data']=$data;
            echo json_encode($result);
        }else{
            $result['code']=404;
            $result['message']="fail";
            echo json_encode($result);
        }
?>

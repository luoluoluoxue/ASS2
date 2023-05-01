<?php



class get_customer
{

    /*根据分页信息获取用户*/
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
        $page = input('get.page/d', 1); // 默认为第一页
        $limit = input('get.limit/d'); // 默认一次请求 ** 条数据

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
            return json(['code' => 200, 'result' => $list],200);
        }else{
            return json(['code' => 404, 'result' => "fail"],404);
        }

    }

}

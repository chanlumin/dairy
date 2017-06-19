<?php
/**
 * Created by PhpStorm.
 * User: clm
 * Date: 2017/6/17
 * Time: 0:00
 */
require_once __DIR__ . '/ERRORCode.php';

class User
{
    /**
     * 数据库链接句柄
     * @var
     */
    private $_db;

    /**
     * 构造方法
     * User constructor.
     * @param $db PDO链接句柄
     */
    public function __construct($_db)
    {
        $this->_db = $_db;
    }

    /**
     * 用户登录
     * @param $username
     * @param $password
     */
    public  function login($username, $password)
    {
        if(empty($username)) {
            throw new Exception('用户名不能为空', ERRORCode::USERNAME_CANNOT_EMPTY);
        }
        if(empty($password)) {
            throw  new Exception('密码不能为空', ERRORCode::PASSWORD_CANNOT_EMPTY);
        }
        $sql= 'select * from `user` WHERE `user_name` = :user_name AND `password` = :password';
        $password = $this->_md5($password);
        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam('user_name', $username);
        $stmt->bindParam('password', $password);
        if(!$stmt->execute()) {
            throw  new Exception('服务器内部错误',ERRORCode::SERVER_INTERNAL_ERROR);
        }
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if(empty($user)) {
            throw new Exception('用户名或密码错误',ERRORCode::USERNAME_OR_PASSWORD_ERROR);
        }
        unset($user['password']);
        return $user;
    }

    /**
     * 用户注册
     * @param $username
     * @param $password
     */
    public function  register($username, $password)
    {
        if(empty($username)) {
            throw new Exception('用户名不能为空',ERRORCode::USERNAME_CANNOT_EMPTY);
        }
        if(empty($password)) {
            throw  new Exception('密码不能为空', ERRORCode::PASSWORD_CANNOT_EMPTY);
        }
        if($this->_isUsernameExists($username)) {
            throw new Exception('用户名字已经存在', ERRORCode::USERNAMEW_EXISTS);
        }
        $sql = 'INSERT INTO  `user`(`user_name`,`password`,`create_time`) VALUES (:user_name,:password,:create_time)';
        $createTime = time();
        $password = $this->_md5($password);
        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(':user_name', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':create_time', $createTime);

        if(!$stmt->execute()) {
            throw new Exception('注册失败', ERRORCode::REGISTER_FAIL);
        }
        return [
            'userId' => $this->_db->lastInsertId(),
            'userName' => $username,
            'createdtime' => $createTime
        ];

    }

    /**
     * md5 加密
     * @param $string
     * @param string $key
     * @return string
     */
    private function _md5($string, $key = 'zhoufan')
    {
        return md5($string . $key);
    }

    private function _isUsernameExists($username)
    {
        $sql = 'SELECT * from `user` WHERE `user_name` = :user_name';
        $stmt = $this->_db->prepare($sql); // 预处理
        $stmt->bindParam(':user_name', $username); // 绑定参数
        $stmt->execute(); // 执行查询
        $result = $stmt->fetch(PDO::FETCH_ASSOC); // 以关联数组返回
        return !empty($result); // 如果$result 不为空表示用户名存在；
    }
}
<?php
/* 
 * User类
 *  
 *  */
require_once '/ErrorCode.php';
class User{
    private $_code = 201;
    /* 要传一个资源句柄 */
    private $_db;
    /* 构造方法  并且初始化*/
    public function __construct($_db){
        $this->_db=$_db;
    }
    public function login($username, $password){
        if (empty($username)){
            throw new Exception('用户名不能为空', ErrorCode::USERNAME_NOT_EMPTY);
        }
      
        if (empty($password)){
            throw new Exception('密码不能为空', ErrorCode::PASSWORD_NOT_EMPTY);
        }
        $sql = "SELECT * FROM `users` WHERE `username`=:username AND `password`=:password";
        $password = $this->_md5($password);
        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
       
        if (empty($user)){
            throw new Exception('用户名或密码错误', ErrorCode::USERNAME_PASSWORD_NOT_EMPTY);
        }
        unset($user['password']);
        return $user;
    }
    public function regist($username, $password){
        /* 因为用户名是唯一的 所以要检测用户名是否存在 所以这里要定义一个私有方法来检测 return $this->isUsernameUnique($username);*/
       if (empty($username)){
           throw new Exception('用户名不能为空', ErrorCode::USERNAME_NOT_EMPTY);
       } 
        if ($this->isUsernameUnique($username)){
            throw new Exception("用户名已存在", ErrorCode::USERNAME_EXISTS);
        }
        if (empty($password)){
            throw new Exception('密码不能为空', ErrorCode::PASSWORD_NOT_EMPTY);
        }
        /* 写入数据库 */
        $sql = "INSERT INTO `users` (`username`, `password`, `createdAt`) VALUES 
            (:username, :password, :createdAt)";
        $createdAt = time();
        $password =  $this->_md5($password);
        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(':username', $username);
//         $stmt->bindParam('password', $this->_md5($password));不能直接用这个返回值 Call to undefined function _md5() in 
        $stmt->bindParam('password', $password);
        $stmt->bindParam('createdAt', $createdAt);
        if (!$stmt->execute()){
            throw new Exception('注册失败', ErrorCode::REGIST_NOT);
        }
        
        return [
            'user_id' => $this->_db->lastInsertId(),//用这个方法不用到数据库中读取了
            'username' => $username,
            'createdAt' => $createdAt
        ];
    }
    
    /* 自己组装一个md5加密 */
    public function _md5($string, $key='imooc'){
        return md5($string.$key);
    }
    /*  
     * 检测用户名是不是唯一的
     * 
     * 
     * */
    private function isUsernameUnique($username){
        $sql = "SELECT * FROM `users` WHERE `username`=:username";
        $stmt = $this->_db->prepare($sql);//预处理语句
        $stmt->bindParam(':username', $username);
        $stmt->execute();//执行语句
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return !empty($result);
    }
    
}

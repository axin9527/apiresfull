<?php
require_once __DIR__.'/ErrorCode.php';

class Article{
    /**
    * 函数用途描述 数据库句柄
    * @param string 
    * 
    */
    private $_db;
    
    /* 构造方法  并且初始化*/
    public function __construct($_db){
        $this->_db=$_db;
    }
   /**
   * 函数用途描述:创建文章
   * @param string title
   * @param string content
   * @param int userId
   * @return ;
   */
    public function create($title, $content, $userId) {
        if (empty($title)){
            throw new Exception('标题不能为空', ErrorCode::TITLE_NOT_EMPTY);
        }
        if(empty($content)){
            throw new Exception('内容不能为空', ErrorCode::CONTENT_NOT_EMPTY);
        }
        $sql = "INSERT INTO `article` (`title`, `content`, `createdAt`, `user_id`) VALUES
            (:title, :content, :createdAt, :userId)";
        $createdAt = time();
        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':createdAt', $createdAt);
        $stmt->bindParam(':userId', $userId);
        if (!$stmt->execute()){
            throw new Exception('发表文章标题或内容错误', ErrorCode::TITLE_CONTENT_WRONG);
        }
       return [
           'articleid' => $this->_db->lastInsertId(),
           'user_id' => $userId,
           'title'  => $title,
           'content'=> $content,
           'createdAt' => $createdAt
       ];
    }
   /**
   * 函数用途描述 :查看一篇文章
   * @param string 
   * @param string
   * @param int $articleId
   * @return ;
   */
    public function view($articleId){
        if (empty($articleId)){
            throw new Exception('文章编号不能为空', ErrorCode::ARTICLEID_NOT_EMPTY);
        }
        $sql = "SELECT * FROM `article` WHERE `articleId`=:id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(':id', $articleId);
        $stmt->execute();
        $article = $stmt->fetch(PDO::FETCH_ASSOC);
        if(empty($article)){
            throw new Exception('文章不存在', ErrorCode::ARTICLE_NOT_EXISTIS);
        }
        return $article;
    }
    /**
    * 函数用途描述
    * @param string $title
    * @param string $content
    * @param int $articleId
    * @param int $userId
    * @return ;
    */
    public function edit($articleId, $title, $content, $userId) {
       $article = $this->view($articleId);
        if ($article['userId'] !== $userId){
            throw new Exception('你无权编辑此文章', ErrorCode::EDIT_NOT_AUTH);
        }
        
    }
   
    public function delete($articleId, $userId) {
        ;
    }
}













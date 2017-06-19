<?php

/**
 * Created by PhpStorm.
 * User: clm
 * Date: 2017/6/17
 * Time: 0:00
 */
require_once __DIR__ . '/ERRORCode.php';

class  Article
{
    /**
     * 数据库句柄
     * @var
     */
    private $_db;

    /**
     * Article constructor.
     * @param $_db
     */
    public function __construct($_db)
    {
        $this->_db = $_db;
    }

    /**
     * 创建文章
     * @param $title
     * @param $content
     * @param $userId
     */
    public function create($title, $content, $userId)
    {
        if(empty($title))
        {
            throw new Exception('文章标题不能为空', ERRORCode::ARTICLE_TITLE_CAN_NOT_BE_NULL);
        }
        if(empty($content))
        {
            throw new Exception('文章内容不能为空', ERRORCode::ARTICLE_CONTENT_CAN_NOT_BE_NULL);
        }
        $sql = 'INSERT `article`(`title`, `content`,`user_id`,`create_time`) VALUES(:title,:content,:userId, :createTime)';
        $createTime =time();
        $stmt = $this->_db->prepare($sql);
        // 绑定冒号要用上
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':createTime', $createTime);
        if(!$stmt->execute())
        {
            throw new Exception('文章发表失败', ERRORCode::ARTICLE_CREATE_FAIL);
        }
        return [
            'articleId' => $this->_db->lastInsertId(),
            'title' => $title,
            'content' => $content,
            'userId' => $userId,
            'createTime'=> $createTime
        ];
    }

    public function view($articleId)
    {
        if(empty($articleId))
        {
            throw new Exception('文章ID不能为空', ERRORCode::ARTICLE_ID_CANNOT_NULL);
        }
        $sql = 'select * from `article` WHERE  `article_id` = :articleId';
        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam('articleId', $articleId);
        $stmt->execute();
        $article = $stmt->fetch(PDO::FETCH_ASSOC);
        if(empty($article))
        {
            throw  new Exception('文章不存在',ERRORCode::ARTICLE_NOT_FOUND);
        }
        return $article;
    }
    /**
     * 修改文章
     * @param $articleId
     * @param $tittle
     * @param $content
     * @param $user_id
     */
    public function edit($articleId, $title, $content, $user_id)
    {
        $article = $this->view($articleId);
        if($article['user_id'] !== $user_id)
        {
            throw new Exception('您无权限编辑该文章',ERRORCode::PERMISSION_DENY);
        }
        $title = empty($title)  ? $article['title'] : $title;
        $content = empty($content) ? $article['content'] : $content;
        if($title === $articleId['content'] && $content === $article['title'])
        {
            return $article;
        }
        $sql = 'UPDATE `article` SET `title`=:title,`content`=:content WHERE `article_id`=:articleId';
        // prepare 错误的话， 那么一般都是$sql错误
        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(':title',$title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':articleId', $articleId);
        if(!$stmt->execute())
        {
            throw new Exception('文章编辑失败',ERRORCode::ARTICLE_EDIT_FAIL);
        }
        return [
            'articleId' => $articleId,
            'title' => $title,
            'content' => $content,
            'createAt' => $article['create_time']
        ];


    }

    /**
     * 删除文章
     * @param $articleId
     * @param $userId
     */
    public function delete($articleId, $userId)
    {
        $article = $this->view($articleId);
        if($article['user_id'] != $userId)
        {
            throw new Exception('没有权限进行操作',ERRORCode::PERMISSION_DENY);
        }
        $sql = 'DELETE FROM `article` WHERE `article_id`=:articleId AND `user_id`=:userId';
        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(':articleId', $articleId);
        $stmt->bindParam(':userId',$userId);
        if(!$stmt->execute())
        {
            throw new Exception('删除失败',ERRORCode::ARTICLE_DELETE_FAIL);
        }
        return true;
    }

    /**
     * 获取文章列表
     * @param $userId
     * @param int $page
     * @param int $size
     */
    public function getList($userId, $page=1, $size=10)
    {
        if($size > 100)
        {
            throw new Exception('分页大小最大为100',ERRORCode::PAGE_SIZE_OVERFLOW);
        }
        $sql = 'SELECT * FROM `article` WHERE `user_id`=:userId LIMIT :limit,:offset';
        $limit = ($page -1) * $size;
        $limit < 0 ? 0 : $limit;
        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(':userId',$userId);
        $stmt->bindParam(':limit',$limit);
        $stmt->bindParam(':offset',$size);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
}
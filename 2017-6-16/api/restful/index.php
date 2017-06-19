<?php
/**
 * Created by PhpStorm.
 * User: clm
 * Date: 2017/6/18
 * Time: 2:00
 */
require_once __DIR__ . '/../lib/user.php';
require_once __DIR__ . '/../lib/article.php';
$pdo = require_once  __DIR__ .'/../lib/db.php';

class Restful
{
    /**
     * @var user;
     */
    private $_user;

    /**
     * @var article
     */
    private $_article;

    /**
     * 请求资源的方法
     * @var
     */
    private $_requrestMethod;
    /**
     * 请求的资源名称
     * @var
     */
    private $_resourceName;
    /**
     * 请求资源的名称
     * @var
     */
    private $_id;

    /**
     * 允许请求的资源列表
     * @var array
     */
    private  $_allowResource = ['users','articles'];

    /**
     * @var array
     * 允许请求的HTTP方法
     */
    private  $_allowRequestMethods = ['GET','POST','PUT','DELETE','OPTIONS'];

    /**
     * 常用的状态
     * @var array
     */
    private  $_statusCodes = [
        200 => 'OK',
        204 => 'No Content',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        500 => 'Server Internal Error'
    ];
    public function __construct($_user, $_article)
    {
        $this->_user = $_user;
        $this->_article = $_article;
    }
    public function run()
    {
        try {
            $this->_setupRequestMethod();
            $this->_setupResource();
            if($this->_resourceName === 'users')
            {
                 $this->_json($this->_handleUser());
            } else {
                 $this->_json($this->_handleArticle());
            }

        } catch (Exception $e) {
            $this->_json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * 初始化请求方法
     */
    private function _setupRequestMethod()
    {
        $this->_requrestMethod = $_SERVER['REQUEST_METHOD'];
        if(!in_array($this->_requrestMethod , $this->_allowRequestMethods))
        {
            throw  new Exception('请求方法不被允许',405);
        }
    }

    /**
     * 初始化请求资源
     */
    private  function _setupResource()
    {
        $path  = $_SERVER['PATH_INFO'];
        $params = explode('/',$path);
        $this->_resourceName = $params[1];
        if(!in_array($this->_resourceName, $this->_allowResource))
        {
            throw new Exception('请求资源不被允许',400);
        }
        if(!empty($params[2]))
        {
            $this->_id = $params[2];
        }

    }
//echo 'hello';
//var_dump($raw);
//exit(0);
    /**
     * 输出JSON
     * @param $array
     */
    private function _json($array, $code = 0)
    {
//        if($code > 0 && $code != 200 &&  $code != 204 ) {
//            // 如果HTTP/1.1  后面没有空格的话 就会报服务器错误
//
//            header('HTTP/1.1 ' . $code . ' ' . empty($this->_statusCodes[$code]) ? '': $this->_statusCodes[$code] );
//        }
        if($array === null && $code == 0)
        {
            $code = 204;
        }
        if($array !== null && $code === 0)
        {
            $code = 200;
        }
        header('Content-Type:application/json,charset=utf-8');
        header('HTTP/1.1 ' . $code . ' ' . $this->_statusCodes[$code]);
        // 不要讲JSON格式输出为UTF8格式
        if(!$array !== null)
        {
            echo json_encode($array, JSON_UNESCAPED_UNICODE);
        }
        exit();
    }

    /**
     * 请求用户资源
     */
    private function _handleUser()
    {
        if ($this->_requrestMethod != 'POST') {
            throw  new Exception('请求方法不被允许', 405);
        }
        //
        $body = $this->_getBodyParams();
        // JSON数据$_POST是接收不到的，
        if (empty($body['username']))
        {
            throw  new Exception('用户名字不能为空', 400);
        }
        if(empty($body['password']))
        {
            throw  new Exception('密码不能为空', 400);
        }

        return $this->_user->register($body['username'], $body['password']);
    }

    /**
     * 请求文章资源
     */
    private function _handleArticle()
    {
        switch ($this->_requrestMethod)
        {
            case 'POST' : 
                return $this->_handleArticleCreate();
            case 'PUT' : 
                return $this->_handleArticleEidt();
            case 'DELETE':
                return $this->_handleArticleDelete();
            case 'GET':
                if(empty($this->_id))
                {
                    return $this->_handleArticleList();
                } else {
                    return $this->_handleArticleView();
                }
            default:
                throw new Exception('请求的方法不被允许',405);
        }
    }

    /**
     * 获取请求体参数
     */
    private function _getBodyParams()
    {
        $raw = file_get_contents('php://input');
        if(empty($raw))
        {
            throw new Exception('请求参数错误',400);
        }
        return json_decode($raw, true);
    }

    /**
     * 创建文章
     */
    private function _handleArticleCreate()
    {
        $body = $this->_getBodyParams();
        if(empty($body['title']))
        {
            throw new Exception('文章标题不能为空',400);
        }
        if(empty($body['content']))
        {
            throw new Exception('文章内容不能为空', 400);
        }
        $user = $this->_userLogin(empty($body['username'])  ? '' : $body['username'],empty($body['password'])  ? '' : $body['password'] );
        try {
            $article = $this->_article->create($body['title'], $body['content'], $user['user_id']);
            return $article;
        } catch (Exception $e) {
            if(in_array($e->getCode(), [
                ERRORCode::ARTICLE_TITLE_CAN_NOT_BE_NULL,
                ERRORCode::ARTICLE_CONTENT_CAN_NOT_BE_NULL,
            ])) {
                throw new Exception($e->getMessage(), 400);
            }
            throw new Exception($e->getMessage(), 500);
        }
    }

    private function _handleArticleEidt()
    {
        $body = $this->_getBodyParams();
        $user = $this->_userLogin(empty($body['username']) ? '' : $body['password'], empty($body['password']) ? '' :  $body['password']);
        try {
            $article = $this->_article->view($this->_id);
            if($article['user_id'] != $user['user_id'])
            {
                throw new Exception('您无权限编辑', 403);
            }
            $title = empty($body['title']) ? $article['title'] : $body['title'];
            $content = empty($body['content']) ? $article['content'] : $body['content'];
            if($title == $article['content'] && $content == $article['content'])
            {
                return $article;
            }
            return $this->_article->edit($article['article_id'], $title, $content,$user['user_id']);
        } catch (Exception $e)
        {
            if($e->getCode() < 100)
            {
                if($e->getCode() == ERRORCode::ARTICLE_NOT_FOUND)
                {
                    throw new Exception($e->getMessage(), 404);
                } else {
                    throw new Exception($e->getMessage(), 400);
                }
            } else {
                throw $e;
            }
        }
    }

    private function _handleArticleDelete()
    {
        $body = $this->_getBodyParams();
        $user = $this->_userLogin(empty($body['username']) ? '' : $body['password'], empty($body['password']) ? '' :  $body['password']);
        try {
            $article = $this->_article->view($this->_id);
            if($article['user_id'] != $user['user_id']) {
                throw new Exception('您无权限编辑',403);
            }
            $this->_article->delete($article['article_id'], $user['user_id']);
            // 返回的数据 是传递给JSON的
            return null;
        } catch (Exception $e)
        {
            if($e->getCode() < 100)
            {
                if($e->getCode() == ERRORCode::ARTICLE_NOT_FOUND)
                {
                    throw new Exception($e->getMessage(), 404);
                } else {
                    throw new Exception($e->getMessage(), 400);
                }
            } else {
                throw $e;
            }
        }
    }

    private function _handleArticleList()
    {
//        $body = $this->_getBodyParams();
        $user = $this->_userLogin('zhoufan','zhoufan');

        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $size = isset($_GET['size']) ? $_GET['size'] : 10;
        if($size > 100)
        {
            throw  new Exception('分页大小最大为100',400);
        }
        return $this->_article->getList($user['user_id'], $page, $size);
    }

    /**
     * 查看文章 不需要登录 只需要提供ID就可以了
     */
    private function _handleArticleView()
    {
        try {
            return $this->_article->view($this->_id);
        } catch (Exception $e)
        {
            if($e->getCode() == ERRORCode::ARTICLE_NOT_FOUND)
            {
                throw new Exception($e->getMessage(), 404);
            } else {
                throw  new Exception($e->getMessage(), 500);
            }
        }
    }

    /**
     * 用户登录
     * @param $PHP_AUTH_USER
     * @param $PHP_AUTH_PW
     */
    private function _userLogin($PHP_AUTH_USER, $PHP_AUTH_PW)
    {
        try {
            return $this->_user->login($PHP_AUTH_USER, $PHP_AUTH_PW);
        } catch (Exception $e)
        {
            if(in_array($e->getCode(),[
                ERRORCode::PASSWORD_CANNOT_EMPTY,
                ERRORCode::USERNAME_CANNOT_EMPTY,
                ERRORCode::USERNAME_OR_PASSWORD_ERROR,
            ])) {
                //　认为的三种状态码　抛出400状态码
                throw new  Exception($e->getMessage(),400);
            }
            throw new Exception($e->getMessage(),500);
        }
    }
}

$user = new User($pdo);
$article = new Article($pdo);
$restful = new Restful($user, $article);
$restful->run();
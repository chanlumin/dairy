<?php
/**
 * Created by PhpStorm.
 * User: clm
 * Date: 2017/6/17
 * Time: 8:58
 */
class ERRORCode
{
    const USERNAMEW_EXISTS = 1; // 用户名已经存在
    const USERNAME_CANNOT_EMPTY = 2; // 用户名字不能为空
    const PASSWORD_CANNOT_EMPTY = 3; // 密码不能为空
    const REGISTER_FAIL = 4; // 注册失败
    const USERNAME_OR_PASSWORD_ERROR = 5; // 用户名或密码失败
    const ARTICLE_TITLE_CAN_NOT_BE_NULL = 6; // 文章标题不能为空
    const ARTICLE_CONTENT_CAN_NOT_BE_NULL = 7; // 文章内容不能为空
    const ARTICLE_CREATE_FAIL = 8; // 文章内容不能为空
    const ARTICLE_ID_CANNOT_NULL = 9; // 文章ID不能为空
    const ARTICLE_NOT_FOUND = 10; // 文章ID不能为空
    const PERMISSION_DENY = 11; //  无权编辑
    const ARTICLE_EDIT_FAIL = 12; //  文章更新失败
    const ARTICLE_DELETE_FAIL = 13; //  文章删除失败
    const PAGE_SIZE_OVERFLOW = 14; //  分页大小过大
    const SERVER_INTERNAL_ERROR = 15; //  服务器内部错误




}